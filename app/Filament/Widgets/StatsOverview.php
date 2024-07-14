<?php

namespace App\Filament\Widgets;

use App\Models\Customer;
use App\Models\Paket;
use App\Models\Server;
use App\Models\Transaction;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 2;

    protected function getStats(): array
    {

        Carbon::setLocale('id');

        $firstDayOfMonth = Carbon::now()->firstOfMonth();
        $lastDayOfMonth = Carbon::now()->endOfMonth();
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;



        $titleCustomer = 'Pelanggan Baru Bulan ' . Carbon::now()->translatedFormat('F');
        $titleLunas = 'Total Lunas Pembayaran Bulan ' . Carbon::now()->translatedFormat('F');

        $totalPaidThisMonth = Transaction::whereBetween('updated_at', [$firstDayOfMonth, $lastDayOfMonth])->where('status', 'paid')
        ->whereNotNull('deleted_at')
        ->count();

        $titleUnpaidThisMonth = 'Total Belum Lunas Bulan ' . Carbon::now()->translatedFormat('F');
        $totalUnpaidThisMonth =  Customer::count() - $totalPaidThisMonth;

        return [
            Stat::make('Total Pelanggan', Customer::all()->count()),
            Stat::make($titleCustomer, Customer::whereMonth('created_at', $currentMonth)
                ->whereYear('created_at', $currentYear)
                ->count()),
            Stat::make($titleLunas, Transaction::whereBetween('updated_at', [$firstDayOfMonth, $lastDayOfMonth])->where('status', 'paid')->count()),
            Stat::make($titleUnpaidThisMonth, $totalUnpaidThisMonth),
            Stat::make('Pembayaran Menunggu Konfirmasi', Transaction::where('status', 'pending')->count()),
            Stat::make('Total Paket Internet ', Paket::count()),
            Stat::make('Total Server', Server::count()),
        ];
    }
}
