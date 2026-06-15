<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;

    protected $table = 'logs';
    protected $primaryKey = 'id_log';

    protected $fillable = [
        'id_user',
        'title',
        'description',
        'report_date',
        'status',
        'catatan_pembimbing' // Menggunakan catatan_pembimbing hasil revisi
    ];

    // Menggunakan timestamp otomatis bawaan laravel
    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}
