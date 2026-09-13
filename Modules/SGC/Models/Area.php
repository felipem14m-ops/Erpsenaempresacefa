<?php

namespace Modules\SGC\Models;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $table = 'areas';
    public $timestamps = false;

    protected $fillable = [
        'codigo',
        'nombre',
        'proceso_id',
        'activo',
        'creado_en'
    ];

    public function proceso()
    {
        return $this->belongsTo(Proceso::class, 'proceso_id');
    }

    public function documentos()
    {
        return $this->hasMany(Documento::class, 'area_id');
    }
}
