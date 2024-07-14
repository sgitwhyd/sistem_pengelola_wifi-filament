<?php

namespace App\Filament\Resources;

use Closure;
use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use App\Models\Customer;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\Transaction;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use Filament\Tables\Filters\Filter;
use Illuminate\Support\Facades\Date;
use Filament\Forms\Components\Select;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\TransactionResource\Pages;
use Filament\Tables\Columns\TextColumn\TextColumnSize;
use App\Filament\Resources\TransactionResource\RelationManagers;
use Filament\Forms\Get;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Support\Carbon;
use stdClass;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static ?string $navigationGroup = 'Data Transaksi';
    protected static ?string $navigationIcon = 'heroicon-o-credit-card';


    public static function form(Form $form): Form
    {

        $currentYear = Date('Y');
        $yearsBefore = range($currentYear - 5, $currentYear - 1);


        $data = array_merge($yearsBefore, [$currentYear]);
        $yearsData = collect($data)->combine($data)->toArray();

        Carbon::setLocale('id');


        return $form
            ->schema([
                FileUpload::make('payment_proof_image')
                    ->label('Bukti Pembayaran')
                    ->image()
                    ->disk('public')
                    ->directory('bukti-pembayaran')
                    ->required(),
                Select::make('customer_id')
                    ->label('Customer')
                    ->options(Customer::all()->pluck('name', 'id'))
                    ->searchable()
                    ->afterStateUpdated(function ($set, $state) {
                        $customer = CustomerResource::getEloquentQuery()->where('id', $state)->first();
                        if ($customer) {
                            $set('paket', $customer->paket->name);
                            $set('package_price', $customer->paket->price);
                        }
                    })
                    ->reactive()
                    ->required(),
                Select::make('status')
                    ->label('Status Pembayaran')
                    ->options([
                        'paid' => 'Sudah Dibayar',
                        'unpaid' => 'Belum Dibayar',
                        'pending' => 'Menunggu Konfirmasi',
                    ])->searchable()->required(),
                Select::make('payment_month')
                    ->label('Pembayaran Bulan')
                    ->options([
                        'January'    => 'Januari',
                        'February'   => 'Februari',
                        'March'      => 'Maret',
                        'April'      => 'April',
                        'Mey'        => 'Mei',
                        'June'       => 'Juni',
                        'July'       => 'Juli',
                        'August'     => 'Agustus',
                        'September'  => 'September',
                        'October'    => 'Oktober',
                        'November'   => 'November',
                        'December'   => 'Desember',
                    ])->searchable()->required()->default(Carbon::now()->format('F')),
                Select::make('payment_year')
                    ->options($yearsData)
                    ->label('Tahun Pembayaran')
                    ->searchable()
                    ->required()->default(Date('Y')),
                TextInput::make('paket')
                    ->label('Info Paket')
                    ->readOnly()
                    ->visible(
                        function (Get $get) {
                            $customerId = $get('customer_id');

                            if ($customerId !== null) {
                                return true;
                            }

                            return false;
                        }
                    )
                    ->required(),
                TextInput::make('package_price')
                    ->label('Total Pembayaran')
                    ->readOnly()
                    ->numeric()
                    ->prefix('Rp.')
                    ->visible(
                        function (Get $get) {
                            $customerId = $get('customer_id');

                            if ($customerId !== null) {
                                return true;
                            }

                            return false;
                        }
                    )
                    ->required()
            ]);
    }

    public static function table(Table $table): Table
    {

        $currentYear = Date('Y');
        $yearsBefore = range($currentYear - 5, $currentYear - 1);


        $data = array_merge($yearsBefore, [$currentYear]);
        $yearsData = collect($data)->combine($data)->toArray();

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
                Tables\Columns\TextColumn::make('customer.name')->label('Nama Customer')->searchable(),
                Tables\Columns\TextColumn::make('customer.server.name')->label('Server')->searchable(),
                Tables\Columns\TextColumn::make('paket')->label('Paket')->searchable(),
                Tables\Columns\TextColumn::make('payment_month')->label('Bulan Pembayaran')
                ->formatStateUsing(function (string $state): string {
                    Carbon::setLocale('id');
                    return Carbon::parse($state)->translatedFormat('F');
                }),
                Tables\Columns\TextColumn::make('payment_year')->label('Tahun Pembayaran'),
                Tables\Columns\TextColumn::make('updated_at')->label('Tanggal Dibuat')->date(),
                Tables\Columns\TextColumn::make('status')
                    ->size(TextColumnSize::Large)
                    ->label('Status Pembayaran')
                    ->color(fn (string $state): string => match ($state) {
                        'unpaid' => 'gray',
                        'pending' => 'warning',
                        'paid' => 'success',
                    })->icon(fn (string $state): string => match ($state) {
                        'unpaid' => 'heroicon-o-x-circle',
                        'pending' => 'heroicon-o-clock',
                        'paid' => 'heroicon-o-check-circle',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'paid' => 'Sudah Dibayar',
                        'unpaid' => 'Belum Dibayar',
                        'pending' => 'Menunggu Konfirmasi',
                    })
                    ->badge(),
                Tables\Columns\TextColumn::make('package_price')
                    ->label('Jumlah Pembayaran')
                    ->prefix('Rp. ')
                    ->numeric(),
                Tables\Columns\ImageColumn::make('payment_proof_image')
                    ->label('Bukti Pembayaran')
                    ->width(150)
                    ->height(150)
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
                Filter::make('created_at')->form([
                    Select::make('status')
                        ->options([
                            'paid' => 'Sudah Dibayar',
                            'unpaid' => 'Belum Dibayar',
                            'pending' => 'Menunggu Verifikasi',
                        ])->searchAble()->default('pending'),

                    Select::make('bulan')->options([
                        'January'    => 'Januari',
                        'February'   => 'Februari',
                        'March'      => 'Maret',
                        'April'      => 'April',
                        'Mey'        => 'Mei',
                        'June'       => 'Juni',
                        'July'       => 'Juli',
                        'August'     => 'Agustus',
                        'September'  => 'September',
                        'October'    => 'Oktober',
                        'November'   => 'November',
                        'December'   => 'Desember',

                    ])->searchable(),

                    Select::make('tahun')->options($yearsData)->searchable()->default(Date('Y')),
                ])->query(function (Builder $query, array $data): Builder {
                    return $query->when(
                        $data['bulan'],
                        fn (Builder $query, $month): Builder => $query->where('payment_month', $month)
                    )->when(
                        $data['tahun'],
                        fn (Builder $query, $year): Builder => $query->where('payment_year', $year)
                    )->when(
                        $data['status'],
                        fn (Builder $query, $status): Builder => $query->where('status', $status)
                    );
                }),
            ])
            ->actions([
                ActionGroup::make([
                    Tables\Actions\EditAction::make()
                        ->using(function (Model $record, array $data): Model {
                            if ($record['payment_proof_image'] !== null) {
                                if ($record['payment_proof_image'] !== $data['payment_proof_image']) {
                                    Storage::disk('public')->delete($record->payment_proof_image);
                                }
                            }

                            $record->update($data);
                            return $record;
                        }),
                    Tables\Actions\DeleteAction::make(),
                    Action::make('Download Invoice')
                        ->icon('heroicon-o-document-arrow-down')
                        ->url(fn (Transaction $record) => route('transaction.pdf.download', $record))
                        ->openUrlInNewTab(),
                    Tables\Actions\RestoreAction::make(),
                    Tables\Actions\ForceDeleteAction::make()
                        ->before(function (Transaction $record) {
                            if ($record->payment_proof_image) {
                                Storage::disk('public')->delete($record->payment_proof_image);
                            }
                        }),
                ])
                    ->label('Actions')
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
            'index' => Pages\ManageTransactions::route('/'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->whereHas('customer', function ($query) {
            $query->whereNull('customers.deleted_at');
        })->withoutGlobalScopes([
            SoftDeletingScope::class,
        ]);
    }
}
