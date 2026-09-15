<?php

namespace Modules\SGC\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Modules\SGC\Models\Solicitud;

class SolicitudRespondida
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $solicitud;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Solicitud $solicitud)
    {
        $this->solicitud = $solicitud;
    }
}
