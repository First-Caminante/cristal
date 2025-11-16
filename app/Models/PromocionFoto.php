<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class PromocionFoto extends Model
{
    protected $table = 'promociones_fotos';

    public $timestamps = false;

    protected $fillable = [
        'promo_id',
        'ruta_foto',
    ];

    /**
     * Relación: Una foto pertenece a una promoción
     */
    public function promocion()
    {
        return $this->belongsTo(Promocion::class, 'promo_id');
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
