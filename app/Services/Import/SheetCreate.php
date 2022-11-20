<?php

namespace App\Services\Import;

use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Services\Import\ImportSheetCreate;
use App\Contracts\Dao\Import\ImportDaoInterface;

class SheetCreate implements WithMultipleSheets
{
    use Importable;
    protected $response;
    protected $sheet_count;
    protected $sheet_name_list;
    private $importDao;

    public function  __construct(int $sheet_count, array $sheet_name_list, ImportDaoInterface $importDao)
    {
        $this->sheet_count = $sheet_count;
        $this->sheet_name_list = $sheet_name_list;
        $this->importDao = $importDao;
    }

    public function sheets(): array
    {
        $import_data = [];
        for ($i = 0; $i < $this->sheet_count; $i++) {
            $sheet_name = $this->sheet_name_list[$i];

            $data = array(
                $i => new ImportSheetCreate($sheet_name, $this->importDao),
            );
            $import_data = array_merge($import_data, $data);
        }
        return $import_data;
    }
}
