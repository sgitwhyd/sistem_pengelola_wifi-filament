<?php

namespace App\Http\Controllers;

use App\Models\Company as ModelsCompany;
use Illuminate\Http\Request;

class Company extends Controller
{
    public function index()
    {

        $data = ModelsCompany::all()->first()->get();
        dd($data);

        return view('check-pembayaran.index');
    }
}
