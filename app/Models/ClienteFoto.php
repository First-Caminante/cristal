<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ClienteFoto extends Model
{
    protected $table = 'cliente_fotos';

    public $timestamps = false;

    protected $fillable = [
        'cliente_id',
        'ruta_foto',
        'descripcion',
        'orden',
    ];

    /**
     * Relación: Una foto pertenece a un cliente
     */
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    /**
     * Obtener la URL completa de la foto
     */
    public function getUrlAttribute()
    {
        return Storage::url($this->ruta_foto);
    }

    /**
     * Eliminar la foto del storage al eliminar el registro
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($foto) {
            if (Storage::exists($foto->ruta_foto)) {
                Storage::delete($foto->ruta_foto);
            }
        });
    }
}
