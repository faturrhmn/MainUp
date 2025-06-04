<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
use Excel;
use App\Exports\TableExport;
use App\Models\Asset;
use App\Services\TableExportService;
use App\Models\User;
use App\Models\Role;
use App\Models\Ruangan;
use App\Models\Jadwal;
use App\Models\Maintenance;
use App\Models\BeforeImage;
use App\Models\AfterImage;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Models\DataBarang;
use App\Exports\MaintenanceExport;
use App\Exports\RuanganExport;
use App\Exports\AssetsExport;

class ExportController extends Controller
{
    protected $tableExportService;

    public function __construct(TableExportService $tableExportService)
    {
        $this->tableExportService = $tableExportService;
    }

    // Helper function to get Base64 logos
    private function getBase64Logos()
    {
        $logoRriPath = public_path('assets/rri.png');
        $logoMainupPath = public_path('assets/logo mainup.png');

        $logoRriBase64 = null;
        Log::info('Attempting to get Base64 for RRI logo from path: ' . $logoRriPath);
        if (file_exists($logoRriPath)) {
            Log::info('RRI logo file found.');
            $type = pathinfo($logoRriPath, PATHINFO_EXTENSION);
            $data = file_get_contents($logoRriPath);
            if ($data === false) {
                 Log::error('Failed to read RRI logo file: ' . $logoRriPath);
            } else {
                $logoRriBase64 = 'data:image/' . ($type === 'jpg' ? 'jpeg' : $type) . ';base64,' . base64_encode($data);
                Log::info('RRI logo Base64 encoded successfully. Length: ' . strlen($logoRriBase64));
            }
        } else {
            Log::warning('RRI logo not found at: ' . $logoRriPath);
        }

        $logoMainupBase64 = null;
        Log::info('Attempting to get Base64 for MainUp logo from path: ' . $logoMainupPath);
        if (file_exists($logoMainupPath)) {
             Log::info('MainUp logo file found.');
             $type = pathinfo($logoMainupPath, PATHINFO_EXTENSION);
            $data = file_get_contents($logoMainupPath);
            if ($data === false) {
                Log::error('Failed to read MainUp logo file: ' . $logoMainupPath);
            } else {
                $logoMainupBase64 = 'data:image/' . ($type === 'jpg' ? 'jpeg' : $type) . ';base64,' . base64_encode($data);
                Log::info('MainUp logo Base64 encoded successfully. Length: ' . strlen($logoMainupBase64));
            }
        } else {
            Log::warning('Logo MainUp not found at: ' . $logoMainupPath);
        }

        return [
            'logoRriBase64' => $logoRriBase64,
            'logoMainupBase64' => $logoMainupBase64,
        ];
    }

    public function exportUsers(Request $request)
    {
        $users = User::with('role')->get();
        $headers = ['ID', 'Nama', 'Username', 'Role', 'Tanggal Dibuat'];
        
        $data = $users->map(function ($user) {
            return [
                $user->id,
                $user->name,
                $user->username,
                $user->role->name,
                $user->created_at->format('d/m/Y H:i')
            ];
        })->toArray();

        if ($request->type === 'pdf') {
            $options = $this->getBase64Logos();
            return $this->tableExportService->exportToPdf($headers, $data, 'users.pdf', $options);
        }
        
        return $this->tableExportService->exportToExcel($headers, $data, 'users.xlsx');
    }

    public function exportRoles(Request $request)
    {
        $roles = Role::all();
        $headers = ['ID', 'Nama Role', 'Deskripsi', 'Tanggal Dibuat'];
        
        $data = $roles->map(function ($role) {
            return [
                $role->id,
                $role->name,
                $role->description,
                $role->created_at->format('d/m/Y H:i')
            ];
        })->toArray();

        if ($request->type === 'pdf') {
            $options = $this->getBase64Logos();
            return $this->tableExportService->exportToPdf($headers, $data, 'roles.pdf', $options);
        }
        
        return $this->tableExportService->exportToExcel($headers, $data, 'roles.xlsx');
    }

    public function exportRuangan(Request $request)
    {
        $ruangan = Ruangan::all();
        $headers = ['ID Ruangan', 'Nama Ruangan', 'Keterangan', 'Tanggal Dibuat'];
        
        $data = $ruangan->map(function ($ruang) {
            return [
                $ruang->id_ruangan,
                $ruang->nama_ruangan,
                $ruang->keterangan,
                $ruang->created_at ? $ruang->created_at->format('d/m/Y H:i') : '-'
            ];
        })->toArray();

        $judul = 'LAPORAN DATA RUANGAN';

        if ($request->type === 'pdf') {
            $options = $this->getBase64Logos();
            $options['judul'] = $judul;
            return $this->tableExportService->exportToPdf($headers, $data, 'ruangan.pdf', $options);
        }
        
        return $this->tableExportService->exportToExcel($headers, $data, 'ruangan.xlsx');
    }

