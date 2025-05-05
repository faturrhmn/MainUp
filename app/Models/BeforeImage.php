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
        'id_maintenance',
        'original_name',
        'hashed_name',
    ];

    public function maintenance()
    {
        return $this->belongsTo(Maintenance::class, 'id_maintenance', 'id_maintenance');
    }
}
