<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatusPresensi extends Model
{
    protected $table = 'status_presensi';
    protected $primaryKey = 'id_status_presensi';
    protected $fillable = ['name'];
}
