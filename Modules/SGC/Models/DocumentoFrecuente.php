<?php

namespace Modules\SGC\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class DocumentoFrecuente extends Model
{
    protected $table = 'documentos_frecuentes';
    public $timestamps = false;

    protected $fillable = [
        'usuario_id',
        'documento_id',
        'total_accesos',
        'ultimo_acceso'
    ];

    protected $casts = [
        'ultimo_acceso' => 'datetime',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function documento()
    {
        return $this->belongsTo(Documento::class, 'documento_id');
    }

    /**
     * Incrementa el acceso a un documento para un usuario
     */
    public static function registrarAcceso($usuarioId, $documentoId)
    {
        if (!$usuarioId || !$documentoId) return;

        $registro = self::where('usuario_id', $usuarioId)
            ->where('documento_id', $documentoId)
            ->first();

        if ($registro) {
            $registro->increment('total_accesos');
            $registro->update(['ultimo_acceso' => now()]);
        } else {
            self::create([
                'usuario_id' => $usuarioId,
                'documento_id' => $documentoId,
                'total_accesos' => 1,
                'ultimo_acceso' => now(),
            ]);
        }
    }
}
