<?php

namespace App\Filament\Resources\TransactionResource\Pages;

use Filament\Actions;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Excel;
use pxlrbt\FilamentExcel\Columns\Column;
use Filament\Resources\Pages\ManageRecords;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
use App\Filament\Resources\TransactionResource;
use pxlrbt\FilamentExcel\Actions\Pages\ExportAction;

class ManageTransactions extends ManageRecords
{
    protected static string $resource = TransactionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
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
