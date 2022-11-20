<?php

namespace App\Services\Import;

use App\Contracts\Services\Import\ImportServiceInterface;
use App\Contracts\Dao\Import\ImportDaoInterface;

/**
 * Service class for import
 */
class ImportService implements ImportServiceInterface
{
    private $importDao;

    /**
     * Class Constructor
     * @param ImportDaoInterface
     * @return
     */
    public function __construct(
        ImportDaoInterface $importDao
    ) {
        $this->importDao = $importDao;
    }

    /**
     * To get total amount grouping by equipment type
     */
    public function getAmountByEquipmetType()
    {
        return $this->importDao->getAmountByEquipmetType();
    }

    /**
     * To get total qty of items grouping by item SubCategory
     */
    public function getTotalQuantityBySubCategory()
    {
        return $this->importDao->getTotalQuantityBySubCategory();
    }

    /**
     * To get annual qty of items grouping with department and item subcategory
     */
    public function getTotalQtyBySubCategoryAndDepartment()
    {
        return $this->importDao->getTotalQtyBySubCategoryAndDepartment();
    }
}
