<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    use HasFactory;

    protected $table = 'jadwal';
    protected $primaryKey = 'id_jadwal';
    public $timestamps = false;

    protected $fillable = [
        'siklus',
        'tanggal_mulai',
        'id_aset',
        'tanggal_perbaikan',
        'status_perbaikan',
        'keterangan',
    ];

    // Definisikan nilai enum sebagai array
    const SIKLUS_OPTIONS = [
        'hari' => 'Hari',
        'minggu' => 'Minggu',
        'bulan' => 'Bulan',
        '3_bulan' => '3 Bulan',
        '6_bulan' => '6 Bulan',
        '1_tahun' => '1 Tahun',
    ];

    
    public function asset()
    {
        return $this->belongsTo(Asset::class, 'id_aset', 'id_aset');
    }

    public function maintenance()
    {
        return $this->hasOne(Maintenance::class, 'id_aset', 'id_aset');
    }
}
