<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    use HasFactory;

    // Nama tabel di database
    protected $table = 'maintenance';

    // Primary key (jika bukan 'id')
    protected $primaryKey = 'id_maintenance';

    // Kolom yang boleh diisi massal
    protected $fillable = [
        'id_aset',
        'tanggal_perbaikan',
        'keterangan',
        'pic',
        'teknisi',
        'status',
        'created_at',
        'updated_at'
    ];

    // Contoh relasi ke tabel aset (jika ada model Asset)
    public function asset()
    {
        return $this->belongsTo(Asset::class, 'id_aset', 'id_aset');
    }

    // Contoh relasi ke tabel before_proses (jika ada)
    public function beforeImages()
    {
        return $this->hasMany(BeforeImage::class, 'id_maintenance', 'id_maintenance');
    }
    
    public function afterImages()
    {
        return $this->hasMany(AfterImage::class, 'id_maintenance', 'id_maintenance');
    }
    
}
