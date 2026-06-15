<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HariLibur extends Model
{
    use HasFactory;

    // Definisikan nama tabel secara eksplisit
    protected $table = 'hari_libur';

    // Definisikan Primary Key karena kita tidak memakai 'id' standar bawaan Laravel
    protected $primaryKey = 'id_libur';

    // Kolom-kolom yang diizinkan untuk diisi data (Mass Assignment)
    protected $fillable = [
        'nama_libur',
        'tanggal_mulai',
        'tanggal_selesai',
        'kategori',
        'keterangan'
    ];
}
