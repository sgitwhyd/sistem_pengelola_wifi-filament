<?php

namespace App\Filament\Widgets;

use App\Models\Transaction;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class TransactionChart extends ChartWidget
{
    protected static ?string $heading;
    protected int | string | array $columnSpan = '2';
    protected static ?string $maxHeight = '500px';


    public function __construct()
    {
        Carbon::setLocale('id');
        self::$heading = 'Jumlah Total Pembayaran Tiap Hari Pada Bulan ' . Carbon::now()->translatedFormat('F');
    }

    protected static ?int $sort = 1;

    protected function getData(): array
    {
        Carbon::setLocale('id');
        $currentMonth = Carbon::now();
        $lastDay = $currentMonth->daysInMonth;

        $arrayDateOfMonth = [];

        for ($day = 1; $day <= $lastDay; $day++) {
            $currentDate = Carbon::create($currentMonth->year, $currentMonth->month, $day);
            $arrayDateOfMonth[] = $currentDate->translatedFormat('l-d-Y');
        }

        $startDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();

        $datesForMonth = collect(Carbon::parse($startDate)->daysUntil($endDate)->toArray());
        $totalTransactionInDate = $datesForMonth->map(
            function ($date) {
                return Transaction::whereDate('created_at', $date->format('Y-m-d'))->count();
            }
        )->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Transaksi',
                    'data' => $totalTransactionInDate,
                ],
            ],
            'labels' => $arrayDateOfMonth,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
