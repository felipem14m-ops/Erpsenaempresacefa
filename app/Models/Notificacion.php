<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class Notificacion extends Model
{
    protected $table = 'notificaciones';

    const CREATED_AT = 'creado_en';
    const UPDATED_AT = null;

    protected $fillable = [
        'usuario_id',
        'tipo',
        'titulo',
        'mensaje',
        'entidad',
        'entidad_id',
        'leida',
        'leida_en',
    ];

    protected function casts(): array
    {
        return [
            'leida'     => 'boolean',
            'leida_en'  => 'datetime',
            'creado_en' => 'datetime',
        ];
    }

    /**
     * Usuario destinatario de la notificación.
     */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    /**
     * Helper estático para notificar a un usuario individual.
     */
    public static function notificarUsuario(int $usuarioId, string $tipo, string $titulo, string $mensaje, ?string $entidad = null, ?int $entidadId = null): ?self
    {
        try {
            return self::create([
                'usuario_id' => $usuarioId,
                'tipo'       => $tipo,
                'titulo'     => $titulo,
                'mensaje'    => $mensaje,
                'entidad'    => $entidad,
                'entidad_id' => $entidadId,
                'leida'      => false,
                'creado_en'  => now(),
            ]);
        } catch (\Exception $e) {
            \Log::error("Error enviando notificación a usuario {$usuarioId}: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Helper estático para notificar a todos los usuarios con roles específicos (ej: Calidad, Admin).
     */
    public static function notificarRol($roles, string $tipo, string $titulo, string $mensaje, ?string $entidad = null, ?int $entidadId = null, ?int $exceptUserId = null): int
    {
        try {
            $rolesArray = is_array($roles) ? $roles : [$roles];

            $query = User::where('activo', true)
                ->where(function ($q) use ($rolesArray) {
                    $q->whereIn('rol_id', $rolesArray)
                      ->orWhereHas('rol', function ($qr) use ($rolesArray) {
                          $qr->whereIn('slug', $rolesArray)->orWhereIn('nombre', $rolesArray);
                      });
                });

            if ($exceptUserId) {
                $query->where('id', '!=', $exceptUserId);
            }

            $users = $query->get(['id']);
            $count = 0;

            foreach ($users as $user) {
                self::create([
                    'usuario_id' => $user->id,
                    'tipo'       => $tipo,
                    'titulo'     => $titulo,
                    'mensaje'    => $mensaje,
                    'entidad'    => $entidad,
                    'entidad_id' => $entidadId,
                    'leida'      => false,
                    'creado_en'  => now(),
                ]);
                $count++;
            }

            return $count;
        } catch (\Exception $e) {
            \Log::error("Error enviando notificación a roles: " . $e->getMessage());
            return 0;
        }
    }

    /**
     * Formato de tiempo relativo en español (ej: "hace 5 min", "hace 2 horas", "18-Ene")
     */
    public function getTiempoRelativoAttribute(): string
    {
        if (!$this->creado_en) {
            return 'Reciente';
        }

        $now = Carbon::now();
        $diffMin = $now->diffInMinutes($this->creado_en);

        if ($diffMin < 1) {
            return 'Hace un momento';
        }
        if ($diffMin < 60) {
            return "Hace {$diffMin} min";
        }

        $diffHours = $now->diffInHours($this->creado_en);
        if ($diffHours < 24) {
            return "Hace {$diffHours} " . ($diffHours == 1 ? 'hora' : 'horas');
        }

        $meses = [1 => 'Ene', 2 => 'Feb', 3 => 'Mar', 4 => 'Abr', 5 => 'May', 6 => 'Jun', 7 => 'Jul', 8 => 'Ago', 9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dic'];
        $dia = $this->creado_en->format('d');
        $mes = $meses[(int)$this->creado_en->format('m')] ?? $this->creado_en->format('M');
        return "{$dia}-{$mes}";
    }

    /**
     * Ícono según el tipo de evento
     */
    public function getIconClassAttribute(): string
    {
        return match ($this->tipo) {
            'solicitud_radicada'    => 'fas fa-file-circle-plus',
            'solicitud_en_revision' => 'fas fa-clock-rotate-left',
            'solicitud_aprobada'    => 'fas fa-circle-check',
            'solicitud_rechazada'   => 'fas fa-circle-xmark',
            'documento_publicado'   => 'fas fa-file-circle-check',
            'alerta_revision'       => 'fas fa-triangle-exclamation',
            default                 => 'fas fa-bell',
        };
    }

    /**
     * Color del ícono y badge
     */
    public function getIconColorAttribute(): string
    {
        return match ($this->tipo) {
            'solicitud_radicada'    => '#2563eb', // Azul
            'solicitud_en_revision' => '#d97706', // Ámbar
            'solicitud_aprobada'    => '#15803d', // Verde
            'solicitud_rechazada'   => '#b91c1c', // Rojo
            'documento_publicado'   => '#007832', // Verde SENA
            'alerta_revision'       => '#ea580c', // Naranja
            default                 => '#64748b', // Slate
        };
    }

    /**
     * Ruta destino según el tipo de entidad y usuario
     */
    public function getUrlDestinoAttribute(): string
    {
        if ($this->entidad === 'solicitudes' && $this->entidad_id) {
            $user = auth()->user();
            $isLider = $user && ($user->rol_id == 3 || str_contains(strtolower($user->rol->nombre ?? ''), 'lider'));

            if ($isLider) {
                return route('sgc.lider_area.solicitudes.show', $this->entidad_id);
            }
            return route('sgc.solicitudes.evaluar', $this->entidad_id);
        }

        if ($this->entidad === 'documentos' && $this->entidad_id) {
            return route('sgc.documentos.show', $this->entidad_id);
        }

        return route('sgc.dashboard');
    }
}

