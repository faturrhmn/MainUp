<?php

namespace App\Http\Controllers\ruangan;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Ruangan;

class RuanganController extends Controller
{
    public function index()
    {
        $ruangans = Ruangan::withCount('assets')->get();
        return view('content.ruangan.index', compact('ruangans'));
    }

    public function create()
    {
        return view('content.ruangan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_ruangan' => 'required|string|max:255'
        ]);
        Ruangan::create([
            'nama_ruangan' => $request->nama_ruangan
        ]);
        return redirect()->route('ruangan.index')->with('success', 'Ruangan berhasil ditambahkan!');
    }

    public function destroyMultiple(Request $request)
    {
        $request->validate([
            'selected_items' => 'required|array',
            'selected_items.*' => 'exists:ruangan,id_ruangan'
        ]);

        Ruangan::whereIn('id_ruangan', $request->selected_items)->delete();

        return redirect()->route('ruangan.index')
            ->with('success', 'Data ruangan berhasil dihapus');
    }

    public function edit($id_ruangan)
    {
        $ruangan = Ruangan::where('id_ruangan', $id_ruangan)->firstOrFail();
        return view('content.ruangan.edit', compact('ruangan'));
    }

    public function update(Request $request, $id_ruangan)
    {
        $request->validate([
            'nama_ruangan' => 'required|string|max:255'
        ]);
        $ruangan = Ruangan::where('id_ruangan', $id_ruangan)->firstOrFail();
        $ruangan->update([
            'nama_ruangan' => $request->nama_ruangan
        ]);
        return redirect()->route('ruangan.index')->with('success', 'Ruangan berhasil diperbarui!');
    }

    public function show($id_ruangan)
    {
        $ruangan = \App\Models\Ruangan::where('id_ruangan', $id_ruangan)->firstOrFail();
        $assets = $ruangan->assets()->with('ruangan')->get();
        return view('content.ruangan.detail', compact('ruangan', 'assets'));
    }
} 