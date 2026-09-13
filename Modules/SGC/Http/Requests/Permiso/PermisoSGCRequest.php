<?php

namespace Modules\SGC\Http\Requests\Permiso;

use Illuminate\Foundation\Http\FormRequest;

class PermisoSGCRequest extends FormRequest
{
    /**
     * Determina si el usuario está autorizado a realizar esta solicitud.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Reglas de validación para crear/actualizar un permiso de SGC.
     */
    public function rules(): array
    {
        return [
            'accion'      => 'required|string|max:60',
            'descripcion' => 'nullable|string|max:255',
            'modulo'      => 'required|string|in:SGC',
        ];
    }

    /**
     * El módulo NUNCA viene del formulario — se fuerza aquí para seguridad del módulo SGC.
     */
    protected function prepareForValidation(): void
    {
        $this->merge(['modulo' => 'SGC']);
    }

    /**
     * Mensajes de error personalizados en español.
     */
    public function messages(): array
    {
        return [
            'accion.required' => 'El nombre de la acción del permiso es obligatorio.',
            'accion.max'      => 'El nombre de la acción no puede superar los 60 caracteres.',
            'descripcion.max' => 'La descripción no puede superar los 255 caracteres.',
            'modulo.in'       => 'El permiso debe pertenecer exclusivamente al módulo SGC.',
        ];
    }
}
