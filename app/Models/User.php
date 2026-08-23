<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
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
        'nombre_usuario',
        'correo',
        'password_hash',
        'rol_id',
        'activo',
    ];

    protected $hidden = [
        'password_hash',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Persona vinculada al usuario
     */
    public function person()
    {
        return $this->belongsTo(Person::class, 'person_id');
    }

    /**
     * Rol principal asignado al usuario (Relación con Rol)
     */
    public function rol()
    {
        return $this->belongsTo(Rol::class, 'rol_id');
    }

    /**
     * Roles asignados al usuario (SICA)
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user')->withTimestamps();
    }

    /**
     * Para que la autenticación de Laravel use la columna password_hash en lugar de password
     */
    public function getAuthPassword()
    {
        return $this->password_hash;
    }

    /**
     * Verifica si el usuario tiene un rol por slug o si tiene acceso superadmin
     */
    public function hasRole(string $roleSlug): bool
    {
        // Si el usuario es superadmin, tiene acceso completo
        if ($this->hasSuperAdmin()) {
            return true;
        }

        if ($this->rol && $this->rol->slug === $roleSlug) {
            return true;
        }

        return $this->roles->contains('slug', $roleSlug);
    }

    /**
     * Verifica si el usuario tiene alguno de los roles indicados
     */
    public function hasAnyRole(array $roles): bool
    {
        if ($this->hasSuperAdmin()) {
            return true;
        }

        if ($this->rol && in_array($this->rol->slug, $roles)) {
            return true;
        }

        return $this->roles->whereIn('slug', $roles)->isNotEmpty();
    }

    /**
     * Verifica si el usuario cuenta con el rol superadmin
     */
    public function hasSuperAdmin(): bool
    {
        if ($this->rol && ($this->rol->slug === 'superadmin' || $this->rol->slug === 'admin')) {
            return true;
        }

        return $this->roles->contains(function ($role) {
            return $role->slug === 'superadmin' || $role->full_access === 'Si';
        });
    }

    /**
     * Obtiene el nombre completo del usuario a partir de su persona o nickname
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

    /**
     * Obtiene el nombre del rol principal del usuario
     */
    public function getPrimaryRoleAttribute(): string
    {
        if ($this->rol) {
            return $this->rol->nombre;
        }

        return 'Usuario';
    }

    /**
     * Obtiene las iniciales del usuario para mostrar en el avatar
     */
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
