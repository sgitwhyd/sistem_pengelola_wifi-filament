<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Transaction;
use Illuminate\Http\Request;

class CheckHistoryPembayaran extends Controller
{
    public function index()
    {
        $data = Company::first();
        return view('check-pembayaran.index', [
            'company_logo' => $data->logo,
            'company_name' => $data->name
        ]);
    }

    public function show($user)
    {
        $userTransactions = Transaction::whereHas('customer', function ($query) use ($user) {
            $query->where('name', $user);
        })
        ->orderBy('created_at', 'desc')
        ->get();

        $name = $user;
        $data = Company::first();


        
        return view('check-pembayaran.show', compact('userTransactions', 'name'), [
            'company_logo' => $data->logo,
            'company_name' => $data->name
        ]);
    }
}
