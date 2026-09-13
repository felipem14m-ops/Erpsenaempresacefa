<?php

namespace Modules\SGC\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\SGC\Models\Proceso;
use Modules\SGC\Models\Area;
use Modules\SGC\Models\TipoDocumento;

class CatalogosController extends Controller
{
    /**
     * Muestra la vista principal con los 3 catálogos maestros del SGC:
     * 1. Procesos: Macroprocesos institucionales.
     * 2. Áreas: Dependencias y unidades productivas vinculadas a un proceso.
     * 3. Tipos Documentales: Catálogo global e independiente de formatos/tipologías (FO, IT, PR, MN, GU, RG).
     */
    public function index()
    {
        $procesos = Proceso::withCount(['areas', 'documentos'])->orderBy('nombre')->get();
        $areas = Area::with(['proceso'])->withCount('documentos')->orderBy('nombre')->get();
        $tiposDocumento = TipoDocumento::withCount('documentos')->orderBy('nombre')->get();

        if (view()->exists('sgc::Admin.Catalogo.Catalogo')) {
            return view('sgc::Admin.Catalogo.Catalogo', compact('procesos', 'areas', 'tiposDocumento'));
        }

        if (view()->exists('sgc::Admin.Catalogo.index')) {
            return view('sgc::Admin.Catalogo.index', compact('procesos', 'areas', 'tiposDocumento'));
        }

        return view('sgc::catalogos.index', compact('procesos', 'areas', 'tiposDocumento'));
    }
}
