<?php

namespace App\Services\Import;

use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeSheet;

HeadingRowFormatter::default('none');

class ImportSheetCount implements WithHeadingRow, WithEvents
{
    private $sheetNames;

    public function __construct()
    {
        $this->sheetNames = [];
    }
    public function registerEvents(): array
    {
        return [
            BeforeSheet::class => function (BeforeSheet $event) {
                $this->sheetNames[] = $event->getSheet()->getTitle();
            }
        ];
    }

    public function getSheetNames()
    {
        return $this->sheetNames;
    }
}
