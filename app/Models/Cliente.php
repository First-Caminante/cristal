<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'clientes';

    const CREATED_AT = 'creado_en';
    const UPDATED_AT = null;

    protected $fillable = [
        'nombres',
        'apellidos',
        'cedula_identidad',
        'correo',
    ];

    protected function casts(): array
    {
        return [
            'creado_en' => 'datetime',
        ];
    }

    /**
     * Relación: Un cliente tiene muchos teléfonos (máx 3)
     */
    public function telefonos()
    {
        return $this->hasMany(ClienteTelefono::class, 'cliente_id');
    }

    /**
     * Relación: Un cliente tiene UNA dirección
     */
    public function direccion()
    {
        return $this->hasOne(ClienteDireccion::class, 'cliente_id');
    }

    /**
     * Relación: Un cliente tiene muchas fotos (máx 3)
     */
    public function fotos()
    {
        return $this->hasMany(ClienteFoto::class, 'cliente_id')->orderBy('orden');
    }

    /**
     * Obtener el nombre completo del cliente
     */
    public function getNombreCompletoAttribute()
    {
        return "{$this->nombres} {$this->apellidos}";
    }

    /**
     * Obtener el teléfono principal
     */
    public function getTelefonoPrincipalAttribute()
    {
        return $this->telefonos()->where('es_principal', 1)->first();
    }
}
