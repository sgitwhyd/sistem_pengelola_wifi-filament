<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerResource\Pages;
use App\Filament\Resources\CustomerResource\RelationManagers;
use App\Models\Customer;
use App\Models\Paket;
use App\Models\Server;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use stdClass;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static ?string $navigationGroup = 'Data Customer';
    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

    public static function form(Form $form): Form
    {

        

        return $form
            ->schema([
                Card::make()->schema([
                    TextInput::make('name')
                        ->unique(ignoreRecord: true)
                        ->required(),
                    TextInput::make('alamat')->required(),
                    TextInput::make('no_hp')->label('Nomor Handphone')
                        ->tel()
                        ->telRegex('/^(\+62|0)(\d{8,15})$/')
                         ->maxLength(14)
                        ->required(),
                    Select::make('paket_id')
                        ->label('Paket')
                        ->options(Paket::all()->pluck('name', 'id'))
                        ->searchable()
                        ->required(),
                     Select::make('server_id')
                        ->label('Server')
                        ->options(Server::all()->pluck('name', 'id'))
                        ->searchable()
                        ->required(),
                     TextInput::make('ip_address')
                        ->label('Ip Address')
                        ->unique(ignoreRecord: true)
                        ->ipv4()
                        ->required(),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('no')
                    ->label('No')
                    ->state(static function (HasTable $livewire, stdClass $rowLoop): string {
                        return (string) (
                            $rowLoop->iteration +
                            (intval($livewire->getTableRecordsPerPage()) * (intval($livewire->getTablePage()) - 1))
                        );
                    }),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('ip_address')
                        ->label('Ip Address')
                        ->sortable()
                        ->searchable(),
                Tables\Columns\TextColumn::make('server.name')
                        ->label('Nama Server')
                        ->sortable()
                        ->searchable(),
                Tables\Columns\TextColumn::make('alamat')
                    ->label('Alamat')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('no_hp')
                    ->label('Nomor Telephone')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('paket.name')
                    ->label('Paket')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal Join')
                    ->sortable()
                    ->date()
            ])
            ->filters([
                                //
                            ])
            ->actions([
                                Tables\Actions\EditAction::make(),
                                Tables\Actions\DeleteAction::make(),
                            ])
            ->bulkActions([
                                Tables\Actions\BulkActionGroup::make([
                                    Tables\Actions\DeleteBulkAction::make(),
                                ]),
                            ])
            ->emptyStateActions([
                                Tables\Actions\CreateAction::make(),
                            ])->defaultSort('created_at', 'DESC');
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageCustomers::route('/'),
        ];
    }
}
