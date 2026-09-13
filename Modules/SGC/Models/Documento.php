<?php

namespace Modules\SGC\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Documento extends Model
{
    protected $table = 'documentos';
    const CREATED_AT = 'creado_en';
    const UPDATED_AT = 'actualizado_en';

    protected $fillable = [
        'codigo',
        'nombre',
        'descripcion',
        'proceso_id',
        'area_id',
        'tipo_doc_id',
        'responsable_id',
        'estado',
        'fecha_elaboracion',
        'fecha_proxima_revision',
        'fecha_publicacion',
        'fecha_obsolescencia',
        'creado_por',
        'creado_en',
        'actualizado_en'
    ];

    protected $casts = [
        'fecha_elaboracion' => 'date',
        'fecha_proxima_revision' => 'date',
        'fecha_publicacion' => 'datetime',
        'fecha_obsolescencia' => 'datetime',
        'creado_en' => 'datetime',
        'actualizado_en' => 'datetime',
    ];

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

    public function responsable()
    {
        return $this->belongsTo(User::class, 'responsable_id');
    }

    public function creador()
    {
        return $this->belongsTo(User::class, 'creado_por');
    }

    public function versiones()
    {
        return $this->hasMany(VersionDoc::class, 'documento_id')->orderBy('id', 'desc');
    }

    public function versionActual()
    {
        return $this->hasOne(VersionDoc::class, 'documento_id')->latestOfMany('id');
    }

    public function historialEstados()
    {
        return $this->hasMany(HistorialEstado::class, 'documento_id')->orderBy('id', 'desc');
    }

    public function listadoMaestro()
    {
        return $this->hasOne(ListadoMaestro::class, 'documento_id');
    }

    public function frecuentes()
    {
        return $this->hasMany(DocumentoFrecuente::class, 'documento_id');
    }
}
