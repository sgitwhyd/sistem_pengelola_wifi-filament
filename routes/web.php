<?php

use App\Http\Controllers\CheckHistoryPembayaran;
use App\Http\Controllers\DownloadPDFController;
use App\Http\Controllers\Filepond;
use App\Http\Controllers\FilepondController;
use App\Http\Controllers\TransactionController;
use App\Models\Paket;
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
    $pakets = Paket::orderBy('price', 'asc')->get();
    return view('welcome', compact('pakets'));
})->name('home');


Route::get('/print/{record}/pdf', [DownloadPDFController::class, 'download'])->name('transaction.pdf.download');


Route::group(['prefix' => 'cek-pembayaran', 'as' => 'cek-pembayaran.'], function () {
    Route::get('/', [CheckHistoryPembayaran::class, 'index'])->name('index');
    Route::get('/{user}', [CheckHistoryPembayaran::class, 'show'])->name('show');
});


Route::group(['prefix' => 'pembayaran', 'as' => 'pembayaran.'], function () {
    Route::get('/', [TransactionController::class, 'index'])->name('index');
    Route::get('/{name}', [TransactionController::class, 'checkName'])->name('show');
    Route::post('/{name}', [TransactionController::class, 'store'])->name('store');
});

// for filepond upload
Route::post('upload', [FilepondController::class, 'upload'])->name('upload');
Route::delete('revert', [FilepondController::class, 'revert'])->name('revert');
