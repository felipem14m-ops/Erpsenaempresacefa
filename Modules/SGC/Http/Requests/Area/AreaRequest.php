<?php

namespace Modules\SGC\Http\Requests\Area;

use Illuminate\Foundation\Http\FormRequest;

class AreaRequest extends FormRequest
{
    /**
     * Determina si el usuario está autorizado a realizar esta solicitud.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Reglas de validación para crear o actualizar un área.
     */
    public function rules(): array
    {
        $areaId = $this->route('area')?->id ?? $this->route('area');

        return [
            'codigo'     => 'required|string|max:20|unique:areas,codigo,' . ($areaId ?? 'NULL') . ',id',
            'nombre'     => 'required|string|max:100',
            'proceso_id' => 'required|exists:procesos,id',
            'activo'     => 'nullable|boolean',
        ];
    }

    /**
     * Mensajes de error personalizados en español.
     */
    public function messages(): array
    {
        return [
            'codigo.required'     => 'El código del área es obligatorio.',
            'codigo.unique'       => 'El código ingresado ya se encuentra registrado para otra área.',
            'codigo.max'          => 'El código no puede superar los 20 caracteres.',
            'nombre.required'     => 'El nombre del área es obligatorio.',
            'nombre.max'          => 'El nombre del área no puede superar los 100 caracteres.',
            'proceso_id.required' => 'Debe seleccionar el proceso al que pertenece esta área.',
            'proceso_id.exists'   => 'El proceso seleccionado no es válido en el sistema.',
        ];
    }
}
