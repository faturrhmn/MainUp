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
    
        $data = Jadwal::with(['asset.ruangan', 'maintenance'])
            ->get()
            ->map(function ($jadwal) use ($now) {
                // Ambil maintenance terakhir dengan status selesai
                $lastFinishedMaintenance = $jadwal->maintenance()
                    ->where('status', 'selesai')
                    ->latest('tanggal_perbaikan')
                    ->first();
    
                // Jika belum pernah maintenance selesai, gunakan tanggal_mulai dari jadwal
                $baseDate = $lastFinishedMaintenance ? $lastFinishedMaintenance->tanggal_perbaikan : $jadwal->tanggal_mulai;
    
                // Hitung next maintenance date
                $nextMaintenanceDate = $this->calculateNextMaintenanceDate($baseDate, $jadwal->siklus);
    
                // Simpan hasil hitung ke properti virtual agar bisa dipakai di view
                $jadwal->next_maintenance_date = $nextMaintenanceDate;
    
                // Filter data seperti sebelumnya
                $sevenDaysBefore = Carbon::parse($nextMaintenanceDate)->subDays(7);
                $jadwal->show = $now->greaterThanOrEqualTo($sevenDaysBefore);
    
                return $jadwal;
            })
            ->filter(function ($jadwal) {
                return $jadwal->show;
            })
            ->values();
    
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
    
        // Load maintenance dan sekaligus before & after images-nya
        $maintenance = Maintenance::with(['beforeImages', 'afterImages'])
            ->where('id_aset', $jadwal->id_aset)
            ->where('status', 'proses')
            ->latest('tanggal_perbaikan')
            ->first();
    
        // Tetap aman jika tidak ada maintenance
        $beforeImages = $maintenance ? $maintenance->beforeImages : [];
        $afterImages = $maintenance ? $maintenance->afterImages : [];
    
        return view('content.maintenance.form', compact('jadwal', 'maintenance', 'beforeImages', 'afterImages'));
    }
    
    
    public function store(Request $request)
    {
        // Validasi input termasuk multiple files (array)
        $request->validate([
            'id_jadwal' => 'required|exists:jadwal,id_jadwal',
            'tanggal_perbaikan' => 'required|date',
            'status_perbaikan' => 'required|in:proses,selesai',
            'before_maintenance.*' => 'file',
            'after_maintenance.*' => 'file',
            'pic' => 'nullable|string|max:255',      
            'teknisi' => 'nullable|string',            
            'keterangan' => 'nullable|string',  
        ]);
    
        $jadwal = Jadwal::findOrFail($request->id_jadwal);
    
        // Cari maintenance yang statusnya proses untuk aset ini
        $maintenance = Maintenance::where('id_aset', $jadwal->id_aset)
            ->where('status', 'proses')
            ->latest('tanggal_perbaikan')
            ->first();
    
        if ($maintenance) {
            // Update existing maintenance
            $maintenance->tanggal_perbaikan = $request->tanggal_perbaikan;
            $maintenance->status = $request->status_perbaikan;
            $maintenance->keterangan = $request->keterangan;
            $maintenance->pic = $request->pic;
            $maintenance->teknisi = $request->teknisi;
            $maintenance->save();
        } else {
            // Create new maintenance
            $maintenance = new Maintenance();
            $maintenance->id_aset = $jadwal->id_aset;
            $maintenance->tanggal_perbaikan = $request->tanggal_perbaikan;
            $maintenance->status = $request->status_perbaikan;
            $maintenance->keterangan = $request->keterangan;
            $maintenance->pic = $request->pic;
            $maintenance->teknisi = $request->teknisi;
            $maintenance->save();
        }
    
        // Upload multiple files sebelum maintenance
        if ($request->hasFile('before_maintenance')) {
            foreach ($request->file('before_maintenance') as $file) {
                $originalName = $file->getClientOriginalName();
                $hashedName = $file->hashName();
                $file->storeAs('maintenance/before', $hashedName, 'public');
    
                BeforeImage::create([
                    'id_maintenance' => $maintenance->id_maintenance,
                    'original_name' => $originalName,
                    'hashed_name' => $hashedName,
                ]);
            }
        }
    
        // Upload multiple files setelah maintenance
        if ($request->hasFile('after_maintenance')) {
            foreach ($request->file('after_maintenance') as $file) {
                $originalName = $file->getClientOriginalName();
                $hashedName = $file->hashName();
                $file->storeAs('maintenance/after', $hashedName, 'public');
    
                AfterImage::create([
                    'id_maintenance' => $maintenance->id_maintenance,
                    'original_name' => $originalName,
                    'hashed_name' => $hashedName,
                ]);
            }
        }
    
        return redirect()->route('maintenance.proses')->with('success', 'Data maintenance berhasil disimpan!');
    }
    
    
    public function selesai()
    {
        $data = Maintenance::with('asset')->where('status', 'selesai')->get();
        return view('content.maintenance.selesai', compact('data'));
    }

    public function prosesProses()
    {
    // Ambil semua data maintenance yang statusnya 'proses' beserta relasi jadwal, asset, ruangan
    $data = Maintenance::with(['jadwal.asset.ruangan'])
        ->where('status', 'proses')
        ->get();

    return view('content.maintenance.proses_proses', compact('data'));
    }

    public function destroyBeforeImagesBatch(Request $request)
    {
        $imageIds = $request->input('image_ids', []);
        if (!empty($imageIds)) {
            foreach ($imageIds as $id) {
                $image = BeforeImage::find($id);
                if ($image) {
                    // Hapus file di storage
                    Storage::delete('maintenance/before/' . $image->hashed_name);
                    // Hapus data di DB
                    $image->delete();
                }
            }
        }
        return redirect()->back()->with('success', 'Gambar sebelum perbaikan berhasil dihapus.');
    }
    
    public function destroyAfterImagesBatch(Request $request)
    {
        $imageIds = $request->input('image_ids', []);
        if (!empty($imageIds)) {
            foreach ($imageIds as $id) {
                $image = AfterImage::find($id);
                if ($image) {
                    Storage::delete('maintenance/after/' . $image->hashed_name);
                    $image->delete();
                }
            }
        }
        return redirect()->back()->with('success', 'Gambar setelah perbaikan berhasil dihapus.');
    }
    

}
