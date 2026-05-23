<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembimbing extends Model
{
    protected $table = 'pembimbing';
    protected $primaryKey = 'id_pembimbing';

    protected $fillable = [
        'id_user',
        'id_agama',
        'no_induk',
        'nama_lengkap',
        'jabatan',
        'no_telp',
        'status'
    ];

    // Relasi ke User (Untuk mengambil email/password)
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    // Relasi ke Agama
    public function agama()
    {
        return $this->belongsTo(Agama::class, 'id_agama');
    }
}
