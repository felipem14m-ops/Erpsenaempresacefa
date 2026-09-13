<?php

namespace Modules\SGC\Models;

use Illuminate\Database\Eloquent\Model;

class Proceso extends Model
{
    protected $table = 'procesos';
    public $timestamps = false;

    protected $fillable = [
        'codigo',
        'nombre',
        'descripcion',
        'activo',
        'creado_en'
    ];

    public function areas()
    {
        return $this->hasMany(Area::class, 'proceso_id');
    }

    public function documentos()
    {
        return $this->hasMany(Documento::class, 'proceso_id');
    }

    public function listadoMaestro()
    {
        return $this->hasMany(ListadoMaestro::class, 'proceso_id');
    }
}
