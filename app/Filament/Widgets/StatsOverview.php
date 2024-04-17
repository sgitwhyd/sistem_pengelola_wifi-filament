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
        $firstDayOfMonth = Carbon::now()->firstOfMonth();
        $lastDayOfMonth = Carbon::now()->endOfMonth();
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;



        return [
            Stat::make('Total Pelanggan', Customer::all()->count()),
            Stat::make('Pelanggan Baru Bulan Ini', Customer::whereMonth('created_at', $currentMonth)
                            ->whereYear('created_at', $currentYear)
                            ->count()),
        Stat::make('Total Lunas Pembayaran Bulan Ini', Transaction::whereBetween('created_at', [$firstDayOfMonth, $lastDayOfMonth])->where('status', 'paid')->count()),
        Stat::make('Total Paket ', Paket::count()),
        Stat::make('Total Server', Server::count()),
        Stat::make('Pembayaran Menunggu Konfirmasi', Transaction::where('status', 'pending')->count())
        ];
    }
}
