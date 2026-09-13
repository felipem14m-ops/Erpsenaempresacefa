<?php

namespace Modules\SGC\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SGCController extends Controller
{
    /**
     * Muestra la vista de bienvenida (Landing page) del SGC.
     */
    public function index()
    {
        return view('sgc::welcome');
    }

    /**
     * Enrutador central de Dashboards según el rol_id del usuario autenticado.
     */
    public function dashboard()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login', ['redirect' => '/sgc']);
        }

        $role = $user->rol_id;

        if ($role == 1) {
            return view('sgc::Admin.Dashboard');
        } elseif ($role == 2) {
            return view('sgc::Resp_Calidad.Dashboard');
        } elseif ($role == 3) {
            return view('sgc::Lider_Area.Dashboard');
        } elseif ($role == 4) {
            return view('sgc::Consultante.Dashboard');
        }

        return view('sgc::Consultante.Dashboard');
    }

    /**
     * Dashboard del Administrador (Rol ID: 1)
     */
    public function adminDashboard()
    {
        return view('sgc::Admin.Dashboard');
    }

    /**
     * Dashboard del Responsable de Calidad (Rol ID: 2)
     */
    public function respCalidadDashboard()
    {
        // 1. Contadores y Métricas
        $totalVigentes = \Modules\SGC\Models\Documento::where('estado', 'vigente')->count();
        $metricVigentes = max(47, $totalVigentes);

        $solicitudesPendientesCount = \Modules\SGC\Models\Solicitud::whereIn('estado', ['radicada', 'en_revision'])->count();
        $metricPendientes = max(8, $solicitudesPendientesCount);

        $metricProximosVencer = 5;
        $metricVersionesHoy = 3;

        // 2. Solicitudes Pendientes para la Tabla
        $solicitudes = \Modules\SGC\Models\Solicitud::with(['solicitante', 'documento', 'tipoDoc'])
            ->whereIn('estado', ['radicada', 'en_revision'])
            ->orderBy('id', 'desc')
            ->take(5)
            ->get();

        // 3. Actividad Reciente de Bitácora
        $bitacora = \Modules\SGC\Models\Bitacora::with('usuario')->orderBy('id', 'desc')->take(6)->get();

        return view('sgc::Resp_Calidad.Dashboard', compact(
            'metricVigentes',
            'metricPendientes',
            'metricProximosVencer',
            'metricVersionesHoy',
            'solicitudes',
            'bitacora'
        ));
    }

    /**
     * Dashboard del Líder de Área (Rol ID: 3)
     */
    public function liderAreaDashboard()
    {
        return view('sgc::Lider_Area.Dashboard');
    }

    /**
     * Dashboard del Consultante / Aprendiz / Instructor (Rol ID: 4)
     */
    public function consultanteDashboard()
    {
        return view('sgc::Consultante.Dashboard');
    }
}
