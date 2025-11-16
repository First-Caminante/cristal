<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';

    public $timestamps = false;

    protected $fillable = [
        'nombre'
    ];

    /**
     * Relación: Un rol tiene muchos usuarios
     */
    public function usuarios()
    {
        return $this->hasMany(User::class, 'rol_id');
    }
}
