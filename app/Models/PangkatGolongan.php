<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\Pangkat;
use App\Models\Golongan;

class PangkatGolongan extends Model {
    protected $table = 'pangkat_golongan';
    protected $primaryKey = 'id_pangkat_golongan';
    protected $fillable = ['id_pangkat', 'id_golongan'];

    // Relasi untuk menarik teks asli Pangkat dan Golongan
    public function pangkat() { return $this->belongsTo(Pangkat::class, 'id_pangkat'); }
    public function golongan() { return $this->belongsTo(Golongan::class, 'id_golongan'); }
}
