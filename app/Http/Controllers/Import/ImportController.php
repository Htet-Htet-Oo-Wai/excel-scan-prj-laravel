<?php

namespace App\Http\Controllers\Import;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Import\ImportSheetCount;
use App\Services\Import\SheetCreate;
use App\Contracts\Services\Import\ImportServiceInterface;
use App\Contracts\Dao\Import\ImportDaoInterface;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    private $importServiceInterface;
    private $importDao;

    /**
     * Create a new controller instance
     *
     * @param ImportServiceInterface $importServiceInterface
     * @param ImportDaoInterface $importDao
     * @return void
     */
    public function __construct(
        ImportServiceInterface $importServiceInterface,
        ImportDaoInterface $importDao
    ) {
        $this->importService = $importServiceInterface;
        $this->importDao = $importDao;
    }

    /**
     * To show excel upload screen
     *
     * @return View Excel Upload Screen
     */
    public function uploadExcel()
    {
        return view('import.upload-excel');
    }

    /**
     * To store excel upload data
     * @param Request $request
     */
    public function importExcel(Request $request)
    {
        $this->validate($request, array(
            'file'      => 'required'
        ));
        $file = $request->file('file');
        $file_type = $request->file('file')->getClientOriginalExtension();
        if ($file_type == 'xlsx') {

            //count commitment excel sheet
            $sheet_create = new ImportSheetCount();
            Excel::import($sheet_create, $file);
            $sheet_name_list = $sheet_create->getSheetNames();
            $sheet_count = count($sheet_create->getSheetNames());

            //get data array from excel to toArray
            $sheet_import = new SheetCreate($sheet_count, $sheet_name_list, $this->importDao);
            $data = Excel::toArray($sheet_import, $file);
            Excel::import($sheet_import, $file);
            session()->flash('message', 'Recorded Excel Data Successfully');
            return redirect()->to('/upload-data');
        } else {
            session()->flash('message', 'Enter Vaild Excel File');
            return redirect()->to('/upload-data');
        }
    }

    /**
     * To show detail report of excel upload data
     * @return View Detail Report Screen
     */
    public function reportExcel()
    {
        $firstReport = $this->importService->getAmountByEquipmetType();
        $secondReport = $this->importService->getTotalQuantityBySubCategory();
        $thirdReport = $this->importService->getTotalQtyBySubCategoryAndDepartment();
        return view('import.report-excel', compact([
            'firstReport',
            'secondReport',
            'thirdReport'
        ]));
    }
}
