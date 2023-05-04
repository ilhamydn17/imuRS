<?php

use App\Models\IndikatorMutu;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChartJsController;
use App\Http\Controllers\IndikatorMutuController;
use App\Http\Controllers\PengukuranMutuController;

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


// FOR APPS------------
Route::get('/', function () {
   return view('app.auth.login');
});

Route::middleware(['auth'])->group(function () {
    Route::resource('indikator-menu', IndikatorMutuController::class);
    Route::resource('input-harian', PengukuranMutuController::class);
});
//----------------------


Route::get('test', function () {
    return view('templates.root');
});
