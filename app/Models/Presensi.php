<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Presensi extends Model
{
    protected $table = 'presensi';
    protected $primaryKey = 'id_presensi';

    protected $fillable = [
        'id_user', 'id_status_presensi', 'tanggal',
        'jam_masuk', 'foto_masuk', 'latitude_masuk', 'longitude_masuk',
        'jam_pulang', 'foto_pulang', 'latitude_pulang', 'longitude_pulang'
    ];

    public function user() { return $this->belongsTo(User::class, 'id_user'); }
    public function statusPresensi() { return $this->belongsTo(StatusPresensi::class, 'id_status_presensi'); }
}
