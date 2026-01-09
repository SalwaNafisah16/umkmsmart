<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UmkmProfile;

class UmkmController extends Controller
{
    public function show($id)
    {
        $umkm = UmkmProfile::findOrFail($id);

        return view('umkm.show', compact('umkm'));
    }
}
