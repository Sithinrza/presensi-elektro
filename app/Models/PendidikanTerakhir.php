<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PendidikanTerakhir extends Model
{
    protected $table = 'pendidikan_terakhir';
    protected $primaryKey = 'id_pend_terakhir';
    protected $fillable = ['name'];
}
