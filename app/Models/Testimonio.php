<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonio extends Model
{
    protected $table = 'testimonios';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = null;

    protected $fillable = [
        'nombre',
        'comentario',
        'fuente',
        'fecha_publicacion',
        'visible',
    ];

    protected function casts(): array
    {
        return [
            'fecha_publicacion' => 'date',
            'visible' => 'boolean',
            'created_at' => 'datetime',
        ];
    }

    /**
     * Scope para obtener solo testimonios visibles
     */
    public function scopeVisible($query)
    {
        return $query->where('visible', 1);
    }

    /**
     * Scope para obtener testimonios recientes
     */
    public function scopeRecientes($query)
    {
        return $query->orderBy('fecha_publicacion', 'desc');
    }
}
