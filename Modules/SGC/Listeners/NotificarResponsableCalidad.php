<?php

namespace Modules\SGC\Listeners;

use Modules\SGC\Events\SolicitudRadicada;
use App\Models\User;
use App\Models\Notificacion;

class NotificarResponsableCalidad
{
    /**
     * Handle the event.
     *
     * @param  \Modules\SGC\Events\SolicitudRadicada  $event
     * @return void
     */
    public function handle(SolicitudRadicada $event)
    {
        $solicitud = $event->solicitud;

        // Buscar usuarios que tengan el rol de Responsable de Calidad (rol_id = 2 o slug = resp_calidad)
        // Como la relación en User es 'rol', podemos consultar usando whereHas
        $responsables = User::whereHas('rol', function ($query) {
            $query->where('slug', 'resp_calidad');
        })->where('activo', 1)->get();

        foreach ($responsables as $responsable) {
            Notificacion::create([
                'usuario_id' => $responsable->id,
                'modulo'     => 'SGC',
                'tipo'       => 'solicitud_radicada',
                'titulo'     => 'Nueva Solicitud Radicada',
                'mensaje'    => 'Se ha radicado la solicitud #' . $solicitud->numero . ' para el documento ' . ($solicitud->documento ? $solicitud->documento->codigo : $solicitud->nombre_propuesto),
                'entidad'    => 'solicitudes',
                'entidad_id' => $solicitud->id,
                'leida'      => false,
            ]);
        }
    }
}
