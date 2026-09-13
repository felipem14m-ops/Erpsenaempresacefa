<?php

namespace Modules\SGC\Http\Requests\Documento;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDocumentoRequest extends FormRequest
{
    /**
     * Determina si el usuario está autorizado a realizar esta solicitud.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Reglas de validación para actualizar los datos de un documento existente en el SGC.
     */
    public function rules(): array
    {
        return [
            'nombre'                 => 'required|string|max:200',
            'proceso_id'             => 'required|exists:procesos,id',
            'area_id'                => 'required|exists:areas,id',
            'tipo_doc_id'            => 'required|exists:tipos_documento,id',
            'responsable_id'         => 'required|exists:usuarios,id',
            'fecha_proxima_revision' => 'nullable|date',
            'descripcion'            => 'nullable|string',
            'archivo'                => 'nullable|file|mimes:pdf,docx,doc|max:25600',
        ];
    }

    /**
     * Mensajes de validación personalizados en español.
     */
    public function messages(): array
    {
        return [
            'nombre.required'        => 'El nombre del documento es obligatorio.',
            'nombre.max'             => 'El nombre del documento no puede superar los 200 caracteres.',
            'proceso_id.required'    => 'Debe seleccionar el proceso al que pertenece el documento.',
            'proceso_id.exists'      => 'El proceso seleccionado no es válido.',
            'area_id.required'       => 'Debe seleccionar el área correspondiente.',
            'area_id.exists'         => 'El área seleccionada no es válida.',
            'tipo_doc_id.required'   => 'Debe seleccionar el tipo de documento.',
            'tipo_doc_id.exists'     => 'El tipo de documento seleccionado no es válido.',
            'responsable_id.required'=> 'Debe asignar un responsable para el documento.',
            'responsable_id.exists'  => 'El usuario responsable seleccionado no es válido.',
            'archivo.mimes'          => 'Solo se aceptan archivos en formato PDF, DOCX o DOC.',
            'archivo.max'            => 'El tamaño del archivo no puede superar los 25 MB.',
        ];
    }
}
