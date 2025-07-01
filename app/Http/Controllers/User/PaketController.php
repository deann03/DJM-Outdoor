<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Paket;
use App\Models\PaketDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PaketController extends Controller
{
    public function show(Paket $paket)
    {
        $paket->load('details.barang');
        return view('user.paket.show', compact('paket'));
    }
}