    public function exportJadwal(Request $request)
    {
        $jadwal = Jadwal::with(['asset', 'ruangan'])->get();
        $headers = ['ID', 'Nama Barang', 'Ruangan', 'Tanggal Mulai', 'Tanggal Selesai', 'Status', 'Keterangan'];
        
        $data = $jadwal->map(function ($item) {
            return [
                $item->id_jadwal,
                $item->asset->nama_barang ?? '-',
                $item->ruangan->nama_ruangan ?? '-',
                $item->tanggal_mulai->format('d/m/Y'),
                $item->tanggal_selesai->format('d/m/Y'),
                $item->status,
                $item->keterangan
            ];
        })->toArray();

        $judul = 'LAPORAN DATA JADWAL MAINTENANCE';

        if ($request->type === 'pdf') {
            $options = $this->getBase64Logos();
            $options['judul'] = $judul;
            return $this->tableExportService->exportToPdf($headers, $data, 'jadwal.pdf', $options);
        }
        
        return $this->tableExportService->exportToExcel($headers, $data, 'jadwal.xlsx');
    }

    public function exportMaintenance(Request $request)
    {
        $maintenance = Maintenance::with(['asset', 'ruangan'])->get();
        $headers = ['ID', 'Nama Barang', 'Ruangan', 'Tanggal Maintenance', 'Status', 'Keterangan', 'Tanggal Selesai'];
        
        $data = $maintenance->map(function ($item) {
            return [
                $item->id_maintenance,
                $item->asset->nama_barang ?? '-',
                $item->ruangan->nama_ruangan ?? '-',
                $item->tanggal_maintenance->format('d/m/Y'),
                $item->status,
                $item->keterangan,
                $item->tanggal_selesai ? $item->tanggal_selesai->format('d/m/Y') : '-'
            ];
        })->toArray();

        $judul = 'LAPORAN DATA MAINTENANCE';

        if ($request->type === 'pdf') {
            $options = $this->getBase64Logos();
            $options['judul'] = $judul;
            return $this->tableExportService->exportToPdf($headers, $data, 'maintenance.pdf', $options);
        }
        
        return $this->tableExportService->exportToExcel($headers, $data, 'maintenance.xlsx');
    }

    public function exportAssets(Request $request)
    {
        $assets = Asset::with('ruangan')->get();
        $headers = ['NO', 'Nama Barang', 'Merk', 'Tahun', 'Jumlah', 'Tipe', 'Ruangan', 'Keterangan'];
        
        $data = $assets->map(function ($item, $key) {
            return [
                $key + 1,
                $item->nama_barang,
                $item->merk,
                $item->tahun,
                $item->jumlah,
                $item->tipe,
                $item->ruangan->nama_ruangan ?? '-',
                $item->keterangan
            ];
        })->toArray();

        $judul = 'LAPORAN DATA BARANG';

        if ($request->type === 'pdf') {
            $options = $this->getBase64Logos();
            $options['judul'] = $judul;
            
            return PDF::loadView('exports.table-pdf', array_merge(['headers' => $headers, 'data' => $data], $options))
                       ->setPaper('a4', 'portrait')
                       ->stream('data_barang.pdf');
        }
        
        return $this->tableExportService->exportToExcel($headers, $data, 'assets.xlsx');
    }

    public function exportBeforeImages(Request $request)
    {
        $images = BeforeImage::with('maintenance')->get();
        $headers = ['ID', 'ID Maintenance', 'Nama Barang', 'Tanggal Upload', 'Keterangan'];
        
        $data = $images->map(function ($item) {
            return [
                $item->id,
                $item->maintenance_id,
                $item->maintenance->asset->nama_barang ?? '-',
                $item->created_at->format('d/m/Y H:i'),
                $item->keterangan
            ];
        })->toArray();

        $judul = 'LAPORAN DATA BEFORE IMAGES';

        if ($request->type === 'pdf') {
            $options = $this->getBase64Logos();
            $options['judul'] = $judul;
            return $this->tableExportService->exportToPdf($headers, $data, 'before_images.pdf', $options);
        }
        
        return $this->tableExportService->exportToExcel($headers, $data, 'before_images.xlsx');
    }

