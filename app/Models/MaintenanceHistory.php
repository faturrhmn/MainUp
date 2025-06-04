<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'maintenance_id',
        'tanggal_perbaikan_sebelumnya',
        'keterangan',
    ];

    // Relasi ke Maintenance
    public function maintenance()
    {
        return $this->belongsTo(Maintenance::class, 'maintenance_id', 'id_maintenance');
    }
} 