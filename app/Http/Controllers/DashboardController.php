<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Room;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalAssets = Asset::count();
        $totalRooms = Room::count();
        $totalPreventive = Asset::where('tipe', 'preventive')->count();
        $totalCorrective = Asset::where('tipe', 'corrective')->count();

        $assets = Asset::with('room')->get(); // untuk tabel di bawah

        return view('content.dashboard.index', compact(
            'assets',
            'totalAssets',
            'totalRooms',
            'totalPreventive',
            'totalCorrective'
        ));
    }
}
