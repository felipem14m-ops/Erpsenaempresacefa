<?php

namespace Modules\SGC\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Modules\SGC\Http\Requests\Area\AreaRequest;
use Modules\SGC\Models\Area;
use Modules\SGC\Traits\RegistraBitacora;

class AreaController extends Controller
{
    use RegistraBitacora;

    /**
     * Registra una nueva área en el SGC.
     */
    public function store(AreaRequest $request)
    {
        $area = DB::transaction(function () use ($request) {
            $data = $request->validated();
            $data['codigo'] = strtoupper(trim($data['codigo']));
            $data['activo'] = $request->boolean('activo', true);
            $data['creado_en'] = now();

            $a = Area::create($data);
            $this->registrar('crear_area', 'areas', $a->id, null, $a->toArray());

            return $a;
        });

        return redirect()->back()->with('success', "Área '{$area->nombre}' ({$area->codigo}) registrada exitosamente.");
    }

    /**
     * Actualiza los datos de un área existente.
     */
    public function update(AreaRequest $request, Area $area)
    {
        DB::transaction(function () use ($request, $area) {
            $antes = $area->toArray();
            $data = $request->validated();
            $data['codigo'] = strtoupper(trim($data['codigo']));

            $area->update($data);
            $this->registrar('editar_area', 'areas', $area->id, $antes, $area->fresh()->toArray());
        });

        return redirect()->back()->with('success', "Área '{$area->nombre}' actualizada correctamente.");
    }

    /**
     * Alterna el estado activo / inactivo del área.
     */
    public function toggleStatus(Area $area)
    {
        DB::transaction(function () use ($area) {
            $antes = $area->toArray();
            $area->update(['activo' => !$area->activo]);
            $this->registrar('cambiar_estado_area', 'areas', $area->id, $antes, $area->fresh()->toArray());
        });

        $estado = $area->fresh()->activo ? 'activada' : 'desactivada';
        return redirect()->back()->with('success', "El área '{$area->nombre}' ha sido {$estado}.");
    }

    /**
     * Elimina un área verificando que no tenga documentos asociados.
     */
    public function destroy(Area $area)
    {
        if ($area->documentos()->exists()) {
            return redirect()->back()->with('error', "No se puede eliminar el área '{$area->nombre}' porque tiene documentos vinculados.");
        }

        DB::transaction(function () use ($area) {
            $antes = $area->toArray();
            $area->delete();
            $this->registrar('eliminar_area', 'areas', $area->id, $antes, null);
        });

        return redirect()->back()->with('success', "Área eliminada correctamente.");
    }
}
