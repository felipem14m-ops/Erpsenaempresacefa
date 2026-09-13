<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Sesion extends Model
{
    protected $table = 'sesiones';

    protected $keyType = 'string';
    public $incrementing = false;

    const CREATED_AT = 'creado_en';
    const UPDATED_AT = null;

    protected $fillable = [
        'id',
        'usuario_id',
        'ip_address',
        'user_agent',
        'expira_en',
        'cerrado_en',
        'activa',
    ];

    protected function casts(): array
    {
        return [
            'creado_en'  => 'datetime',
            'expira_en'  => 'datetime',
            'cerrado_en' => 'datetime',
            'activa'     => 'boolean',
        ];
    }

    /**
     * Usuario propietario de la sesión.
     */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}
