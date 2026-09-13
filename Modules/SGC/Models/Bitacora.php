<?php

namespace Modules\SGC\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Bitacora extends Model
{
    protected $table = 'bitacora';
    public $timestamps = false;

    protected $fillable = [
        'usuario_id',
        'accion',
        'modulo',
        'entidad',
        'entidad_id',
        'descripcion',
        'datos_anteriores',
        'datos_nuevos',
        'ip_address',
        'user_agent',
        'resultado',
        'registrado_en'
    ];

    protected $casts = [
        'datos_anteriores' => 'array',
        'datos_nuevos' => 'array',
        'registrado_en' => 'datetime',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    /**
     * Helper estático para registrar auditoría fácilmente
     */
    public static function registrar($accion, $descripcion, $entidad = null, $entidadId = null, $anteriores = null, $nuevos = null, $resultado = 'exitoso')
    {
        try {
            return self::create([
                'usuario_id' => auth()->id(),
                'accion' => $accion,
                'modulo' => 'Documentos',
                'entidad' => $entidad,
                'entidad_id' => $entidadId,
                'descripcion' => $descripcion,
                'datos_anteriores' => $anteriores,
                'datos_nuevos' => $nuevos,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'resultado' => $resultado,
                'registrado_en' => now(),
            ]);
        } catch (\Exception $e) {
            \Log::error("Error registrando en bitácora SGC: " . $e->getMessage());
            return null;
        }
    }
}
