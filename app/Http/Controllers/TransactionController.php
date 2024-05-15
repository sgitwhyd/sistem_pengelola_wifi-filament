<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\Company;
use App\Models\Customer;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class TransactionController extends Controller
{
    private $banks;

    public function __construct()
    {
        $this->banks = Bank::all();
    }

    public function index()
    {
        $banks = $this->banks;
        return view('pembayaran.index', compact('banks'));
    }

    public function store(Request $request,)
    {
        $newFilename = Str::after($request->input('image'), 'tmp/');
        Storage::disk('public')->move($request->input('image'), "bukti-pembayaran/$newFilename");

        $newImgPath = "bukti-pembayaran/$newFilename";

        $customer = Customer::where('name', $request->name)->first();
        $customer->transactions()->create([
            'name' => $customer->name,
            'payment_month' => $request->month,
            'payment_year' => date('Y'),
            'payment_proof_image' => $newImgPath,
            'status' => 'pending',
            'paket' => $customer->paket->name,
            'package_price' => $customer->paket->price,
        ]);

        return redirect()->route('pembayaran.show', ['name' => $customer->name]);
    }

    public function checkName(Customer $customer, $name)
    {
        Carbon::setLocale('id');
        $customer = $customer->where('name', $name)->first();
        $banks = $this->banks;
        //format Carbon to indonesian


        if (!$customer) {
            $customerFound = false;
            return view('pembayaran.show', compact('customerFound'));
        }

        $latestPayment = $customer->transactions->last();
        $currentMonth = Carbon::now()->monthName;

        $customerAlreadyPay = false;
        if ($latestPayment->payment_month === $currentMonth) {
            if ($latestPayment->status === 'paid' ||  $latestPayment->status === 'pending') {
                $customerAlreadyPay = true;
            }
        }


        $customerFound = true;
        $detailPayment = $customer->transactions->last();


        return view('pembayaran.show', compact('banks', 'customer', 'detailPayment', 'customerAlreadyPay', 'customerFound'));
    }
}
