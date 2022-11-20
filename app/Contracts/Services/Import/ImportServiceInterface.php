<?php

namespace App\Contracts\Services\Import;

/**
 * Interface of Import Service
 */
interface ImportServiceInterface
{
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
