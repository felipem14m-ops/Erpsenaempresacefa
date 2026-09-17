<?php

namespace Modules\SGC\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Bitacora extends Model
{
    protected $table = 'bitacora';
    public $timestamps = false;

    protected $fillable = [
        'usuario_id',
        'accion',
        'modulo',
        'entidad',
        'entidad_id',
        'descripcion',
        'datos_anteriores',
        'datos_nuevos',
        'ip_address',
        'user_agent',
        'resultado',
        'registrado_en'
    ];

    protected $casts = [
        'datos_anteriores' => 'array',
        'datos_nuevos' => 'array',
        'registrado_en' => 'datetime',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    /**
     * Nombre formateado del usuario o Sistema
     */
    public function getUsuarioNombreAttribute(): string
    {
        if ($this->usuario) {
            return $this->usuario->full_name;
        }
        return 'Sistema SGC';
    }

    /**
     * Rol del usuario o Sistema
     */
    public function getUsuarioRolAttribute(): string
    {
        if ($this->usuario && $this->usuario->rol) {
            return $this->usuario->rol->nombre;
        }
        if ($this->usuario) {
            return $this->usuario->primary_role ?? 'Usuario';
        }
        return 'Sistema';
    }

    /**
     * Fecha y hora formateada en formato exacto institucional (ej: 18-Ene, 10:30 AM)
     */
    public function getFechaFormateadaAttribute(): string
    {
        if (!$this->registrado_en) {
            return '';
        }

        $meses = [
            1 => 'Ene', 2 => 'Feb', 3 => 'Mar', 4 => 'Abr',
            5 => 'May', 6 => 'Jun', 7 => 'Jul', 8 => 'Ago',
            9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dic'
        ];

        $dia = $this->registrado_en->format('d');
        $mes = $meses[(int)$this->registrado_en->format('m')] ?? $this->registrado_en->format('M');
        $hora = $this->registrado_en->format('h:i A');

        return "{$dia}-{$mes}, {$hora}";
    }

    /**
     * Normalización de la acción para etiquetado visual y badges
     */
    public function getAccionNormalizadaAttribute(): string
    {
        $accion = mb_strtolower($this->accion ?? '');

        if (str_contains($accion, 'aprob') || str_contains($accion, 'aprobar')) {
            return 'Aprobación';
        }
        if (str_contains($accion, 'rechaz') || str_contains($accion, 'rechazar')) {
            return 'Rechazo';
        }
        if (str_contains($accion, 'login_fallido') || str_contains($accion, 'fallid') || str_contains($accion, 'bloqueo')) {
            return 'Acceso Fallido';
        }
        if (str_contains($accion, 'login') || str_contains($accion, 'inicio_sesion') || str_contains($accion, 'auth')) {
            return 'Inicio Sesión';
        }
        if (str_contains($accion, 'logout') || str_contains($accion, 'cierre_sesion') || str_contains($accion, 'salir')) {
            return 'Cierre Sesión';
        }
        if (str_contains($accion, 'crea') || str_contains($accion, 'crear') || str_contains($accion, 'radic') || str_contains($accion, 'subi') || str_contains($accion, 'guardar') || str_contains($accion, 'store')) {
            return 'Creación';
        }
        if (str_contains($accion, 'modif') || str_contains($accion, 'edit') || str_contains($accion, 'actualiz') || str_contains($accion, 'cambi') || str_contains($accion, 'update') || str_contains($accion, 'toggle')) {
            return 'Modificación';
        }
        if (str_contains($accion, 'descarg') || str_contains($accion, 'download') || str_contains($accion, 'export')) {
            return 'Descarga';
        }
        if (str_contains($accion, 'elimin') || str_contains($accion, 'borr') || str_contains($accion, 'destr') || str_contains($accion, 'delete')) {
            return 'Eliminación';
        }
        if (str_contains($accion, 'consult') || str_contains($accion, 'ver') || str_contains($accion, 'show') || str_contains($accion, 'index') || str_contains($accion, 'list')) {
            return 'Consulta';
        }

        return ucfirst(str_replace('_', ' ', $this->accion ?? 'Consulta'));
    }

    /**
     * Clase CSS del Badge según la acción
     */
    public function getBadgeClassAttribute(): string
    {
        return match ($this->accion_normalizada) {
            'Aprobación'     => 'badge-action-aprobacion',
            'Consulta'       => 'badge-action-consulta',
            'Modificación'   => 'badge-action-modificacion',
            'Rechazo'        => 'badge-action-rechazo',
            'Acceso Fallido' => 'badge-action-rechazo',
            'Creación'       => 'badge-action-creacion',
            'Inicio Sesión'  => 'badge-action-creacion',
            'Cierre Sesión'  => 'badge-action-consulta',
            'Descarga'       => 'badge-action-descarga',
            'Eliminación'    => 'badge-action-eliminacion',
            default          => 'badge-action-default',
        };
    }

    /**
     * Helper estático para registrar auditoría fácilmente con soporte para módulo y usuario
     */
    public static function registrar($accion, $descripcion, $entidad = null, $entidadId = null, $anteriores = null, $nuevos = null, $resultado = 'exitoso', $modulo = 'Documentos', $usuarioId = null)
    {
        try {
            return self::create([
                'usuario_id' => $usuarioId ?? auth()->id(),
                'accion' => $accion,
                'modulo' => $modulo,
                'entidad' => $entidad,
                'entidad_id' => $entidadId,
                'descripcion' => $descripcion,
                'datos_anteriores' => $anteriores,
                'datos_nuevos' => $nuevos,
                'ip_address' => request()->ip() ?? '127.0.0.1',
                'user_agent' => request()->userAgent() ?? 'Sistema SGC Web',
                'resultado' => $resultado,
                'registrado_en' => now(),
            ]);
        } catch (\Exception $e) {
            \Log::error("Error registrando en bitácora SGC: " . $e->getMessage());
            return null;
        }
    }
}

