<?php

namespace App\Contracts\Dao\Import;

/**
 * Interface of Data Access Object for Import
 */
interface ImportDaoInterface
{
    /**
     * To save excel data to dtb_analyzed_datas
     * @param array $analyzedData
     */
    public function saveExcelData($analyzedData);

    /**
     * To get total amount grouping by equipment type
     */
    public function getAmountByEquipmetType();

    /**
     * To get total qty of items grouping by item SubCategory
     */
    public function getTotalQuantityBySubCategory();

    /**
     * To get annual qty of items grouping with department and item subcategory
     */
    public function getTotalQtyBySubCategoryAndDepartment();

}
