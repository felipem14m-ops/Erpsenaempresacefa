<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Modules\SICA\Entities\Person;
use Modules\SICA\Entities\Role;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $table = 'usuarios';

    const CREATED_AT = 'creado_en';
    const UPDATED_AT = 'actualizado_en';

    protected $fillable = [
        'nombre_completo',
        'documento_identidad',
        'nombre_usuario',
        'correo',
        'telefono',
        'password_hash',
        'rol_id',
        'activo',
        'intentos_fallidos',
        'bloqueado_hasta',
        'ultimo_acceso',
        'creado_por',
    ];

    protected $hidden = [
        'password_hash',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'activo'            => 'boolean',
            'intentos_fallidos' => 'integer',
            'bloqueado_hasta'   => 'datetime',
            'ultimo_acceso'     => 'datetime',
            'email_verified_at' => 'datetime',
        ];
    }

    /**
     * Sobrescribe el campo de contraseña para la autenticación de Laravel.
     */
    public function getAuthPassword(): string
    {
        return $this->password_hash;
    }

    /**
     * Correo electrónico para el restablecimiento de contraseña.
     */
    public function getEmailForPasswordReset(): string
    {
        return $this->correo;
    }

    /*
    |--------------------------------------------------------------------------
    | Relaciones del Núcleo Unificado
    |--------------------------------------------------------------------------
    */

    /**
     * Rol principal asignado al usuario.
     */
    public function rol(): BelongsTo
    {
        return $this->belongsTo(Rol::class, 'rol_id');
    }

    /**
     * Sesiones iniciadas por el usuario.
     */
    public function sesiones(): HasMany
    {
        return $this->hasMany(Sesion::class, 'usuario_id');
    }

    /**
     * Notificaciones dirigidas al usuario.
     */
    public function notificaciones(): HasMany
    {
        return $this->hasMany(Notificacion::class, 'usuario_id');
    }

    /**
     * Registros de auditoría generados por el usuario.
     */
    public function bitacoras(): HasMany
    {
        return $this->hasMany(Bitacora::class, 'usuario_id');
    }

    /**
     * Usuario administrador que creó esta cuenta.
     */
    public function creador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creado_por');
    }

    /**
     * Usuarios creados por este usuario.
     */
    public function usuariosCreados(): HasMany
    {
        return $this->hasMany(User::class, 'creado_por');
    }

    /**
     * Persona vinculada (Módulo SICA).
     */
    public function person(): BelongsTo
    {
        return $this->belongsTo(Person::class, 'person_id');
    }

    /**
     * Roles asignados al usuario (Compatibilidad SICA).
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_user')->withTimestamps();
    }

    /*
    |--------------------------------------------------------------------------
    | Autorización y Control de Acceso por Módulo
    |--------------------------------------------------------------------------
    */

    /**
     * Verifica si el usuario tiene acceso a un módulo (y acción opcional)
     * mediante los permisos vinculados a su rol en rol_permisos.
     *
     * @param string $modulo Nombre del módulo (SGC, SST, Control_ECP, SIGE, SISGEDI, Apicola, SISIG, core)
     * @param string|null $accion Acción específica requerida (opcional)
     */
    public function tieneAccesoModulo(string $modulo, ?string $accion = null): bool
    {
        if (!$this->activo) {
            return false;
        }

        // Si el usuario es administrador global, tiene acceso total a todos los módulos
        if ($this->hasSuperAdmin()) {
            return true;
        }

        // Consulta si el rol principal tiene el permiso asociado al módulo
        if ($this->rol && $this->rol->tienePermiso($modulo, $accion)) {
            return true;
        }

        return false;
    }

    /**
     * Verifica si el usuario cuenta con el rol superadmin / administrador.
     */
    public function hasSuperAdmin(): bool
    {
        if ($this->rol && in_array(strtolower($this->rol->slug), ['superadmin', 'admin', 'administrador'])) {
            return true;
        }

        return false;
    }

    /**
     * Verifica si el usuario tiene un rol específico por slug.
     */
    public function hasRole(string $roleSlug): bool
    {
        if ($this->hasSuperAdmin()) {
            return true;
        }

        return $this->rol && $this->rol->slug === $roleSlug;
    }

    /**
     * Verifica si el usuario tiene alguno de los roles indicados.
     */
    public function hasAnyRole(array $roles): bool
    {
        if ($this->hasSuperAdmin()) {
            return true;
        }

        return $this->rol && in_array($this->rol->slug, $roles);
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors & Helpers Visuales
    |--------------------------------------------------------------------------
    */

    public function getFullNameAttribute(): string
    {
        if (!empty($this->nombre_completo)) {
            return $this->nombre_completo;
        }

        if (!empty($this->nombre_usuario)) {
            return $this->nombre_usuario;
        }

        return $this->correo ?? 'Usuario';
    }

    public function getPrimaryRoleAttribute(): string
    {
        return $this->rol?->nombre ?? 'Usuario';
    }

    public function getInitialsAttribute(): string
    {
        $name = trim($this->full_name);
        $words = explode(' ', $name);
        $initials = '';
        foreach (array_slice($words, 0, 2) as $w) {
            if (!empty($w)) {
                $initials .= mb_strtoupper(mb_substr($w, 0, 1));
            }
        }
        return !empty($initials) ? $initials : 'SE';
    }
}
