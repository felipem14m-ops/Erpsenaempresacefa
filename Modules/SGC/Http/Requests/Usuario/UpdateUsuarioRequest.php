<?php

namespace Modules\SGC\Http\Requests\Usuario;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUsuarioRequest extends FormRequest
{
    /**
     * Determina si el usuario está autorizado a realizar esta solicitud.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Reglas de validación para actualizar la información de un usuario en el SGC.
     */
    public function rules(): array
    {
        $userId = $this->route('user') ?? $this->route('id');

        return [
            'nombre_completo' => 'required|string|max:255',
            'nombre_usuario'  => 'required|string|max:255|unique:usuarios,nombre_usuario,' . $userId,
            'correo'          => 'required|string|email|max:255|unique:usuarios,correo,' . $userId,
            'rol_id'          => 'required|exists:roles,id',
            'password'        => 'nullable|string|min:8',
            'activo'          => 'nullable|boolean',
        ];
    }

    /**
     * Mensajes de validación personalizados en español.
     */
    public function messages(): array
    {
        return [
            'nombre_completo.required' => 'El nombre completo es obligatorio.',
            'nombre_usuario.required'  => 'El nombre de usuario es obligatorio.',
            'nombre_usuario.unique'    => 'El nombre de usuario ya está asignado a otra cuenta.',
            'correo.required'          => 'El correo electrónico es obligatorio.',
            'correo.email'             => 'Debe ingresar un correo electrónico válido.',
            'correo.unique'            => 'El correo electrónico ya está registrado por otro usuario.',
            'rol_id.required'          => 'Debe seleccionar un rol para el usuario.',
            'rol_id.exists'            => 'El rol seleccionado no es válido.',
            'password.min'             => 'Si ingresa una nueva contraseña, debe tener al menos 8 caracteres.',
        ];
    }
}
