<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClienteDireccion extends Model
{
    protected $table = 'cliente_direcciones';

    public $timestamps = false;

    protected $fillable = [
        'cliente_id',
        'zona',
        'calle',
        'coordenadas',
        'referencia',
        'es_principal',
    ];

    protected function casts(): array
    {
        return [
            'es_principal' => 'boolean',
        ];
    }

    /**
     * Relación: Una dirección pertenece a un cliente
     */
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    /**
     * Obtener la dirección completa formateada
     */
    public function getDireccionCompletaAttribute()
    {
        return "{$this->zona}, {$this->calle}";
    }
}
