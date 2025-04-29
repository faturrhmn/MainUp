<?php

namespace App\Http\Controllers\dashboard;
use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Models\Ruangan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalAssets = Asset::count();
        $totalRuangans = Ruangan::count();
        $totalPreventive = Asset::where('tipe', 'preventive')->count();
        $totalCorrective = Asset::where('tipe', 'corrective')->count();

        $assets = Asset::with('ruangan')->get(); // untuk tabel di bawah

        return view('content.dashboard.index', compact(
            'assets',
            'totalAssets',
            'totalRuangans',
            'totalPreventive',
            'totalCorrective'
        ));
    }
}
