<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Rol extends Model
{
    protected $table = 'roles';

    const CREATED_AT = 'creado_en';
    const UPDATED_AT = null;

    protected $fillable = [
        'nombre',
        'slug',
        'descripcion',
    ];

    /**
     * Usuarios asignados a este rol.
     */
    public function usuarios(): HasMany
    {
        return $this->hasMany(User::class, 'rol_id');
    }

    /**
     * Permisos asignados a este rol mediante la tabla pivote rol_permisos.
     */
    public function permisos(): BelongsToMany
    {
        return $this->belongsToMany(Permiso::class, 'rol_permisos', 'rol_id', 'permiso_id');
    }

    /**
     * Verifica si el rol tiene un permiso asignado para un módulo y acción opcional.
     */
    public function tienePermiso(string $modulo, ?string $accion = null): bool
    {
        return $this->permisos()
            ->where('modulo', $modulo)
            ->when($accion, fn($query) => $query->where('accion', $accion))
            ->exists();
    }
}