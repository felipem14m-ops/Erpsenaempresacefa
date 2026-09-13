<?php

namespace Modules\SGC\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class ListadoMaestro extends Model
{
    protected $table = 'listado_maestro';
    public $timestamps = false;

    protected $fillable = [
        'documento_id',
        'version_id',
        'proceso_id',
        'publicado_por',
        'fecha_pub',
        'activo'
    ];

    protected $casts = [
        'fecha_pub' => 'datetime',
        'activo' => 'boolean',
    ];

    public function documento()
    {
        return $this->belongsTo(Documento::class, 'documento_id');
    }

    public function version()
    {
        return $this->belongsTo(VersionDoc::class, 'version_id');
    }

    public function proceso()
    {
        return $this->belongsTo(Proceso::class, 'proceso_id');
    }

    public function publicador()
    {
        return $this->belongsTo(User::class, 'publicado_por');
    }
}
