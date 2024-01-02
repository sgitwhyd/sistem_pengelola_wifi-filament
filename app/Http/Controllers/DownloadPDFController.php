<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use LaravelDaily\Invoices\Invoice;
use LaravelDaily\Invoices\Classes\Buyer;
use LaravelDaily\Invoices\Classes\InvoiceItem;
use LaravelDaily\Invoices\Classes\Party;

class DownloadPDFController extends Controller
{
    public function download(Transaction $record)
    {
        $customer = new Buyer([
            'name'          => $record->customer->name,
            'address' => $record->customer->alamat,
            'phone' => $record->customer->no_hp
        ]);

        $company = Company::all()->first();

        $client = new Party([
            'name'          => $company->name,
            'address' => $company->alamat,
            'custom_fields' => [
                'Telp' => $company->no_telp,
                'email' => $company->email,
                ],
            
]);


        $collection = [
            'paid' => 'Sudah Dibayar',
            'unpaid' => 'Belum Dibayar',
            'pending' => 'Pending'
        ];

        $status = Arr::get($collection, $record->status);



        $item = InvoiceItem::make('Pembayaran Wifi Bulan' . ' ' . $record->payment_month)->pricePerUnit($record->package_price);

        $invoice = Invoice::make('Nota Pembayaran')
            ->buyer($customer)
            ->seller($client)
            ->addItem($item)
            ->currencySymbol('Rp. ')
            ->currencyCode('IDR')
            ->currencyFormat('{SYMBOL}{VALUE}')
            ->currencyThousandsSeparator('.')
            ->status($status)
            ->date($record->created_at)
            ->dateFormat('d-m-Y')
            ->logo(public_path('/storage/' . $company->signature_image))
            ->filename(' pembayaran_' . $record->customer->name . '_' . date('d-m-y'))
            ->notes(public_path('/storage/' . $company->logo))
        ;

        return $invoice->stream();

    }
}
