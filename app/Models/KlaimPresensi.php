<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KlaimPresensi extends Model
{
    use HasFactory;

    protected $table = 'klaim_presensi';

    protected $primaryKey = 'id_klaim_presensi';

    protected $fillable = [
        'id_presensi',
        'alasan',
        'dokumen_bukti',
        'status_verifikasi',
        'diverifikasi_oleh',
    ];


    public function presensi()
    {
        return $this->belongsTo(Presensi::class, 'id_presensi', 'id_presensi');
    }


    public function verifikator()
    {
        return $this->belongsTo(User::class, 'diverifikasi_oleh', 'id_user');
    }
}
