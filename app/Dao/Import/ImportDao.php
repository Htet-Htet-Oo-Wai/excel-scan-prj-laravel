<?php

namespace App\Dao\Import;

use App\Contracts\Dao\Import\ImportDaoInterface;
use Exception;
use Illuminate\Support\Facades\DB;
use App\Models\AnalyzedData;


/**
 * Data Access Object for Import 
 */
class ImportDao implements ImportDaoInterface
{
    /**
     * To save excel data to dtb_analyzed_datas
     * @param array $analyzedData
     */
    public function saveExcelData($analyzedData)
    {
        try {
            DB::beginTransaction();
            if (!empty($analyzedData)) {
                foreach ($analyzedData as $key3 => $datas) {
                    if ($key3 == 'DEPARTMENT') {
                        continue;
                    }
                    foreach ($datas as $data) {
                        $importData = new AnalyzedData();
                        $importData->department = strtoupper($analyzedData['DEPARTMENT']);
                        $importData->equipment_type = $key3;
                        $importData->item_category = $data['item_category'];
                        $importData->item_sub_category = $data['item_sub_category'];
                        $importData->demand_qty = (int)$data['demand_qty'];
                        $importData->demand_unit = preg_replace("/\d/u", "", $data['demand_qty']);
                        $importData->demand_unit_price = $data['demand_unit_price'];
                        $importData->demand_total_price = $data['demand_total_price'];
                        $importData->save();
                    }
                }
            }
            DB::commit();
        } catch (Exception $e) {
            die($e);
            DB::rollback();
        }
    }

    /**
     * To get total amount grouping by equipment type
     */
    public function getAmountByEquipmetType()
    {
        return AnalyzedData::groupBy('equipment_type')
            ->selectRaw('sum(demand_total_price) as total_amount, equipment_type')
            ->get();
    }

    /**
     * To get total qty of items grouping by item SubCategory
     */
    public function getTotalQuantityBySubCategory()
    {
        return AnalyzedData::groupBy('item_sub_category')
            ->selectRaw('count(*) as total_quantity, item_sub_category')->get();
    }

    /**
     * To get annual qty of items grouping with department and item subcategory
     */
    public function getTotalQtyBySubCategoryAndDepartment()
    {
        return AnalyzedData::groupBy('item_sub_category', 'department')
            ->selectRaw('department, count(*) as total_quantity, item_sub_category')
            ->orderby('department')
            ->get();
    }
}
