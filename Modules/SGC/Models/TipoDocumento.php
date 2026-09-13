<?php

namespace Modules\SGC\Models;

use Illuminate\Database\Eloquent\Model;

class TipoDocumento extends Model
{
    protected $table = 'tipos_documento';
    public $timestamps = false;

    protected $fillable = [
        'codigo',
        'nombre',
        'descripcion',
        'activo'
    ];

    public function documentos()
    {
        return $this->hasMany(Documento::class, 'tipo_doc_id');
    }
}
