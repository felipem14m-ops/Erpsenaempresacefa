<?php

namespace Modules\SGC\Http\Requests\Solicitud;

use Illuminate\Foundation\Http\FormRequest;

class StoreSolicitudRequest extends FormRequest
{
    /**
     * Determina si el usuario está autorizado a radicar una solicitud.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Reglas de validación para radicar una solicitud documental en el SGC.
     */
    public function rules(): array
    {
        return [
            'tipo'         => 'required|in:creacion,modificacion,eliminacion',
            'proceso_id'   => 'required|exists:procesos,id',
            'area_id'      => 'required|exists:areas,id',
            'tipo_doc_id'  => 'nullable|exists:tipos_documento,id',
            'documento_id' => 'nullable|exists:documentos,id',
            'justificacion'=> 'required|string|min:10',
            'adjunto'      => 'nullable|file|mimes:pdf,docx,doc,xlsx,xls,png,jpg|max:20480',
        ];
    }

    /**
     * Mensajes de validación en español.
     */
    public function messages(): array
    {
        return [
            'tipo.required'         => 'Debe seleccionar el tipo de solicitud (Creación, Modificación o Eliminación).',
            'tipo.in'               => 'El tipo de solicitud seleccionado no es válido.',
            'proceso_id.required'   => 'Debe seleccionar el proceso correspondiente.',
            'proceso_id.exists'     => 'El proceso seleccionado no existe.',
            'area_id.required'      => 'Debe seleccionar el área solicitante.',
            'area_id.exists'        => 'El área seleccionada no existe.',
            'justificacion.required'=> 'La justificación de la solicitud es obligatoria.',
            'justificacion.min'     => 'La justificación debe contener al menos 10 caracteres explicativos.',
            'adjunto.mimes'         => 'El archivo borrador debe estar en formato PDF, Word, Excel o Imagen.',
            'adjunto.max'           => 'El archivo borrador no puede superar los 20 MB.',
        ];
    }
}
