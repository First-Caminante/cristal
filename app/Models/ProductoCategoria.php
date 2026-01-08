<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ProductoCategoria extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'slug', 'estado'];

    protected $casts = [
        'estado' => 'boolean',
    ];

    /**
     * Boot function to generate slug automatically.
     */
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($categoria) {
            if (empty($categoria->slug)) {
                $categoria->slug = Str::slug($categoria->nombre);
            }
        });
    }

    /**
     * Relationship: A category has many products.
     */
    public function productos()
    {
        return $this->hasMany(Producto::class, 'categoria_id');
    }

    /**
     * Scope for active categories.
     */
    public function scopeActive($query)
    {
        return $query->where('estado', true);
    }
}
