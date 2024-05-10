<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FilepondController extends Controller
{
    public function upload(Request $request)
    {
        if ($request->file('image')) {
            $path = $request->file('image')->store('tmp', 'public');
        }
        return $path;
    }
    public function revert(Request $request)
    {
        Storage::disk('public')->delete($request->getContent());
    }
}
