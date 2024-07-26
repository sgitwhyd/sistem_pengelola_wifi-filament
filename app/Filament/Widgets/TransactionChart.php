<?php

namespace App\Filament\Widgets;

use App\Models\Customer;
use App\Models\Transaction;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\ToArray;

class TransactionChart extends ChartWidget
{
    protected static ?string $heading;
    protected int | string | array $columnSpan = '2';
    protected static ?string $maxHeight = '500px';


    public function __construct()
    {
        Carbon::setLocale('id');
        self::$heading = 'Jumlah Total Pembayaran Tiap Bulan Tahun ' . Carbon::now()->year;
    }

    protected static ?int $sort = 1;

    protected function getData(): array
    {
        Carbon::setLocale('en_EN');
        $now = Carbon::now();

        $months = collect(
            array_map(
                fn ($month) => Carbon::create($now->year, $month, 1)->translatedFormat('F'),
                range(1, 12)
            )
        )->toArray();

        $results = [];

        foreach ($months as $month) {
            $results[] = Transaction::where('payment_month', $month)->where('status', 'paid')
                ->where('payment_year', $now->year)
                ->count();
        }

        $indonesianMonths = [
            0 => 'Januari',
            1 => 'Februari',
            2 => 'Maret',
            3 => 'April',
            4 => 'Mei',
            5 => 'Juni',
            6 => 'Juli',
            7 => 'Agustus',
            8 => 'September',
            9 => 'Oktober',
            10 => 'November',
            11 => 'Desember',


        ];


        $paidCustomerInMonth = Transaction::where('payment_month', $now->monthName)->where('status', 'paid')->where('payment_year', $now->year)->
        select('customer_id as id')->distinct()->get();

        $unpaidCustomerInMonth = Customer::with('paket')->whereNotIn('id', $paidCustomerInMonth->pluck('id'))->get();


        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Transaksi',
                    'data' => $results,
                ],
            ],
            'backgroundColor' => '#4c51bf',
            'labels' => $indonesianMonths,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
