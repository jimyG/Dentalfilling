<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users'; // Asegúrate de que apunta a la tabla correcta

    protected $fillable = ['name', 'email', 'password'];

    /**
     * Relación de muchos a muchos con roles.
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_user', 'user_id', 'role_id');
    }

    /**
     * Verificar si el usuario tiene un rol específico.
     */
    public function hasRole($role): bool
    {
        return $this->roles()->where('name', $role)->exists();
    }
}
