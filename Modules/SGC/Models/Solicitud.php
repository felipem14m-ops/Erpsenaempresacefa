<?php

namespace Modules\SGC\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Solicitud extends Model
{
    protected $table = 'solicitudes';
    const CREATED_AT = 'creado_en';
    const UPDATED_AT = 'actualizado_en';

    protected $fillable = [
        'numero',
        'tipo',
        'estado',
        'documento_id',
        'nombre_propuesto',
        'proceso_id',
        'area_id',
        'tipo_doc_id',
        'justificacion',
        'descripcion_cambio',
        'adjunto_ruta',
        'solicitado_por',
        'asignado_a',
        'observaciones_resp',
        'fecha_radicacion',
        'fecha_resolucion',
        'creado_en',
        'actualizado_en'
    ];

    protected $casts = [
        'fecha_radicacion' => 'datetime',
        'fecha_resolucion' => 'datetime',
        'creado_en' => 'datetime',
        'actualizado_en' => 'datetime',
    ];

    public function documento()
    {
        return $this->belongsTo(Documento::class, 'documento_id');
    }

    public function proceso()
    {
        return $this->belongsTo(Proceso::class, 'proceso_id');
    }

    public function area()
    {
        return $this->belongsTo(Area::class, 'area_id');
    }

    public function tipoDoc()
    {
        return $this->belongsTo(TipoDocumento::class, 'tipo_doc_id');
    }

    public function solicitante()
    {
        return $this->belongsTo(User::class, 'solicitado_por');
    }

    public function asignado()
    {
        return $this->belongsTo(User::class, 'asignado_a');
    }
}
