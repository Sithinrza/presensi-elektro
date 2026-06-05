<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presensi extends Model
{
    use HasFactory;

    protected $table = 'presensi';
    protected $primaryKey = 'id_presensi';

    // WAJIB UPDATE: Tambahkan id_status_ci dan id_status_co ke sini
    protected $fillable = [
        'id_user',
        'id_status_ci',
        'id_status_co',
        'tanggal',
        'jam_masuk',
        'foto_masuk',
        'latitude_masuk',
        'longitude_masuk',
        'jam_pulang',
        'foto_pulang',
        'latitude_pulang',
        'longitude_pulang',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    // Relasi ke Status Check-In
    public function statusCi()
    {
        return $this->belongsTo(StatusPresensi::class, 'id_status_ci', 'id_status_presensi');
    }

    // Relasi ke Status Check-Out
    public function statusCo()
    {
        return $this->belongsTo(StatusPresensi::class, 'id_status_co', 'id_status_presensi');
    }

    

}
