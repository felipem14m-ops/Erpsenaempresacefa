<?php

namespace Modules\SGC\Listeners;

use Modules\SGC\Events\SolicitudRespondida;
use App\Models\Notificacion;

class NotificarLiderArea
{
    /**
     * Handle the event.
     *
     * @param  \Modules\SGC\Events\SolicitudRespondida  $event
     * @return void
     */
    public function handle(SolicitudRespondida $event)
    {
        $solicitud = $event->solicitud;

        if ($solicitud->solicitado_por) {
            Notificacion::create([
                'usuario_id' => $solicitud->solicitado_por,
                'modulo'     => 'SGC',
                'tipo'       => 'solicitud_respondida',
                'titulo'     => 'Solicitud Respondida',
                'mensaje'    => 'Su solicitud #' . $solicitud->numero . ' ha sido procesada con estado: ' . $solicitud->estado,
                'entidad'    => 'solicitudes',
                'entidad_id' => $solicitud->id,
                'leida'      => false,
            ]);
        }
    }
}
