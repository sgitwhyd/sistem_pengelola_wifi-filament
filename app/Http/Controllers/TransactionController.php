<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $data = Company::first();

        return view('pembayaran.index', [
            'company_logo' => $data->logo,
            'company_name' => $data->name
        ]);
    }
}
