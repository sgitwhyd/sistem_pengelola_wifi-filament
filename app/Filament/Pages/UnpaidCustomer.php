<?php

namespace App\Filament\Pages;

use App\Models\Customer;
use App\Models\Transaction;
use Carbon\Carbon;
use Filament\Pages\Page;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Filament\Tables;
use Filament\Resources\Pages\ManageRecords;
use pxlrbt\FilamentExcel\Actions\Pages\ExportAction;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
use pxlrbt\FilamentExcel\Columns\Column;

class UnpaidCustomer extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';
    protected static ?string $navigationGroup = 'Data Transaksi';
    protected static ?string $navigationLabel = 'Belum Bayar';

    protected static string $view = 'filament.pages.unpaid-customer';

    protected static ?string $title = 'Pelanggan Belum Membayar Bulan Ini';


    public $unpaidCustomer = [];

    public function mount(): void
    {
        // $now = Carbon::now();
        // $paidCustomerInMonth = Transaction::where('payment_month', $now->monthName)->where('status', 'paid')->where('payment_year', $now->year)->select('customer_id as id')->distinct()->get();
        // $this->unpaidCustomer = Customer::query()->whereNotIn('id', $paidCustomerInMonth->pluck('id'));
    }

    protected function getHeaderActions(): array
    {
        return [
            ExportAction::make()
                ->label('Export Data')
                ->exports([
                    ExcelExport::make()
                        ->fromModel()
                        ->except(['deleted_at', 'updated_at', 'paket_id', 'server_id', 'id', 'created_at'])
                        ->modifyQueryUsing(function ($query) {
                            $now = Carbon::now();
                            $paidCustomerInMonth = Transaction::where('payment_month', $now->monthName)->where('status', 'paid')->where('payment_year', $now->year)->select('customer_id as id')->distinct()->get();
                            return  Customer::query()->whereNotIn('id', $paidCustomerInMonth->pluck('id'));
                        })
                        ->withFilename('Pelanggan Belum Bayar ' . date('Y-m-d'))
                        ->withColumns([
                            Column::make('name')->heading('Nama Pelanggan'),
                            Column::make('paket.name')->heading('Paket Langganan'),
                            Column::make('paket.price')->heading('Total Belum Bayar')
                                ->formatStateUsing(function ($state) {
                                    return 'Rp ' . number_format($state, 0, ',', '.');
                                }),
                            Column::make('paket.information')->heading('Bulan')
                                ->formatStateUsing(function ($state) {
                                    return Carbon::now()->monthName;
                                }),
                        ])
                        ->withWriterType(\Maatwebsite\Excel\Excel::XLS),
                ]),
        ];
    }


    public function table(Table $table): Table
    {
        return $table
            ->query(
                function () {
                    $now = Carbon::now();
                    $paidCustomerInMonth = Transaction::where('payment_month', $now->monthName)->where('status', 'paid')->where('payment_year', $now->year)->select('customer_id as id')->distinct()->get();
                    return Customer::query()->whereNotIn('id', $paidCustomerInMonth->pluck('id'));
                }
            )
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Pelanggan'),
                Tables\Columns\TextColumn::make('paket.name')
                    ->label('Paket Langganan'),
                Tables\Columns\TextColumn::make('paket.price')
                    ->label('Harga Paket')
                    ->numeric()
                    ->prefix('Rp '),
                Tables\Columns\TextColumn::make('alamat')
                    ->label('Bulan')
                    ->formatStateUsing(function ($state) {
                        Carbon::setLocale('id');
                        return Carbon::now()->monthName;
                    }),
            ]);
    }
}
