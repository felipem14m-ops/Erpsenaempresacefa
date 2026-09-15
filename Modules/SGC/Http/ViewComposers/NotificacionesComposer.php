<?php

namespace Modules\SGC\Http\ViewComposers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Notificacion;

class NotificacionesComposer
{
    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $notificacionesSinLeer = collect();

        if (Auth::check()) {
            $notificacionesSinLeer = Notificacion::where('usuario_id', Auth::id())
                ->where('leida', false)
                ->orderBy('creado_en', 'desc')
                ->get();
        }

        $view->with('notificacionesSinLeer', $notificacionesSinLeer);
    }
}
