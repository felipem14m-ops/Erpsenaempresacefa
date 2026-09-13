<?php

namespace Modules\SGC\Http\Requests\TipoDocumento;

use Illuminate\Foundation\Http\FormRequest;

class TipoDocumentoRequest extends FormRequest
{
    /**
     * Determina si el usuario está autorizado a realizar esta solicitud.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Reglas de validación para crear o actualizar un tipo de documento.
     */
    public function rules(): array
    {
        $tipoId = $this->route('tipo_documento')?->id ?? $this->route('tipoDocumento')?->id ?? $this->route('tipo_documento') ?? $this->route('tipoDocumento');

        return [
            'codigo'      => 'required|string|max:20|unique:tipos_documento,codigo,' . ($tipoId ?? 'NULL') . ',id',
            'nombre'      => 'required|string|max:80',
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
            'codigo.required' => 'La sigla o código del tipo documental es obligatorio (ej: FO, IT, PR, MN, GU).',
            'codigo.unique'   => 'La sigla o código ingresado ya se encuentra registrado para otro tipo documental.',
            'codigo.max'      => 'El código no puede superar los 20 caracteres.',
            'nombre.required' => 'El nombre del tipo documental es obligatorio.',
            'nombre.max'      => 'El nombre no puede superar los 80 caracteres.',
            'descripcion.max' => 'La descripción no puede superar los 255 caracteres.',
        ];
    }
}
