<?php

namespace Modules\SGC\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class HistorialEstado extends Model
{
    protected $table = 'historial_estados';
    public $timestamps = false;

    protected $fillable = [
        'documento_id',
        'version_id',
        'estado_anterior',
        'estado_nuevo',
        'observaciones',
        'cambiado_por',
        'cambiado_en'
    ];

    protected $casts = [
        'cambiado_en' => 'datetime',
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
        return $this->belongsTo(User::class, 'cambiado_por');
    }
}
