<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Asset;

class AssetController extends Controller
{
    public function show($id)
    {
        $asset = Asset::with('ruangan')->findOrFail($id);
        return view('content.ruangan.detail-barang', compact('asset'));
    }
} 