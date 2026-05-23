<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';
    protected $primaryKey = 'id_role';
    protected $fillable = ['name'];

    // Relasi Many-to-Many ke User
    public function users()
    {
        return $this->belongsToMany(User::class, 'role_user', 'id_role', 'id_user');
    }
}
