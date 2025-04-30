<?php

namespace App\Http\Controllers\maintenance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Jadwal;

class MaintenanceController extends Controller
{
    public function proses()
    {
        // Get current date
        $now = now();
        
        // Get all schedules with their related assets and rooms
        $data = Jadwal::with(['asset.ruangan'])
            ->get()
            ->map(function($item) {
                // Calculate next maintenance date based on cycle
                $nextDate = $this->calculateNextMaintenanceDate($item->tanggal_mulai, $item->siklus);
                $item->next_maintenance_date = $nextDate;
                return $item;
            })
            ->filter(function($item) use ($now) {
                // Only show items that are within 7 days before their next maintenance date
                $nextDate = \Carbon\Carbon::parse($item->next_maintenance_date);
                $sevenDaysBefore = $nextDate->copy()->subDays(7);
                
                // Debug information
                \Log::info('Item: ' . $item->asset->nama_barang);
                \Log::info('Start Date: ' . $item->tanggal_mulai);
                \Log::info('Cycle: ' . $item->siklus);
                \Log::info('Next Maintenance: ' . $nextDate);
                \Log::info('7 Days Before: ' . $sevenDaysBefore);
                \Log::info('Current Date: ' . $now);
                \Log::info('Should Show: ' . ($now->between($sevenDaysBefore, $nextDate) ? 'Yes' : 'No'));
                
                return $now->between($sevenDaysBefore, $nextDate);
            });

        return view('content.maintenance.proses', compact('data'));
    }

    private function calculateNextMaintenanceDate($startDate, $cycle)
    {
        $start = \Carbon\Carbon::parse($startDate);
        $now = now();
        
        switch($cycle) {
            case 'hari':
                // For daily maintenance, next date is tomorrow from start date
                return $start->copy()->addDay();
                
            case 'minggu':
                // For weekly maintenance, next date is 7 days from start date
                return $start->copy()->addWeek();
                
            case 'bulan':
                // For monthly maintenance, next date is 1 month from start date
                return $start->copy()->addMonth();
                
            case '3_bulan':
                // For 3-month maintenance, next date is 3 months from start date
                return $start->copy()->addMonths(3);
                
            case '6_bulan':
                // For 6-month maintenance, next date is 6 months from start date
                return $start->copy()->addMonths(6);
                
            case '1_tahun':
                // For yearly maintenance, next date is 1 year from start date
                return $start->copy()->addYear();
                
            default:
                return $start;
        }
    }

    public function edit($id)
    {
        $jadwal = \App\Models\Jadwal::with('asset.ruangan')->findOrFail($id);
        return view('content.maintenance.form', compact('jadwal'));
    }

    public function update(Request $request, $id)
    {
        $jadwal = \App\Models\Jadwal::findOrFail($id);
        $jadwal->tanggal_perbaikan = $request->tanggal_perbaikan;
        $jadwal->status_perbaikan = $request->status_perbaikan;
        $jadwal->keterangan = $request->keterangan;
        // Simpan file before/after maintenance jika ada (dummy, bisa dikembangkan)
        $jadwal->save();
        return redirect()->route('maintenance.proses')->with('success', 'Data maintenance berhasil diupdate!');
    }
}
