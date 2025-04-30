<?php

namespace App\Http\Controllers\data_barang;
use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Models\Ruangan;
use App\Models\Jadwal;
use Illuminate\Http\Request;

class DataBarangController extends Controller
{
    public function index()
    {
        // Ambil data asset dengan relasi room dan jadwal
        $assets = Asset::with('ruangan', 'jadwals')->get(); // Mengambil data jadwal yang terkait
    
        // Kirim data assets ke view
        return view('content.data-barang.index', compact('assets'));
    }


    public function show($id)   
    {
        // Ambil asset dengan relasi room dan jadwal
        $asset = Asset::with('ruangan', 'jadwals')->findOrFail($id); // Menampilkan jadwal terkait

        // Kirim data asset ke view
        return view('content.data-barang.show', compact('asset'));
    }


    public function create()
    {
        // Ambil semua data ruangan dan jadwal
        $ruangans = Ruangan::all();
        $jadwals = Jadwal::all(); // Ambil semua data jadwal jika diperlukan di view
    
        // Kirim data ruangan dan jadwal ke view
        return view('content.data-barang.create', compact('ruangans', 'jadwals'));
    }
    

    public function store(Request $request)
    {
        // Validasi data input
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'merk' => 'required|string|max:255',
            'tahun' => 'required|integer',
            'jumlah' => 'required|integer|min:1',
            'ruangan' => 'required|exists:ruangan,id_ruangan',
            'keterangan' => 'nullable|string',
            'siklus' => 'required|string|in:hari,minggu,bulan,3_bulan,6_bulan,1_tahun', // Validasi siklus
            'tanggal_mulai' => 'required|date', // Validasi tanggal mulai
        ], [
            'jumlah.min' => 'Jumlah barang minimal 1'
        ]);
    
        // Ambil semua data dari request
        $data = $request->all();
        $data['id_ruangan'] = $request->ruangan;
        if (!isset($data['keterangan']) || $data['keterangan'] === null) {
            $data['keterangan'] = '';
        }
    
        // Simpan data barang ke tabel asset
        $asset = Asset::create($data);
    
        // Simpan data jadwal ke tabel jadwal
        $jadwalData = [
            'siklus' => $request->siklus,
            'tanggal_mulai' => $request->tanggal_mulai,
            'id_aset' => $asset->id_aset,  // ID barang yang baru disimpan
        ];
    
        // Menyimpan data jadwal
        Jadwal::create($jadwalData);
    
        // Redirect dengan pesan sukses
        return redirect()->route('data-barang')
            ->with('success', 'Data barang dan jadwal berhasil ditambahkan');
    }
    

    public function edit($id)
    {
        // Ambil data asset dengan relasi room dan jadwal
        $asset = Asset::with('ruangan', 'jadwals')->findOrFail($id); // Menampilkan jadwal terkait
        $ruangans = Ruangan::all(); // Ambil semua ruangan
    
        // Kirim data asset, ruangan, dan jadwal ke view
        return view('content.data-barang.edit', compact('asset', 'ruangans'));
    }
    

    public function update(Request $request, $id)
    {
        // Validasi data input
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'merk' => 'required|string|max:255',
            'tahun' => 'required|integer',
            'jumlah' => 'required|integer|min:1',
            'ruangan' => 'required|exists:ruangan,id_ruangan',
            'keterangan' => 'nullable|string',
            'siklus' => 'required|string|in:hari,minggu,bulan,3_bulan,6_bulan,1_tahun', // Validasi siklus
            'tanggal_mulai' => 'required|date', // Validasi tanggal mulai
        ], [
            'jumlah.min' => 'Jumlah barang minimal 1'
        ]);
    
        // Cari asset berdasarkan ID
        $asset = Asset::findOrFail($id);
        $data = $request->all();
        $data['id_ruangan'] = $request->ruangan;
        if (!isset($data['keterangan']) || $data['keterangan'] === null) {
            $data['keterangan'] = '';
        }
        
        // Update data barang
        $asset->update($data);

        // Update atau buat data jadwal
        if ($asset->jadwals->count() > 0) {
            // Update jadwal pertama
            $jadwal = $asset->jadwals->first();
            $jadwal->update([
                'siklus' => $request->siklus,
                'tanggal_mulai' => $request->tanggal_mulai,
                'keterangan' => $request->keterangan ?? '',
            ]);
        } else {
            // Buat jadwal baru jika belum ada
            Jadwal::create([
                'id_aset' => $asset->id_aset,
                'siklus' => $request->siklus,
                'tanggal_mulai' => $request->tanggal_mulai,
                'keterangan' => $request->keterangan ?? '',
            ]);
        }
    
        // Redirect dengan pesan sukses
        return redirect()->route('data-barang')
            ->with('success', 'Data barang dan jadwal berhasil diperbarui');
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