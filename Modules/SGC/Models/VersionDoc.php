<?php

namespace Modules\SGC\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class VersionDoc extends Model
{
    protected $table = 'versiones_doc';
    public $timestamps = false;

    protected $fillable = [
        'documento_id',
        'numero_version',
        'descripcion_cambio',
        'archivo_ruta',
        'archivo_nombre',
        'archivo_tamano_kb',
        'archivo_formato',
        'estado',
        'publicado_por',
        'fecha_publicacion',
        'fecha_obsolescencia',
        'creado_por',
        'creado_en'
    ];

    protected $casts = [
        'fecha_publicacion' => 'datetime',
        'fecha_obsolescencia' => 'datetime',
        'creado_en' => 'datetime',
    ];

    public function documento()
    {
        return $this->belongsTo(Documento::class, 'documento_id');
    }

    public function publicador()
    {
        return $this->belongsTo(User::class, 'publicado_por');
    }

    public function creador()
    {
        return $this->belongsTo(User::class, 'creado_por');
    }
}
