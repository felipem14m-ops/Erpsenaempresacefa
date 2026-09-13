<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreUsuarioRequest extends FormRequest
{
    /**
     * Determina si el usuario está autorizado a realizar esta solicitud.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Reglas de validación para crear un usuario.
     */
    public function rules(): array
    {
        return [
            'nombre_completo'     => 'required|string|max:120',
            'documento_identidad' => 'nullable|string|max:20|unique:usuarios,documento_identidad',
            'nombre_usuario'      => 'required|string|min:3|max:60|unique:usuarios,nombre_usuario|regex:/^[a-zA-Z0-9._-]+$/',
            'correo'              => 'required|string|email|max:120|unique:usuarios,correo',
            'telefono'            => 'nullable|string|max:20',
            'rol_id'              => 'required|integer|exists:roles,id',
            'password'            => 'required|string|min:8|confirmed',
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
            'documento_identidad.unique'   => 'Este documento de identidad ya se encuentra registrado.',
            'nombre_usuario.required'      => 'El nombre de usuario es obligatorio.',
            'nombre_usuario.unique'        => 'Este nombre de usuario ya está en uso.',
            'nombre_usuario.regex'         => 'El nombre de usuario solo puede contener caracteres alfanuméricos, puntos, guiones y guiones bajos.',
            'correo.required'              => 'El correo electrónico es obligatorio.',
            'correo.email'                 => 'Debes ingresar un correo electrónico válido.',
            'correo.unique'                => 'Este correo electrónico ya está registrado.',
            'rol_id.required'              => 'Debes seleccionar un rol para el usuario.',
            'rol_id.exists'                => 'El rol seleccionado no es válido.',
            'password.required'            => 'La contraseña es obligatoria.',
            'password.min'                 => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed'           => 'La confirmación de la contraseña no coincide.',
        ];
    }
}
