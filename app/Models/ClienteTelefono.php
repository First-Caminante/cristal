<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClienteTelefono extends Model
{
    protected $table = 'cliente_telefonos';

    public $timestamps = false;

    protected $fillable = [
        'cliente_id',
        'telefono',
        'descripcion',
        'es_principal',
    ];

    protected function casts(): array
    {
        return [
            'es_principal' => 'boolean',
        ];
    }

    /**
     * Relación: Un teléfono pertenece a un cliente
     */
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }
}
