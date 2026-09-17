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
     * Soporta múltiples acciones separadas por '|' o ',' (operador OR).
     */
    public function tienePermiso(string $modulo, ?string $accion = null): bool
    {
        if (!$accion) {
            return $this->permisos()->where('modulo', $modulo)->exists();
        }

        if (str_contains($accion, '|') || str_contains($accion, ',')) {
            $delimitador = str_contains($accion, '|') ? '|' : ',';
            $acciones = array_map('trim', explode($delimitador, $accion));
            return $this->permisos()
                ->where('modulo', $modulo)
                ->whereIn('accion', $acciones)
                ->exists();
        }

        return $this->permisos()
            ->where('modulo', $modulo)
            ->where('accion', $accion)
            ->exists();
    }
}