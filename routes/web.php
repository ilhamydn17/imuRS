<?php

use App\Models\IndikatorMutu;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChartJsController;
use App\Http\Controllers\IndikatorMutuController;
use App\Http\Controllers\PengukuranMutuController;
use App\Http\Controllers\UnitController;
use Database\Seeders\IndikatorMutuSeeder;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


// FOR APPS-------------------------
Route::get('/', function () {
    return view('app.auth.login');
});

// Route::resource('unit', UnitController::class);

Route::middleware(['auth'])->group(function () {
    // Routing indikator mutu
    Route::resource('indikator-mutu', IndikatorMutuController::class)->except('show');
    Route::name('indikator-mutu.showRekap')->get('indikator-mutu/rekap', [IndikatorMutuController::class, 'showRekap']);
    Route::name('indikator-mutu.getRekap')->post('indikator-mutu/getRekap', [IndikatorMutuController::class, 'getRekap']);
    Route::name('indikator-mutu.pdf')->get('indikator-mutu/pdf/{id}/{bulan}', [IndikatorMutuController::class, 'exportPDF']);
    Route::name('indikator-mutu.chart')->get('indikator-mutu/chart/{indikator_id}/{tanggal}', [IndikatorMutuController::class, 'showChart']);
    Route::name('indikator-mutu.exportExcel')->get('indikator-mutu/export-excel/{id}/{bulan}', [IndikatorMutuController::class, 'exportExcel']);

    // Routing pengukuran mutu
    Route::resource('pengukuran-mutu', PengukuranMutuController::class)->except('show');
    Route::name('pengukuran-mutu.inputHarian')->get('pengukuran-mutu/input/{id}', [PengukuranMutuController::class, 'inputHarian']);
});
// -------------------------




