@extends('sgc::layouts.master')

@section('title', 'SGC • Registrar Documento Oficial')

@section('content')
<div class="container-fluid px-0 py-2">

    <!-- ======= HEADER TITLE & SUBTITLE ======= -->
    <div class="mb-4">
        <h2 class="fw-bold text-dark mb-1" style="font-size: 26px; letter-spacing: -0.3px;">Registrar Documento Oficial</h2>
        <p class="text-muted small mb-0" style="font-size: 13.5px;">Ingrese la información para la publicación de un nuevo documento en el listado maestro.</p>
    </div>

    <!-- ======= FLASH ALERTS ======= -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-4 border shadow-sm p-3 mb-4 bg-white d-flex align-items-center gap-3" role="alert">
            <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 38px; height: 38px; background-color: #eaf8ea; color: #39A900;">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-check-circle-fill" viewBox="0 0 16 16">
                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                </svg>
            </div>
            <div class="flex-grow-1">
                <strong class="d-block text-dark" style="font-size: 13.5px;">Operación exitosa</strong>
                <span class="text-secondary small">{{ session('success') }}</span>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show rounded-4 border shadow-sm p-3 mb-4 bg-white d-flex align-items-center gap-3" role="alert">
            <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 38px; height: 38px; background-color: #ffebee; color: #ef4444;">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-exclamation-triangle-fill" viewBox="0 0 16 16">
                    <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5m.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
                </svg>
            </div>
            <div class="flex-grow-1">
                <strong class="d-block text-dark" style="font-size: 13.5px;">Error al registrar</strong>
                <span class="text-secondary small">{{ session('error') }}</span>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-warning alert-dismissible fade show rounded-4 border shadow-sm p-3 mb-4 bg-white" role="alert">
            <div class="d-flex align-items-center gap-2 mb-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="#f59e0b" class="bi bi-exclamation-circle-fill" viewBox="0 0 16 16">
                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4m.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2"/>
                </svg>
                <strong class="text-dark" style="font-size: 13.5px;">Por favor corrija los siguientes campos:</strong>
            </div>
            <ul class="mb-0 text-secondary small ps-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- ======= MAIN FORM WRAPPER ======= -->
    <form action="{{ route('sgc.documentos.store') }}" method="POST" enctype="multipart/form-data" id="formRegistrarDocumento">
        @csrf

        <div class="row g-4 align-items-stretch">
            
            <!-- ======= LEFT COLUMN: METADATA FORM ======= -->
            <div class="col-12 col-lg-7 col-xl-8">
                <div class="card border rounded-4 bg-white shadow-sm p-4 p-md-4 h-100 d-flex flex-column justify-content-between">
                    
                    <div>
                        <!-- Campo 1: Nombre del Documento -->
                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-secondary mb-1" style="font-size: 13px;">
                                Nombre del Documento <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   name="nombre" 
                                   class="form-control rounded-3 py-2 px-3 bg-white border" 
                                   style="font-size: 13.5px; border-color: #e2e8f0;"
                                   placeholder="Ej: Procedimiento para Compras y Adquisiciones" 
                                   value="{{ old('nombre') }}" 
                                   required>
                        </div>

                        <!-- Fila 1: Código de Documento + Versión Vigente -->
                        <div class="row g-3 mb-3">
                            <div class="col-12 col-md-6">
                                <label class="form-label small fw-semibold text-secondary mb-1" style="font-size: 13px;">
                                    Código de Documento <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       name="codigo" 
                                       class="form-control rounded-3 py-2 px-3 bg-white border text-uppercase font-monospace" 
                                       style="font-size: 13.5px; border-color: #e2e8f0;"
                                       placeholder="PR-CA-001" 
                                       value="{{ old('codigo') }}" 
                                       required>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label small fw-semibold text-secondary mb-1" style="font-size: 13px;">
                                    Versión Vigente <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       name="numero_version" 
                                       class="form-control rounded-3 py-2 px-3 bg-white border" 
                                       style="font-size: 13.5px; border-color: #e2e8f0;"
                                       placeholder="1.0" 
                                       value="{{ old('numero_version', '1.0') }}" 
                                       required>
                            </div>
                        </div>

                        <!-- Fila 2: Proceso Asociado + Área Solicitante -->
                        <div class="row g-3 mb-3">
                            <div class="col-12 col-md-6">
                                <label class="form-label small fw-semibold text-secondary mb-1" style="font-size: 13px;">
                                    Proceso Asociado <span class="text-danger">*</span>
                                </label>
                                <select name="proceso_id" id="selectProceso" class="form-select rounded-3 py-2 px-3 bg-white border" style="font-size: 13.5px; border-color: #e2e8f0;" required>
                                    <option value="">Seleccione un proceso...</option>
                                    @foreach($procesos as $proc)
                                        <option value="{{ $proc->id }}" {{ old('proceso_id') == $proc->id ? 'selected' : '' }}>
                                            {{ $proc->nombre }} ({{ $proc->codigo }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label small fw-semibold text-secondary mb-1" style="font-size: 13px;">
                                    Área Solicitante <span class="text-danger">*</span>
                                </label>
                                <select name="area_id" id="selectArea" class="form-select rounded-3 py-2 px-3 bg-white border" style="font-size: 13.5px; border-color: #e2e8f0;" required>
                                    <option value="">Seleccione un área...</option>
                                    @foreach($areas as $area)
                                        <option value="{{ $area->id }}" data-proceso-id="{{ $area->proceso_id }}" {{ old('area_id') == $area->id ? 'selected' : '' }}>
                                            {{ $area->nombre }} ({{ $area->codigo }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Fila 3: Tipo Documental + Responsable Asignado -->
                        <div class="row g-3 mb-3">
                            <div class="col-12 col-md-6">
                                <label class="form-label small fw-semibold text-secondary mb-1" style="font-size: 13px;">
                                    Tipo Documental <span class="text-danger">*</span>
                                </label>
                                <select name="tipo_doc_id" class="form-select rounded-3 py-2 px-3 bg-white border" style="font-size: 13.5px; border-color: #e2e8f0;" required>
                                    <option value="">Seleccione un tipo...</option>
                                    @foreach($tiposDoc as $tipo)
                                        <option value="{{ $tipo->id }}" {{ old('tipo_doc_id') == $tipo->id ? 'selected' : '' }}>
                                            {{ $tipo->nombre }} ({{ $tipo->codigo }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label small fw-semibold text-secondary mb-1" style="font-size: 13px;">
                                    Responsable Asignado <span class="text-danger">*</span>
                                </label>
                                <select name="responsable_id" class="form-select rounded-3 py-2 px-3 bg-white border" style="font-size: 13.5px; border-color: #e2e8f0;" required>
                                    <option value="">Seleccione responsable...</option>
                                    @foreach($responsables as $resp)
                                        <option value="{{ $resp->id }}" {{ old('responsable_id') == $resp->id ? 'selected' : '' }}>
                                            {{ $resp->nombre_completo ?? $resp->nombre_usuario }} ({{ $resp->rol->nombre ?? 'Resp. Calidad' }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Fila 4: Fecha de Elaboración + Fecha Próxima Revisión -->
                        <div class="row g-3 mb-4">
                            <div class="col-12 col-md-6">
                                <label class="form-label small fw-semibold text-secondary mb-1" style="font-size: 13px;">
                                    Fecha de Elaboración <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted ps-3" style="border-color: #e2e8f0;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor" class="bi bi-calendar3" viewBox="0 0 16 16">
                                            <path d="M14 0H2a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2M1 3.857C1 3.384 1.448 3 2 3h12c.552 0 1 .384 1 .857v10.286c0 .473-.448.857-1 .857H2c-.552 0-1-.384-1-.857z"/>
                                            <path d="M6.5 7a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2m-9 3a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2m-9 3a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2"/>
                                        </svg>
                                    </span>
                                    <input type="date" 
                                           name="fecha_elaboracion" 
                                           class="form-control rounded-end-3 py-2 bg-white border-start-0" 
                                           style="font-size: 13.5px; border-color: #e2e8f0;"
                                           value="{{ old('fecha_elaboracion', date('Y-m-d')) }}" 
                                           required>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label small fw-semibold text-secondary mb-1" style="font-size: 13px;">
                                    Fecha Próxima Revisión <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted ps-3" style="border-color: #e2e8f0;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor" class="bi bi-calendar3" viewBox="0 0 16 16">
                                            <path d="M14 0H2a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2M1 3.857C1 3.384 1.448 3 2 3h12c.552 0 1 .384 1 .857v10.286c0 .473-.448.857-1 .857H2c-.552 0-1-.384-1-.857z"/>
                                            <path d="M6.5 7a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2m-9 3a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2m-9 3a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2"/>
                                        </svg>
                                    </span>
                                    <input type="date" 
                                           name="fecha_proxima_revision" 
                                           class="form-control rounded-end-3 py-2 bg-white border-start-0" 
                                           style="font-size: 13.5px; border-color: #e2e8f0;"
                                           value="{{ old('fecha_proxima_revision') }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Botones de Acción Inferiores -->
                    <div class="d-flex justify-content-end align-items-center gap-2 pt-3 border-top mt-4">
                        <a href="{{ route('sgc.documentos.index') }}" class="btn btn-outline-secondary rounded-3 px-4 py-2 fw-semibold" style="font-size: 13.5px;">
                            Cancelar
                        </a>
                        <button type="submit" class="btn text-white rounded-3 px-4 py-2 fw-bold shadow-sm" style="background-color: #39A900; border: none; font-size: 13.5px;">
                            Registrar Documento
                        </button>
                    </div>

                </div>
            </div>

            <!-- ======= RIGHT COLUMN: ARCHIVO DEL DOCUMENTO & SEGURIDAD ======= -->
            <div class="col-12 col-lg-5 col-xl-4">
                <div class="card border rounded-4 bg-white shadow-sm p-4 h-100 d-flex flex-column justify-content-between">
                    
                    <div>
                        <!-- Título de la tarjeta -->
                        <h5 class="fw-bold text-dark mb-3" style="font-size: 16px;">Archivo del Documento</h5>

                        <!-- Drag & Drop Area con Borde Verde Punteado -->
                        <div id="dropzoneDocumento" 
                             class="dropzone-area p-4 rounded-4 text-center d-flex flex-column align-items-center justify-content-center position-relative" 
                             style="border: 2px dashed #86efac; background-color: #f8fafc; min-height: 220px; cursor: pointer; transition: all 0.25s ease;">
                            
                            <!-- Input File Real Oculto -->
                            <input type="file" name="archivo" id="fileDocumento" class="d-none" accept=".pdf,.docx,.doc" required>

                            <!-- Estado 1: Inicial / Vacío -->
                            <div id="dropzoneContentIdle" class="d-flex flex-column align-items-center justify-content-center">
                                <div class="rounded-circle d-flex align-items-center justify-content-center mb-3" style="width: 48px; height: 48px; background-color: transparent;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="#22c55e" class="bi bi-cloud-arrow-up" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M7.646 5.146a.5.5 0 0 1 .708 0l2 2a.5.5 0 0 1-.708.708L8.5 6.707V10.5a.5.5 0 0 1-1 0V6.707L6.354 7.854a.5.5 0 1 1-.708-.708z"/>
                                        <path d="M4.406 3.342A5.53 5.53 0 0 1 8 2c2.69 0 4.923 2 5.166 4.579C14.758 6.804 16 8.137 16 9.773 16 11.569 14.502 13 12.687 13H3.781C1.708 13 0 11.366 0 9.318c0-1.763 1.266-3.223 2.942-3.593.143-.863.698-1.723 1.464-2.383m.653.757c-.757.653-1.153 1.44-1.153 2.056v.448l-.445.049C2.064 6.805 1 7.952 1 9.318 1 10.785 2.23 12 3.781 12h8.906C13.98 12 15 10.988 15 9.773c0-1.216-1.02-2.228-2.313-2.228h-.5v-.5C12.188 4.825 10.328 3 8 3a4.53 4.53 0 0 0-2.941 1.1z"/>
                                    </svg>
                                </div>
                                <div class="fw-bold text-dark mb-1" style="font-size: 15px;">Arrastre el documento aquí</div>
                                <div class="text-muted small mb-2" style="font-size: 13px;">o haga clic para seleccionar</div>
                                <span class="text-muted" style="font-size: 11.5px;">Formatos soportados: PDF o DOCX (Máx. 15MB)</span>
                            </div>

                            <!-- Estado 2: Archivo Seleccionado Preview -->
                            <div id="dropzoneContentSelected" class="d-none flex-column align-items-center justify-content-center w-100 py-2">
                                <div class="rounded-circle d-flex align-items-center justify-content-center mb-2" style="width: 48px; height: 48px; background-color: #eaf8ea; color: #39A900;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-file-earmark-check-fill" viewBox="0 0 16 16">
                                        <path d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0M9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1m1.354 4.354-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 9.793l2.646-2.647a.5.5 0 0 1 .708.708"/>
                                    </svg>
                                </div>
                                <strong id="previewFileName" class="text-dark d-block text-truncate w-100 px-3" style="font-size: 13.5px;">archivo.pdf</strong>
                                <span id="previewFileSize" class="text-muted small d-block mb-3" style="font-size: 11.5px;">0 KB</span>
                                <button type="button" id="btnRemoveFile" class="btn btn-sm btn-outline-danger rounded-2 px-3 py-1" style="font-size: 12px;">
                                    Cambiar archivo
                                </button>
                            </div>

                        </div>
                    </div>

                    <!-- Callout de Seguridad: Documentos Seguros -->
                    <div class="rounded-3 p-3 mt-4 d-flex align-items-start gap-2" style="background-color: #f0fdf4; border: 1px solid #dcfce7;">
                        <div class="flex-shrink-0 text-success pt-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#16a34a" class="bi bi-lock-fill" viewBox="0 0 16 16">
                                <path d="M8 1a2 2 0 0 0-2 2v4H5a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2m0 1a1 1 0 0 1 1 1v4H7V3a1 1 0 0 1 1-1"/>
                            </svg>
                        </div>
                        <div>
                            <strong class="d-block" style="color: #15803d; font-size: 13px;">Documentos Seguros</strong>
                            <p class="mb-0 text-secondary" style="font-size: 11.5px; line-height: 1.45;">
                                El sistema restringe la descarga pública de borradores sin su debida firma digital y marca de agua oficial de SENA.
                            </p>
                        </div>
                    </div>

                </div>
            </div>

        </div>

    </form>

</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        
        // 1. Filtrado dinámico de Áreas según el Proceso seleccionado
        const selectProceso = document.getElementById('selectProceso');
        const selectArea = document.getElementById('selectArea');

        if (selectProceso && selectArea) {
            const allAreaOptions = Array.from(selectArea.querySelectorAll('option:not([value=""])'));

            selectProceso.addEventListener('change', function () {
                const procId = this.value;
                const currentSelectedArea = selectArea.value;

                // Reset options
                selectArea.innerHTML = '<option value="">Seleccione un área...</option>';

                allAreaOptions.forEach(opt => {
                    const optProcId = opt.getAttribute('data-proceso-id');
                    if (!procId || optProcId === procId) {
                        selectArea.appendChild(opt.cloneNode(true));
                    }
                });

                // Restaurar valor si es compatible
                if (currentSelectedArea) {
                    const match = selectArea.querySelector(`option[value="${currentSelectedArea}"]`);
                    if (match) match.selected = true;
                }
            });
        }

        // 2. Drag and Drop & File Selection Interaction
        const dropzone = document.getElementById('dropzoneDocumento');
        const fileInput = document.getElementById('fileDocumento');
        const idleContent = document.getElementById('dropzoneContentIdle');
        const selectedContent = document.getElementById('dropzoneContentSelected');
        const previewName = document.getElementById('previewFileName');
        const previewSize = document.getElementById('previewFileSize');
        const btnRemove = document.getElementById('btnRemoveFile');

        if (dropzone && fileInput) {
            
            // Clic en la dropzone para abrir selector
            dropzone.addEventListener('click', function (e) {
                if (e.target !== btnRemove) {
                    fileInput.click();
                }
            });

            // Arrastrar archivo sobre el área
            ['dragenter', 'dragover'].forEach(eventName => {
                dropzone.addEventListener(eventName, function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    dropzone.style.borderColor = '#22c55e';
                    dropzone.style.backgroundColor = '#f0fdf4';
                }, false);
            });

            ['dragleave', 'drop'].forEach(eventName => {
                dropzone.addEventListener(eventName, function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    dropzone.style.borderColor = '#86efac';
                    dropzone.style.backgroundColor = '#f8fafc';
                }, false);
            });

            // Soltar archivo
            dropzone.addEventListener('drop', function (e) {
                const dt = e.dataTransfer;
                const files = dt.files;

                if (files.length > 0) {
                    fileInput.files = files;
                    updateFilePreview(files[0]);
                }
            });

            // Cambio en input file tradicional
            fileInput.addEventListener('change', function () {
                if (this.files && this.files.length > 0) {
                    updateFilePreview(this.files[0]);
                }
            });

            // Botón cambiar/remover
            if (btnRemove) {
                btnRemove.addEventListener('click', function (e) {
                    e.stopPropagation();
                    fileInput.value = '';
                    idleContent.classList.remove('d-none');
                    idleContent.classList.add('d-flex');
                    selectedContent.classList.add('d-none');
                    selectedContent.classList.remove('d-flex');
                    fileInput.click();
                });
            }

            function updateFilePreview(file) {
                if (!file) return;

                previewName.textContent = file.name;
                const sizeKb = (file.size / 1024).toFixed(1);
                const sizeMb = (file.size / (1024 * 1024)).toFixed(2);
                previewSize.textContent = file.size > 1024 * 1024 ? `${sizeMb} MB` : `${sizeKb} KB`;

                idleContent.classList.add('d-none');
                idleContent.classList.remove('d-flex');
                selectedContent.classList.remove('d-none');
                selectedContent.classList.add('d-flex');
            }
        }
    });
</script>
@endpush
