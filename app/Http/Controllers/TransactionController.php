<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\Company;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

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

    public function store(Request $request)
    {
        dd($request);
    }

    public function checkName(Customer $customer, $name)
    {
        $customer = $customer->where('name', $name)->first();
        $banks = $this->banks;
        //format Carbon to indonesian
        Carbon::setLocale('id');

        // check if customer already payment this month
       $detailPayment = $customer->transactions()
            ->where('payment_month', Carbon::now()->format('F'))
            ->where('payment_year', date('Y'))
            ->first();
        $customerAlreadyPay = $detailPayment ? true : false;
        return view('pembayaran.show', compact('banks', 'customer', 'detailPayment', 'customerAlreadyPay'));
    }
}
