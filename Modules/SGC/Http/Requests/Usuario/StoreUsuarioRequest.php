<?php

namespace Modules\SGC\Http\Requests\Usuario;

use Illuminate\Foundation\Http\FormRequest;

class StoreUsuarioRequest extends FormRequest
{
    /**
     * Determina si el usuario está autorizado a realizar esta solicitud.
     * La verificación general de acceso ya fue validada por el middleware de ruta.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Reglas de validación para registrar un nuevo usuario en el SGC.
     */
    public function rules(): array
    {
        return [
            'nombre_completo' => 'required|string|max:255',
            'nombre_usuario'  => 'required|string|max:255|unique:usuarios,nombre_usuario',
            'correo'          => 'required|string|email|max:255|unique:usuarios,correo',
            'rol_id'          => 'required|exists:roles,id',
            'password'        => 'required|string|min:8',
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
            'nombre_usuario.unique'    => 'El nombre de usuario ya se encuentra registrado.',
            'correo.required'          => 'El correo electrónico institucional es obligatorio.',
            'correo.email'             => 'Debe ingresar un correo electrónico válido.',
            'correo.unique'            => 'El correo electrónico ya está registrado en el sistema.',
            'rol_id.required'          => 'Debe seleccionar un rol para el usuario.',
            'rol_id.exists'            => 'El rol seleccionado no es válido.',
            'password.required'        => 'La contraseña es obligatoria.',
            'password.min'             => 'La contraseña debe tener al menos 8 caracteres.',
        ];
    }
}
