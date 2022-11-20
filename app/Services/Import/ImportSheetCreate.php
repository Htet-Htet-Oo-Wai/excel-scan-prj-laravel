<?php

namespace App\Services\Import;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use App\Contracts\Dao\Import\ImportDaoInterface;


class ImportSheetCreate implements ToCollection, WithCalculatedFormulas
{
    use Importable;
    protected $sheet_name;
    private $importDao;

    /**
     * Class Constructor
     *
     * @param ImportDaoInterface
     * @return
     */
    public function  __construct(string $sheet_name, ImportDaoInterface $importDao)
    {
        $this->sheet_name = $sheet_name;
        $this->importDao = $importDao;
    }

    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        $analyzed_data = [];
        $equipment_type = null;
        $item_category = null;
        $rows = $collection->toArray();
        foreach ($rows as $key => $row) {
            // slice rows array for null data columns
            $row = array_slice($row, 0, 12);
            if ((preg_match('#\d{1,2}#', $row[1])) && strpos($row[1],"(") == 0 && !(preg_match('#\((\d*)\)#', $row[1])) && $row[2] && !$row[3] && !$row[4] && !$row[5] && !$row[6]) {
                $equipment_type = $row[2];
                if (!(preg_match('#\((\d*)\)#', ($rows[$key + 1][1] . $rows[$key + 1][2] . $rows[$key + 1][3])))) {
                    $analyzed_data[$equipment_type][]['item_category'] = $rows[$key + 1][1] . $rows[$key + 1][2] . $rows[$key + 1][3];
                    $last_index = count($analyzed_data[$equipment_type]) - 1;
                    if ($analyzed_data[$equipment_type][$last_index]['item_category'] && !array_key_exists('item_sub_category', $analyzed_data[$equipment_type][$last_index])) {
                        $analyzed_data[$equipment_type][$last_index]['item_sub_category'] = trim($analyzed_data[$equipment_type][$last_index]['item_category'], " ");
                    }
                    $analyzed_data[$equipment_type][$last_index]['demand_qty'] = (!is_string($rows[$key + 1][5])) ? $rows[$key + 1][4] : $rows[$key + 1][4] . $rows[$key + 1][5];
                    $i = (!is_string($rows[$key + 1][5])) ? 5 : 6;
                    $analyzed_data[$equipment_type][$last_index]['demand_unit_price'] = $rows[$key + 1][$i];
                    $analyzed_data[$equipment_type][$last_index]['demand_total_price'] = $rows[$key + 1][$i + 1];
                }
                continue;
            }
            if ((preg_match('#\d{1,2}#', $row[1])) && strpos($row[1],"(") == 0 && !(preg_match('#\((\d*)\)#', $row[1])) && !$row[2] && !$row[3] && !$row[4] && !$row[5] && !$row[6]) {
                $equipment_type = trim(preg_split('#\d{1,2}#', $row[1])[1], " .");
                if (!(preg_match('#\((\d*)\)#', ($rows[$key + 1][1] . $rows[$key + 1][2] . $rows[$key + 1][3])))) {
                    $last_index = count($analyzed_data[$equipment_type]) - 1;
                    $analyzed_data[$equipment_type][]['item_category'] = $rows[$key + 1][1] . $rows[$key + 1][2] . $rows[$key + 1][3];
                    if ($analyzed_data[$equipment_type][$last_index]['item_category'] && !array_key_exists('item_sub_category', $analyzed_data[$equipment_type][$last_index])) {
                        $analyzed_data[$equipment_type][$last_index]['item_sub_category'] = trim($analyzed_data[$equipment_type][$last_index]['item_category'], " ");
                    }
                    $analyzed_data[$equipment_type][$last_index]['demand_qty'] = (!is_string($rows[$key + 1][5])) ? $rows[$key + 1][4] : $rows[$key + 1][4] . $rows[$key + 1][5];
                    $i = (!is_string($rows[$key + 1][5])) ? 5 : 6;
                    $analyzed_data[$equipment_type][$last_index]['demand_unit_price'] = $rows[$key + 1][$i];
                    $analyzed_data[$equipment_type][$last_index]['demand_total_price'] = $rows[$key + 1][$i + 1];
                }
                continue;
            }

            //get equipment type from analyzed data
            foreach ($row as $key1 => $value) {
                if (strpos($value, "DEPARTMENT") > -1) {
                    $analyzed_data["DEPARTMENT"] = preg_split("/:/", $value)[1];
                    break;
                } else if ((preg_match('#\((\d*)\)#', $value) && ($row[4] || $row[5] || $row[6]))) {
                    $analyzed_data[$equipment_type][]['item_category'] = trim($row[$key1 + 1], " ");
                    $last_index = count($analyzed_data[$equipment_type]) - 1;
                    if ($analyzed_data[$equipment_type][$last_index]['item_category'] && !array_key_exists('item_sub_category', $analyzed_data[$equipment_type][$last_index])) {
                        $analyzed_data[$equipment_type][$last_index]['item_sub_category'] = trim($analyzed_data[$equipment_type][$last_index]['item_category'], " ");
                    }
                    $analyzed_data[$equipment_type][$last_index]['demand_qty'] = (!is_string($row[$key1 + 3])) ? $row[$key1 + 2] : $row[$key1 + 2] . $row[$key1 + 3];
                    $i = (!is_string($row[$key1 + 3])) ? $key1 + 3 : $key1 + 4;
                    $analyzed_data[$equipment_type][$last_index]['demand_unit_price'] = $row[$i];
                    $analyzed_data[$equipment_type][$last_index]['demand_total_price'] = $row[$i + 1];
                    break;
                } else if (preg_match('#\(([a-z])\)#', $value) && strlen(preg_replace('#\(([a-z])\)#', "", $value)) > 0 && ($row[$key1 + 1] || $row[$key1 + 2] || $row[$key1 + 3])) {
                    if ((preg_match('#\((\d*)\)#', $rows[$key - 1][1])) || (preg_match('#\((\d*)\)#', $rows[$key - 1][2]))) {
                        if (strlen(preg_replace('#\((\d*)\)#', "", $rows[$key - 1][1])) > 0) {
                            $analyzed_data[$equipment_type][]['item_category'] = trim(preg_replace('#\((\d*)\)#', "", $rows[$key - 1][1]), " ");
                        } else if (strlen(preg_replace('#\((\d*)\)#', "", $rows[$key - 1][2])) > 0) {
                            $analyzed_data[$equipment_type][]['item_category'] = trim(preg_replace('#\((\d*)\)#', "", $rows[$key - 1][2]), " ");
                        } else if (strlen(preg_replace('#\((\d*)\)#', "", $rows[$key - 1][1])) <= 0 && $rows[$key - 1][2]) {
                            $analyzed_data[$equipment_type][]['item_category'] = trim($rows[$key - 1][2], " ");
                        } else {
                            $analyzed_data[$equipment_type][]['item_category'] = trim($rows[$key - 1][3], " ");
                        }
                        $last_index = count($analyzed_data[$equipment_type]) - 1;
                        $item_category = $analyzed_data[$equipment_type][$last_index]['item_category'];
                    } else {
                        $analyzed_data[$equipment_type][]['item_category'] = $item_category;
                    }
                    $last_index = count($analyzed_data[$equipment_type]) - 1;
                    $analyzed_data[$equipment_type][$last_index]['item_sub_category'] = trim(preg_replace('#\(([a-z])\)#', "", $value), " ");
                    $analyzed_data[$equipment_type][$last_index]['demand_qty'] = (!is_string($row[$key1 + 2])) ? $row[$key1 + 1] : $row[$key1 + 1] . $row[$key1 + 2];
                    $i = (!is_string($row[$key1 + 2])) ? $key1 + 2 : $key1 + 3;
                    $analyzed_data[$equipment_type][$last_index]['demand_unit_price'] = $row[$i];
                    $analyzed_data[$equipment_type][$last_index]['demand_total_price'] = $row[$i + 1];
                    break;
                } else if (preg_match('#\(([a-z])\)#', $value) && strlen(preg_replace('#\(([a-z])\)#', "", $value)) <= 0 && ($row[$key1 + 1] || $row[$key1 + 2] || $row[$key1 + 3])) {
                    $analyzed_data[$equipment_type][]['item_category'] = trim($rows[$key - 1][$key1], " ");
                    $last_index = count($analyzed_data[$equipment_type]) - 1;
                    $analyzed_data[$equipment_type][$last_index]['item_sub_category'] = trim($row[$key1], " ");
                    $analyzed_data[$equipment_type][$last_index]['demand_qty'] = (!is_string($row[$key1 + 2])) ? $row[$key1 + 1] : $row[$key1 + 1] . $row[$key1 + 2];
                    $i = (!is_string($row[$key1 + 2])) ? $key1 + 2 : $key1 + 3;
                    $analyzed_data[$equipment_type][$last_index]['demand_unit_price'] = $row[$i];
                    $analyzed_data[$equipment_type][$last_index]['demand_total_price'] = $row[$i + 1];
                    break;
                }
            }
        }
        $this->importDao->saveExcelData($analyzed_data);
    }
}
