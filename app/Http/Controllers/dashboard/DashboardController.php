<?php

namespace App\Http\Controllers\dashboard;
use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Models\Ruangan;
use App\Models\Maintenance;
use App\Models\Jadwal;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalAssets = Asset::count();
        $totalRuangans = Ruangan::count();
        $totalMaintenanceSelesai = Maintenance::where('status', 'selesai')->count();

        // Hitung jumlah jadwal yang tampil di halaman proses (logika sama dengan MaintenanceController@proses)
        $now = now();
        $totalMaintenanceProses = Jadwal::with(['asset.ruangan', 'maintenance'])
            ->get()
            ->map(function ($jadwal) use ($now) {
                $lastFinishedMaintenance = $jadwal->maintenance()
                    ->where('status', 'selesai')
                    ->latest('tanggal_perbaikan')
                    ->first();
                $baseDate = \Carbon\Carbon::parse($jadwal->tanggal_mulai)->startOfDay();
                if ($lastFinishedMaintenance) {
                    $latestHistory = $lastFinishedMaintenance->history()->latest()->first();
                    if ($latestHistory) {
                        $baseDate = \Carbon\Carbon::parse($latestHistory->tanggal_perbaikan)->startOfDay();
                    }
                }
                $nextMaintenanceDate = $this->calculateNextMaintenanceDate($baseDate, $jadwal->siklus);
                $sevenDaysBefore = \Carbon\Carbon::parse($nextMaintenanceDate)->subDays(7);
                $jadwal->show = $now->greaterThanOrEqualTo($sevenDaysBefore);
                return $jadwal;
            })
            ->filter(function ($jadwal) {
                return $jadwal->show;
            })
            ->count();

        $assets = Asset::with('ruangan')->get(); // untuk tabel di bawah

        return view('content.dashboard.index', compact(
            'assets',
            'totalAssets',
            'totalRuangans',
            'totalMaintenanceProses',
            'totalMaintenanceSelesai'
        ));
    }

    private function calculateNextMaintenanceDate($startDate, $cycle)
    {
        $start = \Carbon\Carbon::parse($startDate);
        switch ($cycle) {
            case 'hari': return $start->addDay();
            case 'minggu': return $start->addWeek();
            case 'bulan': return $start->addMonth();
            case '3_bulan': return $start->addMonths(3);
            case '6_bulan': return $start->addMonths(6);
            case '1_tahun': return $start->addYear();
            default: return $start;
        }
    }
}
