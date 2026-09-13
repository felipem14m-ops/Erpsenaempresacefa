<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
     * Reglas de validación para actualizar un usuario.
     */
    public function rules(): array
    {
        $userId = $this->route('usuario') ? $this->route('usuario')->id : $this->route('user');

        return [
            'nombre_completo'     => 'required|string|max:120',
            'documento_identidad' => [
                'nullable',
                'string',
                'max:20',
                Rule::unique('usuarios', 'documento_identidad')->ignore($userId),
            ],
            'nombre_usuario'      => [
                'required',
                'string',
                'min:3',
                'max:60',
                'regex:/^[a-zA-Z0-9._-]+$/',
                Rule::unique('usuarios', 'nombre_usuario')->ignore($userId),
            ],
            'correo'              => [
                'required',
                'string',
                'email',
                'max:120',
                Rule::unique('usuarios', 'correo')->ignore($userId),
            ],
            'telefono'            => 'nullable|string|max:20',
            'rol_id'              => 'required|integer|exists:roles,id',
            'password'            => 'nullable|string|min:8|confirmed',
            'activo'              => 'nullable|boolean',
        ];
    }

    /**
     * Mensajes personalizados de validación.
     */
    public function messages(): array
    {
        return [
            'nombre_completo.required'     => 'El nombre completo es obligatorio.',
            'nombre_completo.max'          => 'El nombre completo no debe superar los 120 caracteres.',
            'documento_identidad.unique'   => 'Este documento de identidad ya se encuentra registrado por otro usuario.',
            'nombre_usuario.required'      => 'El nombre de usuario es obligatorio.',
            'nombre_usuario.unique'        => 'Este nombre de usuario ya está en uso por otro usuario.',
            'nombre_usuario.regex'         => 'El nombre de usuario solo puede contener caracteres alfanuméricos, puntos, guiones y guiones bajos.',
            'correo.required'              => 'El correo electrónico es obligatorio.',
            'correo.email'                 => 'Debes ingresar un correo electrónico válido.',
            'correo.unique'                => 'Este correo electrónico ya está registrado por otro usuario.',
            'rol_id.required'              => 'Debes seleccionar un rol para el usuario.',
            'rol_id.exists'                => 'El rol seleccionado no es válido.',
            'password.min'                 => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed'           => 'La confirmación de la contraseña no coincide.',
        ];
    }
}
