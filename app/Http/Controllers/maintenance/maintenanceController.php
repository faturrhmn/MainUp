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
use Illuminate\Support\Facades\File;

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
                $baseDate = \Carbon\Carbon::parse($jadwal->tanggal_mulai)->startOfDay(); // Pastikan tanggal_mulai adalah awal hari
    
                if ($lastFinishedMaintenance) {
                    // Jika ada record maintenance 'selesai', cari record histori terbaru terkait maintenance ini
                    $latestHistory = $lastFinishedMaintenance->history()->latest()->first();
                    if ($latestHistory) {
                        // Jika ada histori, gunakan tanggal perbaikan dari histori tersebut dan pastikan awal hari
                        $baseDate = \Carbon\Carbon::parse($latestHistory->tanggal_perbaikan)->startOfDay(); // Pastikan tanggal perbaikan history adalah awal hari
                    }
                }
    
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
    
        // Load maintenance, images, dan history
        $maintenance = Maintenance::with(['beforeImages', 'afterImages', 'history'])
            ->where('id_aset', $jadwal->id_aset)
            ->latest('created_at')
            ->first();

        // Jika maintenance terakhir berstatus 'selesai', set $maintenance menjadi null agar form kosong
        if ($maintenance && $maintenance->status == 'selesai') {
            $maintenance = null;
            $beforeImages = []; // Juga kosongkan gambar jika form dikosongkan
            $afterImages = [];
        } else {
            // Tetap aman jika tidak ada maintenance sama sekali
            $beforeImages = $maintenance ? $maintenance->beforeImages : [];
            $afterImages = $maintenance ? $maintenance->afterImages : [];
        }
    
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
    
        // Check if we're updating an existing maintenance record
        if ($request->has('id_maintenance')) {
            $maintenance = Maintenance::findOrFail($request->id_maintenance);
        } else {
            // Cari maintenance yang statusnya proses untuk aset ini
            // Mengubah order by menjadi created_at karena tanggal_perbaikan sudah di history
            $maintenance = Maintenance::where('id_aset', $jadwal->id_aset)
                ->where('status', 'proses')
                ->latest('created_at') // Mengubah order by menjadi created_at
                ->first();
        }
    
        if ($maintenance) {
            // Update existing maintenance
            $maintenance->tanggal_perbaikan = $request->tanggal_perbaikan;
            $maintenance->status = $request->status_perbaikan;
            $maintenance->keterangan = $request->keterangan;
            $maintenance->pic = $request->pic;
            $maintenance->teknisi = $request->teknisi;
            $maintenance->save();

            // Buat record history baru untuk setiap update
            \App\Models\MaintenanceHistory::create([
                'maintenance_id' => $maintenance->id_maintenance,
                'tanggal_perbaikan' => $request->tanggal_perbaikan,
                'keterangan' => $request->keterangan,
            ]);

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

            // Buat record history untuk maintenance baru
             \App\Models\MaintenanceHistory::create([
                'maintenance_id' => $maintenance->id_maintenance,
                'tanggal_perbaikan' => $request->tanggal_perbaikan,
                'keterangan' => $request->keterangan,
            ]);
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
    
        // Redirect berdasarkan status perbaikan
        if ($request->status_perbaikan == 'selesai') {
            return redirect()->route('maintenance.proses')->with('success', 'Data maintenance berhasil disimpan');
        } else {
            // Redirect ke halaman proses jika status bukan selesai
            return redirect()->route('maintenance.proses')->with('success', 'Data maintenance berhasil disimpan!');
        }
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
                    // Delete physical file from storage
                    $filePath = 'maintenance/before/' . $image->hashed_name;
                    if (Storage::disk('public')->exists($filePath)) {
                        Storage::disk('public')->delete($filePath);
                    }
                    
                    // Delete database record
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
                    // Delete physical file from storage
                    $filePath = 'maintenance/after/' . $image->hashed_name;
                    if (Storage::disk('public')->exists($filePath)) {
                        Storage::disk('public')->delete($filePath);
                    }
                    
                    // Delete database record
                    $image->delete();
                }
            }
        }
        return redirect()->back()->with('success', 'Gambar setelah perbaikan berhasil dihapus.');
    }
    
    public function detail($id_maintenance)
    {
        $maintenance = Maintenance::with(['asset', 'beforeImages', 'afterImages', 'history'])->findOrFail($id_maintenance);
        return view('content.maintenance.detail', compact('maintenance'));
    }

    public static function getMaintenanceNotifications()
    {
        $now = now();
        $data = \App\Models\Jadwal::with(['asset', 'maintenance'])
            ->get()
            ->filter(function ($jadwal) use ($now) {
                $lastFinishedMaintenance = $jadwal->maintenance()
                    ->where('status', 'selesai')
                    ->latest('tanggal_perbaikan')
                    ->first();
                $baseDate = $lastFinishedMaintenance ? $lastFinishedMaintenance->tanggal_perbaikan : $jadwal->tanggal_mulai;
                $nextMaintenanceDate = (new self)->calculateNextMaintenanceDate($baseDate, $jadwal->siklus);
                $sevenDaysBefore = \Carbon\Carbon::parse($nextMaintenanceDate)->subDays(7);
                return $now->greaterThanOrEqualTo($sevenDaysBefore);
            });
        return $data;
    }
}
