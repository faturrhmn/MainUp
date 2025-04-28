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
        'keterangan'
    ];

    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class, 'id_ruangan', 'id_ruangan');
    }
} 