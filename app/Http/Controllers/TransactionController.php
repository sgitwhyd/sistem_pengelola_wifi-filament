<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\Company;
use App\Models\Customer;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
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
        $months = [
            "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli",
            "Agustus", "September", "Oktober", "November", "Desember"
        ];


        $customer = Customer::where('name', $request->name)->with('transactions')->first();
        $latestPayment = $customer->transactions->last();
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        if ($latestPayment) {
            $index = array_search($request->month, $months) + 1;
            $isPaymentPastMonth = $index < $currentMonth;
            $isPaymentBiggerThanCurrentMonth = $index > $currentMonth;

            if($isPaymentBiggerThanCurrentMonth || $isPaymentPastMonth) {
                if(intval($latestPayment->payment_year) === $currentYear) {
                    return redirect()->back()->with('error', true);
                }
            }

        }



        $newFilename = Str::after($request->input('image'), 'tmp/');
        Storage::disk('public')->move($request->input('image'), "bukti-pembayaran/$newFilename");

        $newImgPath = "bukti-pembayaran/$newFilename";

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
        $customer = $customer->where('name', $name)->with('transactions')->first();
        $banks = $this->banks;
        $currentMonth = Carbon::now()->month;

        // jika sudah bayar bulan ini
        $latestPayment = null;
        if ($customer) {
            $latestPayment = $customer->transactions->last();
        }
        $alreadyPaid = false;

        if ($latestPayment) {
            $alreadyPaid = $latestPayment->status === 'paid' || $latestPayment->status === 'pending';
            if ($latestPayment->payment_month === $currentMonth) {
            }
        }




        return view('pembayaran.show', compact('customer', 'banks', 'alreadyPaid'));
    }
}
