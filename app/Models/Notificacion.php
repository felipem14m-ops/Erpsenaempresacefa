<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notificacion extends Model
{
    protected $table = 'notificaciones';

    const CREATED_AT = 'creado_en';
    const UPDATED_AT = null;

    protected $fillable = [
        'usuario_id',
        'modulo',
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
}
