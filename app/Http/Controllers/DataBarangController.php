<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Room;
use Illuminate\Http\Request;

class DataBarangController extends Controller
{
    public function index()
    {
        $assets = Asset::with('room')->get();
        return view('content.data-barang.index', compact('assets'));
    }

    public function show($id)
    {
        $asset = Asset::with('room')->findOrFail($id);
        return view('content.data-barang.show', compact('asset'));
    }

    public function create()
    {
        $rooms = Room::all();
        return view('content.data-barang.create', compact('rooms'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'merk' => 'required|string|max:255',
            'tahun' => 'required|integer',
            'jumlah' => 'required|integer|min:1',
            'ruangan' => 'required|exists:ruangan,id_ruangan',
            'keterangan' => 'nullable|string'
        ], [
            'jumlah.min' => 'Jumlah barang minimal 1'
        ]);

        $data = $request->all();
        $data['id_ruangan'] = $request->ruangan;

        Asset::create($data);

        return redirect()->route('data-barang')
            ->with('success', 'Data barang berhasil ditambahkan');
    }

    public function edit($id)
    {
        $asset = Asset::findOrFail($id);
        $rooms = Room::all();
        return view('content.data-barang.edit', compact('asset', 'rooms'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'merk' => 'required|string|max:255',
            'tahun' => 'required|integer',
            'jumlah' => 'required|integer|min:1',
            'ruangan' => 'required|exists:ruangan,id_ruangan',
            'keterangan' => 'nullable|string'
        ], [
            'jumlah.min' => 'Jumlah barang minimal 1'
        ]);

        $asset = Asset::findOrFail($id);
        $data = $request->all();
        $data['id_ruangan'] = $request->ruangan;
        
        $asset->update($data);

        return redirect()->route('data-barang')
            ->with('success', 'Data barang berhasil diperbarui');
    }

    public function destroyMultiple(Request $request)
    {
        $request->validate([
            'selected_items' => 'required|array',
            'selected_items.*' => 'exists:assets,id_aset'
        ]);

        Asset::whereIn('id_aset', $request->selected_items)->delete();

        return redirect()->route('data-barang')
            ->with('success', 'Data barang berhasil dihapus');
    }
} 