    public function exportAfterImages(Request $request)
    {
        $images = AfterImage::with('maintenance')->get();
        $headers = ['ID', 'ID Maintenance', 'Nama Barang', 'Tanggal Upload', 'Keterangan'];
        
        $data = $images->map(function ($item) {
            return [
                $item->id,
                $item->maintenance_id,
                $item->maintenance->asset->nama_barang ?? '-',
                $item->created_at->format('d/m/Y H:i'),
                $item->keterangan
            ];
        })->toArray();

        $judul = 'LAPORAN DATA AFTER IMAGES';

        if ($request->type === 'pdf') {
            $options = $this->getBase64Logos();
            $options['judul'] = $judul;
            return $this->tableExportService->exportToPdf($headers, $data, 'after_images.pdf', $options);
        }
        
        return $this->tableExportService->exportToExcel($headers, $data, 'after_images.xlsx');
    }

    /**
     * Konversi detail maintenance beserta gambar ke PDF dan Excel
     *
     * @param int $id_maintenance ID Maintenance
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response|\Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function exportDetailMaintenance(int $id_maintenance, Request $request)
    {
        $maintenance = Maintenance::with(['asset.ruangan', 'beforeImages', 'afterImages', 'history'])->findOrFail($id_maintenance);

        // Encode gambar maintenance ke Base64
        $beforeImagesEncoded = $maintenance->beforeImages->map(function($image) {
            $path = Storage::path('maintenance/before/' . $image->hashed_name);
             if (Storage::disk('public')->exists('maintenance/before/' . $image->hashed_name)) {
                $type = pathinfo($path, PATHINFO_EXTENSION);
                 $mime_type = 'image/' . ($type === 'jpg' ? 'jpeg' : $type); // Handle jpg sebagai jpeg
                $data = Storage::disk('public')->get('maintenance/before/' . $image->hashed_name);
                $base64 = 'data:' . $mime_type . ';base64,' . base64_encode($data);
                return ['base64' => $base64, 'keterangan' => $image->keterangan];
            } else {
                 return ['base64' => null, 'keterangan' => $image->keterangan];
            }
        });

        $afterImagesEncoded = $maintenance->afterImages->map(function($image) {
             $path = Storage::path('maintenance/after/' . $image->hashed_name);
            if (Storage::disk('public')->exists('maintenance/after/' . $image->hashed_name)) {
                $type = pathinfo($path, PATHINFO_EXTENSION);
                 $mime_type = 'image/' . ($type === 'jpg' ? 'jpeg' : $type); // Handle jpg sebagai jpeg
                $data = Storage::disk('public')->get('maintenance/after/' . $image->hashed_name);
                $base64 = 'data:' . $mime_type . ';base64,' . base64_encode($data);
                return ['base64' => $base64, 'keterangan' => $image->keterangan];
            } else {
                 return ['base64' => null, 'keterangan' => $image->keterangan];
            }
        });

       
        // Encode logo RRI dan MainUp ke Base64 (menggunakan helper function)
        $logoData = $this->getBase64Logos();

        $data = [
            'maintenance' => $maintenance,
            'asset' => $maintenance->asset,
            'beforeImages' => $beforeImagesEncoded,
            'afterImages' => $afterImagesEncoded,
            'logoRriBase64' => $logoData['logoRriBase64'],
            'logoMainupBase64' => $logoData['logoMainupBase64'],
        ];

        if ($request->type === 'pdf') {
            $judul = 'LAPORAN DETAIL MAINTENANCE';
            return PDF::loadView('exports.detail-maintenance-pdf', array_merge($data, ['judul' => $judul]))
                       ->setPaper('a4', 'portrait')
                       ->stream('detail_maintenance_' . $id_maintenance . '.pdf');
        }
        
        // Remove Excel export logic for detail maintenance
        return redirect()->back()->with('error', 'Ekspor Excel tidak tersedia untuk detail maintenance ini.');
    }

    public function exportAssetDetail($id, Request $request)
    {
        $asset = Asset::with(['ruangan', 'maintenance' => function($query) {
            $query->orderBy('created_at', 'desc');
        }])->findOrFail($id);

        // Get logo data
        $logoData = $this->getBase64Logos();
        
        $data = [
            'asset' => $asset,
            'logoRriBase64' => $logoData['logoRriBase64'],
            'logoMainupBase64' => $logoData['logoMainupBase64'],
            'judul' => 'DETAIL DATA BARANG'
        ];

        if ($request->type === 'pdf') {
            return PDF::loadView('exports.asset-detail-pdf', $data)
                       ->setPaper('a4', 'portrait')
                       ->stream('detail_barang_' . $id . '.pdf');
        }
        
        return redirect()->back()->with('error', 'Tipe export tidak valid.');
    }
} 