<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BeforeImage extends Model
{
    use HasFactory;

    protected $table = 'before_images';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'maintenance_id',
        'original_name',
        'hashed_name',
    ];

    public function jadwal()
    {
        return $this->belongsTo(Jadwal::class, 'maintenance_id', 'id_jadwal');
    }
} 