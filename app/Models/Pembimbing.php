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
        'id_pend_terakhir',
        'jabatan',

        'no_telp',
        'status',
        'jk',
        'foto_profil',

    ];

    // Relasi ke User (Untuk mengambil email/password)
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function agama()
    {
        return $this->belongsTo(Agama::class, 'id_agama');
    }

    // Relasi ke Siswa Magang (1 Pembimbing memiliki banyak Siswa)
    public function siswaMagang()
    {
        return $this->hasMany(SiswaMagang::class, 'id_pembimbing', 'id_pembimbing');
    }

    public function pendidikanTerakhir()
    {
        return $this->belongsTo(PendidikanTerakhir::class, 'id_pend_terakhir', 'id_pend_terakhir');
    }
}
