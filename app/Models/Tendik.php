<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Pastikan memanggil model relasinya jika ingin aman dari garis merah
use App\Models\User;

use App\Models\Agama;
use App\Models\PendidikanTerakhir;

use App\Models\Jabatan;

class Tendik extends Model
{
    protected $table = 'tendik';
    protected $primaryKey = 'id_tendik';

    protected $fillable = [
        'id_agama',
        'id_user',
        'id_pend_terakhir',
        'id_jabatan',
        'nip',
        'nama_lengkap',
        'jk',
        'tempat_lahir',
        'tanggal_lahir',
        'no_hp',
        'alamat',
        'foto_profil',
        'status'
    ];

    // --- RELASI LAMA ---
    public function user() {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function agama() {
        return $this->belongsTo(Agama::class, 'id_agama');
    }
    public function pendidikanTerakhir() {
        return $this->belongsTo(PendidikanTerakhir::class, 'id_pend_terakhir');
    }




    // 2. Relasi langsung ke tabel Jabatan
    public function jabatan() {
        return $this->belongsTo(Jabatan::class, 'id_jabatan');
    }
}
