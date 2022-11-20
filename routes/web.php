<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Import\ImportController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/upload-data', [ImportController::class, 'uploadExcel'])->name('import.upload-excel');
Route::post('/upload-data', [ImportController::class, 'importExcel'])->name('import.import-excel');
Route::get('/report-excel', [ImportController::class, 'reportExcel'])->name('import.report-excel');
