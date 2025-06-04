<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory;

    protected $table = 'assets';
    protected $primaryKey = 'id_aset';
    public $timestamps = false;

    protected $fillable = [
        'nama_barang',
        'merk',
        'tahun',
        'jumlah',
        'id_ruangan',
        'tipe',
        'keterangan',
        'nomor_aset'
    ];

    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class, 'id_ruangan', 'id_ruangan');
    }
    public function jadwals()
    {
        return $this->hasMany(Jadwal::class, 'id_aset');
    }
    public function maintenance()
{
    return $this->hasMany(Maintenance::class, 'id_aset', 'id_aset');
}

} 