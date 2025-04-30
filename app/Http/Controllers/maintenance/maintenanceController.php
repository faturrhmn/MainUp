<?php

namespace App\Http\Controllers\maintenance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Jadwal;

class MaintenanceController extends Controller
{
    public function proses()
    {
        // Ambil data jadwal beserta asset dan ruangan terkait
        $data = Jadwal::with(['asset.ruangan'])->get();
        return view('content.maintenance.proses', compact('data'));
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
