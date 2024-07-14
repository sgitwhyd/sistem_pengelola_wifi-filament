<?php

namespace App\Filament\Resources\CustomerResource\Pages;

use App\Filament\Resources\CustomerResource;
use App\Filament\Resources\PaketResource;
use App\Filament\Resources\ServerResource;
use App\Models\Customer;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Support\Carbon;
use Illuminate\Support\HtmlString;
use Konnco\FilamentImport\Actions\ImportField;
use Konnco\FilamentImport\Actions\ImportAction;
use pxlrbt\FilamentExcel\Actions\Pages\ExportAction;
use pxlrbt\FilamentExcel\Columns\Column;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
use stdClass;

class ManageCustomers extends ManageRecords
{
    protected static string $resource = CustomerResource::class;


    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
            ,
            ImportAction::make()
                ->label('Import Data Customer')
                ->uniqueField('name')
                ->fields([
                    ImportField::make('name')
                        ->required(),
                    ImportField::make('alamat')
                        ->required(),
                    ImportField::make('no_hp')
                        ->required(),
                    ImportField::make('paket')
                        ->label('Paket')
                        ->required(),
                    ImportField::make('server')
                        ->label('Server')
                        ->required(),
                    ImportField::make('ip_address')
                        ->label('Ip Address')
                        ->required(),
                ])
                ->modalDescription(
                    new HtmlString(view('modal-import-description.customer'))
                )
                ->modalHeading('Import Data Customer')
                ->handleRecordCreation(function (array $data) {
                    
                    if($paket = PaketResource::getEloquentQuery()->where('name', $data['paket'])->first()) {
                        if($server = ServerResource::getEloquentQuery()->where('name', $data['server'])->first()) {
                            return Customer::create([
                            'name' => $data['name'],
                            'alamat' => $data['alamat'],
                            'no_hp' => $data['no_hp'],
                            'paket_id' => $paket->id,
                            'server_id' => $server->id,
                            'ip_address' => $data['ip_address']
                                ]);
                        }
                    }

                    return new Customer();

                    
                }),
            ExportAction::make()
                ->exports([
                    ExcelExport::make()
                        ->fromModel()
                        ->withColumns([
                            Column::make('id')->heading('customer_id'),
                            Column::make('Server')->formatStateUsing(fn ($record) => $record->server->name)->heading('Server'),
                            Column::make('Paket')->formatStateUsing(fn ($record) => $record->paket->name)->heading('Paket'),
                        ])
                        ->except([
                            'created_at', 'updated_at', 'deleted_at', 'paket_id', 'server_id'
                        ])
                        ->withFilename(fn ($resource) => 'Data-Customer-' . env('APP_NAME') . '-' . Carbon::now()->locale('id')->translatedFormat('d-F-Y'))
                        ->withWriterType(\Maatwebsite\Excel\Excel::XLS)
                ]),
        ];
    }
}
