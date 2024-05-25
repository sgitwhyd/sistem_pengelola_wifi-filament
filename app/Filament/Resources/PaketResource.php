<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PaketResource\Pages;
use App\Filament\Resources\PaketResource\RelationManagers;
use App\Models\Paket;
use Filament\Forms;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PaketResource extends Resource
{
    protected static ?string $model = Paket::class;

    protected static ?string $navigationIcon = 'heroicon-o-window';
    protected static ?string $navigationGroup = 'Company Data';
    protected static ?string $navigationLabel = 'Paket Data';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                ->label('Nama Paket')->required(),
                TextInput::make('price')
                    ->label('Harga Paket')
                    ->numeric()
                    ->prefix('Rp')
                    ->required(),
                RichEditor::make('information')
                ->label('Keterangan')
                ->disableToolbarButtons([
                    'attachFiles',
                    'codeBlock'
                ])
                ->columnSpan(2)
                ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('index')
                    ->label('No')
                    ->rowIndex(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Paket')
                    ->searchable(),
                Tables\Columns\TextColumn::make('price')
                    ->label('Harga Paket')
                    ->numeric()
                    ->prefix('Rp. ')
                    ->searchable(),
                Tables\Columns\TextColumn::make('information')
                    ->label('Keterangan')
                    ->html()
                    ,
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                // Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ManagePakets::route('/'),
        ];
    }
}
