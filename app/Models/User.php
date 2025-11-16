<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Especificar la tabla correcta
    protected $table = 'usuarios';

    // Laravel espera 'created_at' y 'updated_at', pero nuestra tabla tiene 'creado_en'
    const CREATED_AT = 'creado_en';
    const UPDATED_AT = null; // No tenemos updated_at

    protected $fillable = [
        'nombre',
        'apellido',
        'correo',
        'telefono',
        'password',
        'rol_id',
        'estado',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'creado_en' => 'datetime',
            'password' => 'hashed',
            'estado' => 'boolean',
        ];
    }

    /**
     * Relación: Un usuario pertenece a un rol
     */
    public function role()
    {
        return $this->belongsTo(Role::class, 'rol_id');
    }

    /**
     * Verificar si el usuario es superadmin
     */
    public function isSuperAdmin()
    {
        return $this->role->nombre === 'superadmin';
    }

    /**
     * Verificar si el usuario es administrador
     */
    public function isAdmin()
    {
        return $this->role->nombre === 'administrador';
    }

    /**
     * Verificar si el usuario es vendedor
     */
    public function isVendedor()
    {
        return $this->role->nombre === 'vendedor';
    }

    /**
     * Obtener el nombre completo
     */
    public function getNombreCompletoAttribute()
    {
        return "{$this->nombre} {$this->apellido}";
    }

    // Override para que use 'correo' en vez de 'email'
    public function getEmailForPasswordReset()
    {
        return $this->correo;
    }

    /**
     * Especificar el campo para autenticación
     */
    public function getAuthIdentifierName()
    {
        return 'correo';
    }

    /**
     * Get the name of the unique identifier for the user.
     */
    public function getEmailAttribute()
    {
        return $this->correo;
    }
}
