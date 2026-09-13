<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class Bitacora extends Model
{
    protected $table = 'bitacora';

    const CREATED_AT = 'registrado_en';
    const UPDATED_AT = null;

    protected $fillable = [
        'usuario_id',
        'modulo',
        'accion',
        'entidad',
        'entidad_id',
        'descripcion',
        'datos_anteriores',
        'datos_nuevos',
        'ip_address',
        'user_agent',
        'resultado',
        'registrado_en',
    ];

    protected function casts(): array
    {
        return [
            'datos_anteriores' => 'array',
            'datos_nuevos' => 'array',
            'registrado_en' => 'datetime',
        ];
    }

    /**
     * Usuario que ejecutó la acción.
     */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    /**
     * Helper estático para registrar eventos de auditoría de forma estandarizada.
     *
     * @param string $modulo Nombre del módulo (core, SGC, SST, etc.)
     * @param string $accion Nombre de la acción efectuada
     * @param string $descripcion Descripción legible del evento
     * @param array $opciones Parámetros adicionales (entidad, entidad_id, datos_anteriores, datos_nuevos, resultado, usuario_id)
     */
    public static function registrar(string $modulo, string $accion, string $descripcion, array $opciones = []): self
    {
        return self::create([
            'usuario_id'       => $opciones['usuario_id'] ?? Auth::id(),
            'modulo'           => $modulo,
            'accion'           => $accion,
            'entidad'          => $opciones['entidad'] ?? null,
            'entidad_id'       => $opciones['entidad_id'] ?? null,
            'descripcion'      => $descripcion,
            'datos_anteriores' => $opciones['datos_anteriores'] ?? null,
            'datos_nuevos'     => $opciones['datos_nuevos'] ?? null,
            'ip_address'       => $opciones['ip_address'] ?? (request() ? request()->ip() : null),
            'user_agent'       => $opciones['user_agent'] ?? (request() ? substr((string) request()->userAgent(), 0, 255) : null),
            'resultado'        => $opciones['resultado'] ?? 'exitoso',
            'registrado_en'    => now(),
        ]);
    }
}
