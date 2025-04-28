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
            ['nama_ruangan' => 'Ruang Arsip', 'keterangan' => 'Ruangan untuk menyimpan arsip'],
            ['nama_ruangan' => 'Multimedia', 'keterangan' => 'Ruangan untuk multimedia'],
            ['nama_ruangan' => 'RRI Net', 'keterangan' => 'Ruangan untuk RRI Net'],
            ['nama_ruangan' => 'Master Control Room', 'keterangan' => 'Ruangan untuk Master Control Room'],
            ['nama_ruangan' => 'Editing', 'keterangan' => 'Ruangan untuk Editing'],
            ['nama_ruangan' => 'Podcast', 'keterangan' => 'Ruangan untuk Podcast'],
            ['nama_ruangan' => 'Ruang Agenda Setting', 'keterangan' => 'Ruangan untuk Agenda Setting'],
            ['nama_ruangan' => 'Studio Integrasi Programa 1', 'keterangan' => 'Ruangan untuk Studio Integrasi Programa 1'],
            ['nama_ruangan' => 'Studio Tradisional', 'keterangan' => 'Ruangan untuk Studio Tradisional'],
            ['nama_ruangan' => 'Studio Integrasi Programa 2', 'keterangan' => 'Ruangan untuk Studio Integrasi Programa 2'],
            ['nama_ruangan' => 'Studio Integrasi Programma 4', 'keterangan' => 'Ruangan untuk Studio Integrasi Programma 4'],
            ['nama_ruangan' => 'Studio Multi Purpuse', 'keterangan' => 'Ruangan untuk Studio Multi Purpuse'],
            ['nama_ruangan' => 'Ruang Agenda Setting', 'keterangan' => 'Ruangan untuk Agenda Setting'],
            ['nama_ruangan' => 'Podcast', 'keterangan' => 'Ruangan untuk Podcast'],
            ['nama_ruangan' => 'OB Van Mercy', 'keterangan' => 'Ruangan untuk OB Van Mercy'],
            ['nama_ruangan' => 'OB Van Peogeut', 'keterangan' => 'Ruangan untuk OB Van Peogeut'],
            ['nama_ruangan' => 'Peralatan Sound System', 'keterangan' => 'Ruangan untuk Peralatan Sound System'],
            ['nama_ruangan' => 'OBF Van Satelit', 'keterangan' => 'Ruangan untuk OBF Van Satelit'],
            
            
        ];

        foreach ($ruangans as $ruangan) {
            Ruangan::create($ruangan);
        }
    }
} 