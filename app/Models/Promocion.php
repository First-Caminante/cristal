<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Promocion extends Model
{
    protected $table = 'promociones';

    const CREATED_AT = 'creado_en';
    const UPDATED_AT = null;

    protected $fillable = [
        'titulo',
        'descripcion',
        'precio',
        'fecha_inicio',
        'fecha_fin',
    ];

    protected function casts(): array
    {
        return [
            'precio' => 'decimal:2',
            'fecha_inicio' => 'date',
            'fecha_fin' => 'date',
            'creado_en' => 'datetime',
        ];
    }

    /**
     * Relación: Una promoción tiene muchas fotos
     */
    public function fotos()
    {
        return $this->hasMany(PromocionFoto::class, 'promo_id');
    }

    /**
     * Verificar si la promoción está activa
     */
    public function getEstaActivaAttribute()
    {
        $hoy = Carbon::today();
        return $hoy->between($this->fecha_inicio, $this->fecha_fin);
    }

    /**
     * Scope para promociones activas
     */
    public function scopeActivas($query)
    {
        $hoy = Carbon::today();
        return $query->where('fecha_inicio', '<=', $hoy)
            ->where('fecha_fin', '>=', $hoy);
    }

    /**
     * Scope para promociones del mes actual
     */
    public function scopeDelMes($query)
    {
        return $query->whereMonth('fecha_inicio', Carbon::now()->month)
            ->whereYear('fecha_inicio', Carbon::now()->year);
    }
}
