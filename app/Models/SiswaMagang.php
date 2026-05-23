<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiswaMagang extends Model
{
    protected $table = 'siswa_magang';

    // REVISI: Sesuaikan dengan nama kolom asli di phpMyAdmin kamu 👇
    protected $primaryKey = 'id_siswa';

    protected $fillable = [
        'id_user',
        'id_agama',
        'id_pembimbing',
        'nama_lengkap',
        'nis',
        'sekolah_asal',
        'jurusan',
        'jk',
        'tempat_lahir',
        'tanggal_lahir',
        'no_hp',
        'alamat',
        'tanggal_mulai',
        'tanggal_selesai',
        'status'
    ];

    public function user() { return $this->belongsTo(User::class, 'id_user'); }
    public function agama() { return $this->belongsTo(Agama::class, 'id_agama'); }

    public function logbook()
    {
        return $this->hasMany(Log::class, 'id_user', 'id_user');
    }

    public function presensi() {
        return $this->hasMany(Presensi::class, 'id_user', 'id_user');
    }
}
