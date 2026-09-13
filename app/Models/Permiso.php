<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Permiso extends Model
{
    protected $table = 'permisos';

    public $timestamps = false;

    protected $fillable = [
        'modulo',
        'accion',
        'descripcion',
    ];

    /**
     * Roles que tienen asignado este permiso (vía rol_permisos).
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Rol::class, 'rol_permisos', 'permiso_id', 'rol_id');
    }
    public function scopeDeModulo($query, string $modulo)
    {
        return $query->where('modulo', $modulo);
    }
}
