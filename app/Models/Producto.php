<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Producto extends Model
{
    use HasFactory;

    protected $fillable = [
        'categoria_id',
        'nombre',
        'slug',
        'imagen',
        'caracteristicas',
        'descripcion',
        'estado'
    ];

    protected $casts = [
        'caracteristicas' => 'array',
        'estado' => 'boolean',
    ];

    /**
     * Boot function to generate slug automatically.
     */
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($producto) {
            if (empty($producto->slug)) {
                $producto->slug = Str::slug($producto->nombre);
            }
        });
    }

    /**
     * Relationship: A product belongs to a category.
     */
    public function categoria()
    {
        return $this->belongsTo(ProductoCategoria::class, 'categoria_id');
    }

    /**
     * Scope for active products.
     */
    public function scopeActive($query)
    {
        return $query->where('estado', true);
    }
}
