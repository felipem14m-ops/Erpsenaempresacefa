<?php

namespace Modules\SGC\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Modules\SGC\Http\Requests\Proceso\ProcesoRequest;
use Modules\SGC\Models\Proceso;
use Modules\SGC\Traits\RegistraBitacora;

class ProcesoController extends Controller
{
    use RegistraBitacora;

    /**
     * Registra un nuevo proceso en el SGC.
     */
    public function store(ProcesoRequest $request)
    {
        $proceso = DB::transaction(function () use ($request) {
            $data = $request->validated();
            $data['codigo'] = strtoupper(trim($data['codigo']));
            $data['activo'] = $request->boolean('activo', true);
            $data['creado_en'] = now();

            $p = Proceso::create($data);
            $this->registrar('crear_proceso', 'procesos', $p->id, null, $p->toArray());

            return $p;
        });

        return redirect()->back()->with('success', "Proceso '{$proceso->nombre}' ({$proceso->codigo}) registrado exitosamente.");
    }

    /**
     * Actualiza los datos de un proceso existente.
     */
    public function update(ProcesoRequest $request, Proceso $proceso)
    {
        DB::transaction(function () use ($request, $proceso) {
            $antes = $proceso->toArray();
            $data = $request->validated();
            $data['codigo'] = strtoupper(trim($data['codigo']));

            $proceso->update($data);
            $this->registrar('editar_proceso', 'procesos', $proceso->id, $antes, $proceso->fresh()->toArray());
        });

        return redirect()->back()->with('success', "Proceso '{$proceso->nombre}' actualizado correctamente.");
    }

    /**
     * Alterna el estado activo / inactivo del proceso.
     */
    public function toggleStatus(Proceso $proceso)
    {
        DB::transaction(function () use ($proceso) {
            $antes = $proceso->toArray();
            $proceso->update(['activo' => !$proceso->activo]);
            $this->registrar('cambiar_estado_proceso', 'procesos', $proceso->id, $antes, $proceso->fresh()->toArray());
        });

        $estado = $proceso->fresh()->activo ? 'activado' : 'desactivado';
        return redirect()->back()->with('success', "El proceso '{$proceso->nombre}' ha sido {$estado}.");
    }

    /**
     * Elimina un proceso verificando que no tenga áreas ni documentos vinculados.
     */
    public function destroy(Proceso $proceso)
    {
        if ($proceso->documentos()->exists() || $proceso->areas()->exists()) {
            return redirect()->back()->with('error', "No se puede eliminar el proceso '{$proceso->nombre}' porque contiene áreas o documentos asociados.");
        }

        DB::transaction(function () use ($proceso) {
            $antes = $proceso->toArray();
            $proceso->delete();
            $this->registrar('eliminar_proceso', 'procesos', $proceso->id, $antes, null);
        });

        return redirect()->back()->with('success', "Proceso eliminado correctamente.");
    }
}
