<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenilaianMagang extends Model
{
    use HasFactory;

    protected $table = 'penilaian_magang';
    protected $primaryKey = 'id_penilaian';

    // Kolom-kolom yang boleh diisi melalui form
    protected $fillable = [
        'id_siswa',
        'id_user',
        'kecakapan_kerja',
        'menerima_perintah',
        'sikap_perilaku',
        'inisiatif_kreatifitas',
        'disiplin_kehadiran',
        'tanggung_jawab',
        'pemahaman_teknis',
        'persiapan_kerja',
        'kerjasama_team',
        'mutu_hasil_kerja',
        'rata_rata',
        'nomor_sertifikat',
    ];

    // Relasi ke tabel siswa
    public function siswa()
    {
        return $this->belongsTo(SiswaMagang::class, 'id_siswa', 'id_siswa');
    }

    // Relasi ke pembimbing yang menilai (Tabel Users)
    public function pembimbing()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}
