<?php

namespace App\Filament\Resources\TransactionResource\Pages;

use App\Filament\Resources\CustomerResource;
use Filament\Actions;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Excel;
use pxlrbt\FilamentExcel\Columns\Column;
use Filament\Resources\Pages\ManageRecords;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
use App\Filament\Resources\TransactionResource;
use App\Models\Transaction;
use Illuminate\Support\HtmlString;
use Konnco\FilamentImport\Actions\ImportAction;
use Konnco\FilamentImport\Actions\ImportField;
use pxlrbt\FilamentExcel\Actions\Pages\ExportAction;

class ManageTransactions extends ManageRecords
{
    protected static string $resource = TransactionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            ImportAction::make()
                ->fields([
                     ImportField::make('customer_id')
                        ->required(),
                     ImportField::make('status')
                        ->required(),
                     ImportField::make('payment_month')
                        ->required(),
                     ImportField::make('payment_year')
                        ->required(),
                ])
                 ->modalDescription(
                     new HtmlString(view('modal-import-description.transaction'))
                 )
                ->modalHeading('Import Data Transaction')
                ->handleRecordCreation(function (array $data) {
                    if($customer = CustomerResource::getEloquentQuery()->where('id', $data['customer_id'])->first()) {
                        return Transaction::create([
                            'customer_id' => $data['customer_id'],
                            'status' => $data['status'],
                            'payment_month' => $data['payment_month'],
                            'payment_year' => $data['payment_year'],
                            'paket' => $customer->paket->name,
                            'package_price' => $customer->paket->price
                        ]);
                    }

                    return new Transaction();
                })
            ,
            ExportAction::make()
            ->exports([
                ExcelExport::make()
                    ->fromTable()
                    ->askForFilename()
                    ->withFilename(fn ($filename) =>  $filename. ' ' . date('Y-m-d'))
                    ->except([
                            'no'
                        ])
                    ->withColumns([
                         Column::make('payment_proof_image')->heading('Bukti Pembayaran')
                     ->formatStateUsing(fn ($record) => url('/') . '/storage/' . $record->payment_proof_image)
                    ])
                    ->withWriterType(\Maatwebsite\Excel\Excel::XLS)
                 
            ]),
        ];
    }
}
