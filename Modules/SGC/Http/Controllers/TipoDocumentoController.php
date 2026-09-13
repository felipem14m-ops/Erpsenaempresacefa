<?php

namespace Modules\SGC\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Modules\SGC\Http\Requests\TipoDocumento\TipoDocumentoRequest;
use Modules\SGC\Models\TipoDocumento;
use Modules\SGC\Traits\RegistraBitacora;

class TipoDocumentoController extends Controller
{
    use RegistraBitacora;

    /**
     * Registra un nuevo tipo documental en el SGC.
     */
    public function store(TipoDocumentoRequest $request)
    {
        $tipo = DB::transaction(function () use ($request) {
            $data = $request->validated();
            $data['codigo'] = strtoupper(trim($data['codigo']));
            $data['activo'] = $request->boolean('activo', true);

            $t = TipoDocumento::create($data);
            $this->registrar('crear_tipo_documento', 'tipos_documento', $t->id, null, $t->toArray());

            return $t;
        });

        return redirect()->back()->with('success', "Tipo documental '{$tipo->nombre}' ({$tipo->codigo}) registrado exitosamente.");
    }

    /**
     * Actualiza los datos de un tipo documental existente.
     */
    public function update(TipoDocumentoRequest $request, TipoDocumento $tipoDocumento)
    {
        DB::transaction(function () use ($request, $tipoDocumento) {
            $antes = $tipoDocumento->toArray();
            $data = $request->validated();
            $data['codigo'] = strtoupper(trim($data['codigo']));

            $tipoDocumento->update($data);
            $this->registrar('editar_tipo_documento', 'tipos_documento', $tipoDocumento->id, $antes, $tipoDocumento->fresh()->toArray());
        });

        return redirect()->back()->with('success', "Tipo documental '{$tipoDocumento->nombre}' actualizado correctamente.");
    }

    /**
     * Alterna el estado activo / inactivo del tipo documental.
     */
    public function toggleStatus(TipoDocumento $tipoDocumento)
    {
        DB::transaction(function () use ($tipoDocumento) {
            $antes = $tipoDocumento->toArray();
            $tipoDocumento->update(['activo' => !$tipoDocumento->activo]);
            $this->registrar('cambiar_estado_tipo_documento', 'tipos_documento', $tipoDocumento->id, $antes, $tipoDocumento->fresh()->toArray());
        });

        $estado = $tipoDocumento->fresh()->activo ? 'activado' : 'desactivado';
        return redirect()->back()->with('success', "El tipo documental '{$tipoDocumento->nombre}' ha sido {$estado}.");
    }

    /**
     * Elimina un tipo documental verificando que no tenga documentos asociados.
     */
    public function destroy(TipoDocumento $tipoDocumento)
    {
        if ($tipoDocumento->documentos()->exists()) {
            return redirect()->back()->with('error', "No se puede eliminar el tipo documental '{$tipoDocumento->nombre}' porque está asignado a documentos existentes.");
        }

        DB::transaction(function () use ($tipoDocumento) {
            $antes = $tipoDocumento->toArray();
            $tipoDocumento->delete();
            $this->registrar('eliminar_tipo_documento', 'tipos_documento', $tipoDocumento->id, $antes, null);
        });

        return redirect()->back()->with('success', "Tipo documental eliminado correctamente.");
    }
}
