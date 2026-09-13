<?php

namespace Modules\SGC\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class AlertaRevision extends Model
{
    protected $table = 'alertas_revision';
    public $timestamps = false;

    protected $fillable = [
        'documento_id',
        'version_id',
        'dias_restantes',
        'notificado_a',
        'activa',
        'creado_en',
        'resuelta_en'
    ];

    protected $casts = [
        'activa' => 'boolean',
        'creado_en' => 'datetime',
        'resuelta_en' => 'datetime',
    ];

    public function documento()
    {
        return $this->belongsTo(Documento::class, 'documento_id');
    }

    public function version()
    {
        return $this->belongsTo(VersionDoc::class, 'version_id');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'notificado_a');
    }
}
