<?php

use App\Http\Controllers\CheckHistoryPembayaran;
use App\Http\Controllers\DownloadPDFController;
use App\Http\Controllers\TransactionController;
use App\Models\Company;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
})->name('home');


Route::get('/print/{record}/pdf', [DownloadPDFController::class, 'download'])->name('transaction.pdf.download');


Route::group(['prefix' => 'cek-pembayaran', 'as' => 'cek-pembayaran.'], function () {
    Route::get('/', [CheckHistoryPembayaran::class, 'index'])->name('index');
    Route::get('/{user}', [CheckHistoryPembayaran::class, 'show'])->name('show');
});


Route::group(['prefix' => 'pembayaran', 'as' => 'pembayaran.'], function () {
    Route::get('/', [TransactionController::class, 'index'])->name('index');
    Route::get('/{name}', [TransactionController::class, 'checkName'])->name('check-name');
    Route::post('/', [TransactionController::class, 'store'])->name('store');
});
