<?php

namespace Modules\SGC\Http\Requests\Proceso;

use Illuminate\Foundation\Http\FormRequest;

class ProcesoRequest extends FormRequest
{
    /**
     * Determina si el usuario está autorizado a realizar esta solicitud.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Reglas de validación para crear o actualizar un proceso.
     */
    public function rules(): array
    {
        $procesoId = $this->route('proceso')?->id ?? $this->route('proceso');

        return [
            'codigo'      => 'required|string|max:20|unique:procesos,codigo,' . ($procesoId ?? 'NULL') . ',id',
            'nombre'      => 'required|string|max:100',
            'descripcion' => 'nullable|string|max:255',
            'activo'      => 'nullable|boolean',
        ];
    }

    /**
     * Mensajes de error personalizados en español.
     */
    public function messages(): array
    {
        return [
            'codigo.required' => 'El código del proceso es obligatorio.',
            'codigo.unique'   => 'El código ingresado ya se encuentra registrado para otro proceso.',
            'codigo.max'      => 'El código no puede superar los 20 caracteres.',
            'nombre.required' => 'El nombre del proceso es obligatorio.',
            'nombre.max'      => 'El nombre del proceso no puede superar los 100 caracteres.',
            'descripcion.max' => 'La descripción no puede superar los 255 caracteres.',
        ];
    }
}
