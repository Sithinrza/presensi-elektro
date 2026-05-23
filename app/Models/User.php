<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $primaryKey = 'id_user'; // Beritahu Laravel PK-nya id_user

    protected $fillable = [
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function roles()
    {
        // Relasi Many-to-Many ke tabel roles melewati tabel pivot role_user
        return $this->belongsToMany(Role::class, 'role_user', 'id_user', 'id_role');
    }

    // Cek apakah user punya role tertentu (Berguna untuk Middleware/Gate nanti)
    public function hasRole($roleName)
    {
        return $this->roles()->where('name', $roleName)->exists();
    }

    // Relasi One to One ke Profil
    public function tendik()
    {
        return $this->hasOne(Tendik::class, 'id_user');
    }

    public function siswaMagang()
    {
        return $this->hasOne(SiswaMagang::class, 'id_user');
    }
}
