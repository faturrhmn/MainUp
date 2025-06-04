<?php

namespace App\Http\Controllers\data_barang;
use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Models\Ruangan;
use App\Models\Jadwal;
use App\Models\Maintenance;
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


    // Di Controller
    public function show($id)
    {
        // Load asset dengan relasi ruangan dan semua record maintenance beserta historinya
        $asset = Asset::with(['ruangan', 'maintenance' => function($query) {
            $query->with('history')->orderBy('created_at', 'desc'); // Muat relasi history dan urutkan maintenance berdasarkan created_at
        }])->findOrFail($id);
        
        // Kirim $asset (yang sudah memuat semua maintenance dan historinya) ke view
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
            'tipe' => 'required|string|in:preventive,corrective', // Tambahkan validasi tipe
            'siklus' => 'required|string|in:hari,minggu,bulan,3_bulan,6_bulan,1_tahun', // Kembalikan ke required
            'tanggal_mulai' => 'required|date', // Kembalikan ke required
        ], [
            'jumlah.min' => 'Jumlah barang minimal 1',
            'tipe.required' => 'Tipe barang harus dipilih',
            'tipe.in' => 'Tipe barang tidak valid',
        ]);
    
        // Ambil semua data dari request
        $data = $request->all();
        $data['id_ruangan'] = $request->ruangan;
        if (!isset($data['keterangan']) || $data['keterangan'] === null) {
            $data['keterangan'] = '';
        }
    
        // Simpan data barang ke tabel asset
        $asset = Asset::create($data);
    
        // Simpan data jadwal ke tabel jadwal (kembali ke logika semula)
        $jadwalData = [
            'siklus' => $request->siklus,
            'tanggal_mulai' => $request->tanggal_mulai,
            'id_aset' => $asset->id_aset,  // ID barang yang baru disimpan
        ];
    
        // Menyimpan data jadwal
        Jadwal::create($jadwalData);

        // Redirect dengan pesan sukses
        return redirect()->route('data-barang.index')
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
            'tipe' => 'required|string|in:preventive,corrective', // Tambahkan validasi tipe
            'siklus' => 'required|string|in:hari,minggu,bulan,3_bulan,6_bulan,1_tahun', // Kembalikan ke required
            'tanggal_mulai' => 'required|date', // Kembalikan ke required
        ], [
            'jumlah.min' => 'Jumlah barang minimal 1',
            'tipe.required' => 'Tipe barang harus dipilih',
            'tipe.in' => 'Tipe barang tidak valid',
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

        // Update atau buat data jadwal (kembali ke logika semula)
        if ($asset->jadwals->count() > 0) {
            // Update jadwal pertama
            $jadwal = $asset->jadwals->first();
            $jadwal->update([
                'siklus' => $request->siklus,
                'tanggal_mulai' => $request->tanggal_mulai,
            ]);
        } else {
            // Buat jadwal baru jika belum ada
            Jadwal::create([
                'id_aset' => $asset->id_aset,
                'siklus' => $request->siklus,
                'tanggal_mulai' => $request->tanggal_mulai,
            ]);
        }
    
        // Redirect dengan pesan sukses
        return redirect()->route('data-barang.index')
            ->with('success', 'Data barang dan jadwal berhasil diperbarui');
    }
    

    public function destroyMultiple(Request $request)
    {
        $request->validate([
            'selected_items' => 'required|array',
            'selected_items.*' => 'exists:assets,id_aset'
        ]);

        // Hapus jadwal terkait sebelum menghapus aset
        Jadwal::whereIn('id_aset', $request->selected_items)->delete();

        Asset::whereIn('id_aset', $request->selected_items)->delete();

        return redirect()->route('data-barang.index')
            ->with('error', 'Data barang berhasil dihapus');
    }
} 