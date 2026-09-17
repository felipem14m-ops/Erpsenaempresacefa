<?php

namespace Modules\SGC\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notificacion;
use Illuminate\Http\JsonResponse;

class NotificacionController extends Controller
{
    /**
     * Retorna el listado de notificaciones recientes y el conteo de no leídas para el usuario autenticado.
     */
    public function index(): JsonResponse
    {
        $userId = auth()->id();
        if (!$userId) {
            return response()->json([
                'unread_count' => 0,
                'notificaciones' => []
            ]);
        }

        $unreadCount = Notificacion::where('usuario_id', $userId)
            ->where('leida', false)
            ->count();

        $notificaciones = Notificacion::where('usuario_id', $userId)
            ->orderBy('id', 'desc')
            ->take(10)
            ->get()
            ->map(function ($notif) {
                return [
                    'id' => $notif->id,
                    'tipo' => $notif->tipo,
                    'titulo' => $notif->titulo,
                    'mensaje' => $notif->mensaje,
                    'tiempo' => $notif->tiempo_relativo,
                    'leida' => (bool)$notif->leida,
                    'icon_class' => $notif->icon_class,
                    'icon_color' => $notif->icon_color,
                    'url' => $notif->url_destino,
                ];
            });

        return response()->json([
            'unread_count' => $unreadCount,
            'notificaciones' => $notificaciones,
        ]);
    }

    /**
     * Marca una notificación específica como leída.
     */
    public function marcarLeida($id): JsonResponse
    {
        $userId = auth()->id();
        $notif = Notificacion::where('id', $id)
            ->where('usuario_id', $userId)
            ->first();

        if ($notif) {
            $notif->update([
                'leida' => true,
                'leida_en' => now()
            ]);
        }

        return response()->json(['success' => true]);
    }

    /**
     * Marca todas las notificaciones pendientes del usuario como leídas.
     */
    public function marcarTodasLeidas(): JsonResponse
    {
        $userId = auth()->id();
        if ($userId) {
            Notificacion::where('usuario_id', $userId)
                ->where('leida', false)
                ->update([
                    'leida' => true,
                    'leida_en' => now()
                ]);
        }

        return response()->json(['success' => true]);
    }
}
