<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BankResource\Pages;
use App\Filament\Resources\BankResource\RelationManagers;
use App\Models\Bank;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Storage;
use stdClass;

class BankResource extends Resource
{
    protected static ?string $model = Bank::class;

    protected static ?string $navigationGroup = 'Company Data';
    protected static ?string $navigationIcon = 'heroicon-o-credit-card';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()->schema([
                    TextInput::make('name')
                        ->unique(ignoreRecord: true)
                        ->required(),
                    TextInput::make('nomor_rekening')
                        ->label('Nomor Rekening')
                        ->unique(ignoreRecord: true)
                        ->tel()
                        ->maxLength(16)
                        ->required(),
                    FileUpload::make('image')
                        ->label('Bank Logo')
                        ->image()
                        ->disk('public')
                        ->directory('banks')
                        ->required(),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('no')
                    ->label('No')
                    ->state(static function (HasTable $livewire, stdClass $rowLoop): string {
                        return (string) (
                            $rowLoop->iteration +
                            (intval($livewire->getTableRecordsPerPage()) * (intval($livewire->getTablePage()) - 1))
                        );
                    }),
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('nomor_rekening')
                    ->label('Nomor Rekening'),
                Tables\Columns\ImageColumn::make('image')
                    ->label('Bank Logo')
                    ->width(80)
                    ->height(80),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->using(function (Model $record, array $data): Model {
                        if (isset($data['image'])) {
                            Storage::disk('public')->delete($record->image);
                        }

                        $record->update($data);
                        return $record;
                    }),
                Tables\Actions\DeleteAction::make()
                    ->before(function (Bank $bank) {
                        Storage::disk('public')->delete($bank->image);
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),

                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageBanks::route('/'),
        ];
    }
}
