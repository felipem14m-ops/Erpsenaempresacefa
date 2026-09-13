<?php

namespace Modules\SGC\Http\Requests\Permiso;

use Illuminate\Foundation\Http\FormRequest;

class AsignarPermisoSGCRequest extends FormRequest
{
    /**
     * Determina si el usuario está autorizado a realizar esta solicitud.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Reglas de validación para asignar o retirar un permiso a un rol.
     */
    public function rules(): array
    {
        return [
            'rol_id'     => 'required|exists:roles,id',
            'permiso_id' => 'required|exists:permisos,id',
        ];
    }

    /**
     * Mensajes de error personalizados en español.
     */
    public function messages(): array
    {
        return [
            'rol_id.required'     => 'Debe especificar el rol.',
            'rol_id.exists'       => 'El rol seleccionado no es válido en el sistema.',
            'permiso_id.required' => 'Debe especificar el permiso.',
            'permiso_id.exists'   => 'El permiso seleccionado no es válido en el sistema.',
        ];
    }
}
