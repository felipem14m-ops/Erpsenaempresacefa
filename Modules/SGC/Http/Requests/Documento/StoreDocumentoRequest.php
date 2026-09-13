<?php

namespace Modules\SGC\Http\Requests\Documento;

use Illuminate\Foundation\Http\FormRequest;

class StoreDocumentoRequest extends FormRequest
{
    /**
     * Determina si el usuario está autorizado a realizar esta solicitud.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Reglas de validación para registrar un nuevo documento en el SGC.
     */
    public function rules(): array
    {
        return [
            'nombre'                 => 'required|string|max:200',
            'codigo'                 => 'required|string|max:30|unique:documentos,codigo',
            'numero_version'         => 'required|string|max:20',
            'proceso_id'             => 'required|exists:procesos,id',
            'area_id'                => 'required|exists:areas,id',
            'tipo_doc_id'            => 'required|exists:tipos_documento,id',
            'responsable_id'         => 'required|exists:usuarios,id',
            'fecha_elaboracion'      => 'required|date',
            'fecha_proxima_revision' => 'nullable|date|after_or_equal:fecha_elaboracion',
            'descripcion'            => 'nullable|string',
            'descripcion_cambio'     => 'nullable|string',
            'archivo'                => 'required|file|mimes:pdf,docx,doc|max:25600',
        ];
    }

    /**
     * Mensajes de validación personalizados en español.
     */
    public function messages(): array
    {
        return [
            'nombre.required'                 => 'El nombre del documento es obligatorio.',
            'nombre.max'                      => 'El nombre del documento no puede superar los 200 caracteres.',
            'codigo.required'                 => 'El código del documento es obligatorio.',
            'codigo.unique'                   => 'Ya existe un documento registrado con este código. Verifique el código.',
            'numero_version.required'         => 'El número de versión inicial es obligatorio.',
            'proceso_id.required'             => 'Debe seleccionar el proceso al que pertenece el documento.',
            'proceso_id.exists'               => 'El proceso seleccionado no es válido.',
            'area_id.required'                => 'Debe seleccionar el área correspondiente.',
            'area_id.exists'                  => 'El área seleccionada no es válida.',
            'tipo_doc_id.required'            => 'Debe seleccionar el tipo de documento.',
            'tipo_doc_id.exists'              => 'El tipo de documento seleccionado no es válido.',
            'responsable_id.required'         => 'Debe asignar un responsable para el documento.',
            'responsable_id.exists'           => 'El usuario responsable seleccionado no es válido.',
            'fecha_elaboracion.required'      => 'La fecha de elaboración es obligatoria.',
            'fecha_proxima_revision.after_or_equal' => 'La fecha de próxima revisión debe ser igual o posterior a la fecha de elaboración.',
            'archivo.required'                => 'Debe adjuntar el archivo digital del documento.',
            'archivo.mimes'                   => 'Solo se aceptan archivos en formato PDF, DOCX o DOC.',
            'archivo.max'                     => 'El tamaño del archivo no puede superar los 25 MB.',
        ];
    }
}
