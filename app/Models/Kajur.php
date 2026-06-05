<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kajur extends Model
{
    use HasFactory;
    protected $table = 'kajur';
    protected $primaryKey = 'id_kajur';

    protected $fillable = [
        'nama_lengkap',
        'nip',
        'periode',
        'status_aktif'
    ];

    // Mengubah nilai 0/1 dari database menjadi boolean true/false di Laravel
    protected $casts = [
        'status_aktif' => 'boolean',
    ];
}
