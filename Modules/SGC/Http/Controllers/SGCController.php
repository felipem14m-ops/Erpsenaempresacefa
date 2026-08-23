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
        return view('sgc::Resp_Calidad.Dashboard');
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
