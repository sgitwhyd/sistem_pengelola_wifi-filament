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
    $data = Company::first();
    return view('welcome', [
        'company_logo' => $data->logo,
        'company_name' => $data->name
    ]);
})->name('home');


Route::get('/{record}/pdf', [DownloadPDFController::class, 'download'])->name('transaction.pdf.download');


Route::get('/cek-pembayaran', [CheckHistoryPembayaran::class, 'index'])->name('cek-pembayaran.index');
Route::get('/cek-pembayaran/{user}', [CheckHistoryPembayaran::class, 'show'])->name('cek-pembayaran.show');

Route::get('/pembayaran', [TransactionController::class, 'index'])->name('pembayaran.index');
