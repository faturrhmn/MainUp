<?php

namespace App\Http\Controllers\maintenance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Jadwal;
use App\Models\Maintenance;
use App\Models\BeforeImage;
use App\Models\AfterImage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class MaintenanceController extends Controller
{
    public function proses()
    {
        $now = now();
        $data = Jadwal::with(['asset.ruangan'])
            ->get()
            ->map(function($item) {
                $nextDate = $this->calculateNextMaintenanceDate($item->tanggal_mulai, $item->siklus);
                $item->next_maintenance_date = $nextDate;
                return $item;
            })
            ->filter(function($item) use ($now) {
                $nextDate = Carbon::parse($item->next_maintenance_date);
                $sevenDaysBefore = $nextDate->copy()->subDays(7);

                return $now->between($sevenDaysBefore, $nextDate) || $item->status_perbaikan !== 'selesai';
            });

        return view('content.maintenance.proses', compact('data'));
    }

    private function calculateNextMaintenanceDate($startDate, $cycle)
    {
        $start = Carbon::parse($startDate);
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

    public function edit($id)
    {
        $jadwal = Jadwal::with('asset.ruangan')->findOrFail($id);
    
        // Ambil data maintenance terakhir untuk aset ini dengan status "proses"
        $maintenance = Maintenance::where('id_aset', $jadwal->id_aset)
            ->where('status', 'proses')
            ->latest('tanggal_perbaikan')
            ->first();
    
        // Ambil data gambar Before dan After jika ada
        $beforeImages = $maintenance ? $maintenance->beforeImages : [];
        $afterImages = $maintenance ? $maintenance->afterImages : [];
    
        return view('content.maintenance.form', compact('jadwal', 'maintenance', 'beforeImages', 'afterImages'));
    }
    
    

    public function store(Request $request)
    {
        $request->validate([
            'id_jadwal' => 'required|exists:jadwal,id_jadwal',
            'tanggal_perbaikan' => 'required|date',
            'status_perbaikan' => 'required|in:proses,selesai',
            'before_maintenance' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:1024',
            'after_maintenance' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:1024',
            'keterangan' => 'nullable|string',
        ]);

        $jadwal = Jadwal::findOrFail($request->id_jadwal);

        // Cek apakah sudah ada data maintenance dengan status "proses" untuk aset ini
        $maintenance = Maintenance::where('id_aset', $jadwal->id_aset)
            ->where('status', 'proses')
            ->latest('tanggal_perbaikan')
            ->first();

        if ($maintenance) {
            // Update data yang sudah ada
            $maintenance->tanggal_perbaikan = $request->tanggal_perbaikan;
            $maintenance->status = $request->status_perbaikan;
            $maintenance->keterangan = $request->keterangan;
            $maintenance->save();
        } else {
            // Jika belum ada, buat data baru
            $maintenance = new Maintenance();
            $maintenance->id_aset = $jadwal->id_aset;
            $maintenance->tanggal_perbaikan = $request->tanggal_perbaikan;
            $maintenance->status = $request->status_perbaikan;
            $maintenance->keterangan = $request->keterangan;
            $maintenance->save();
        }

        // Simpan file before_maintenance jika ada
        if ($request->hasFile('before_maintenance')) {
            $file = $request->file('before_maintenance');
            $originalName = $file->getClientOriginalName();
            $hashedName = $file->hashName();
            $file->storeAs('maintenance/before', $hashedName);

            BeforeImage::create([
                'id_maintenance' => $maintenance->id_maintenance,
                'original_name' => $originalName,
                'hashed_name' => $hashedName,
            ]);
        }

        // Simpan file after_maintenance jika ada
        if ($request->hasFile('after_maintenance')) {
            $file = $request->file('after_maintenance');
            $originalName = $file->getClientOriginalName();
            $hashedName = $file->hashName();
            $file->storeAs('maintenance/after', $hashedName);

            AfterImage::create([
                'id_maintenance' => $maintenance->id_maintenance,
                'original_name' => $originalName,
                'hashed_name' => $hashedName,
            ]);
        }

        return redirect()->route('maintenance.proses')->with('success', 'Data maintenance berhasil disimpan!');
    }

    public function selesai()
    {
        $data = Maintenance::with('asset')->where('status', 'selesai')->get();
        return view('content.maintenance.selesai', compact('data'));
    }
}
