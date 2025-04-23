<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ruangan;

class RuanganSeeder extends Seeder
{
    public function run()
    {
        $ruangans = [
            ['nama_ruangan' => 'Ruang Server', 'keterangan' => 'Ruangan untuk server dan perangkat jaringan'],
            ['nama_ruangan' => 'Ruang Studio', 'keterangan' => 'Ruangan untuk produksi siaran'],
            ['nama_ruangan' => 'Ruang Redaksi', 'keterangan' => 'Ruangan untuk tim redaksi'],
            ['nama_ruangan' => 'Ruang Teknisi', 'keterangan' => 'Ruangan untuk tim teknisi'],
            ['nama_ruangan' => 'Ruang Arsip', 'keterangan' => 'Ruangan untuk menyimpan arsip']
        ];

        foreach ($ruangans as $ruangan) {
            Ruangan::create($ruangan);
        }
    }
} 