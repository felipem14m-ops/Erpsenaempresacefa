<?php

namespace Modules\SGC\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Modules\SGC\Models\Proceso;
use Modules\SGC\Models\Area;
use Modules\SGC\Models\TipoDocumento;
use Modules\SGC\Models\Documento;
use Modules\SGC\Models\VersionDoc;
use Modules\SGC\Models\ListadoMaestro;
use Modules\SGC\Models\DocumentoFrecuente;
use Modules\SGC\Models\Bitacora;

class SGCSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Procesos
        $procesos = [
            ['id' => 1, 'codigo' => 'CAL', 'nombre' => 'Calidad', 'descripcion' => 'Gestión y control de calidad institucional', 'activo' => 1],
            ['id' => 2, 'codigo' => 'FOR', 'nombre' => 'Formación', 'descripcion' => 'Procesos de formación profesional integral', 'activo' => 1],
            ['id' => 3, 'codigo' => 'PRO', 'nombre' => 'Productivo', 'descripcion' => 'Unidades agropecuarias y productivas', 'activo' => 1],
            ['id' => 4, 'codigo' => 'ADM', 'nombre' => 'Administrativo', 'descripcion' => 'Gestión administrativa y talento humano', 'activo' => 1],
            ['id' => 5, 'codigo' => 'TIC', 'nombre' => 'Tecnología', 'descripcion' => 'Soporte e infraestructura tecnológica', 'activo' => 1],
            ['id' => 6, 'codigo' => 'DIR', 'nombre' => 'Dirección', 'descripcion' => 'Planeación estratégica y gobernanza', 'activo' => 1],
        ];

        foreach ($procesos as $proc) {
            Proceso::updateOrCreate(['id' => $proc['id']], $proc);
        }

        // 2. Áreas
        $areas = [
            ['id' => 1, 'codigo' => 'CC', 'nombre' => 'Calidad y Control', 'proceso_id' => 1, 'activo' => 1],
            ['id' => 2, 'codigo' => 'FP', 'nombre' => 'Formación Profesional', 'proceso_id' => 2, 'activo' => 1],
            ['id' => 3, 'codigo' => 'PEC', 'nombre' => 'Pecuaria', 'proceso_id' => 3, 'activo' => 1],
            ['id' => 4, 'codigo' => 'AGR', 'nombre' => 'Agrícola', 'proceso_id' => 3, 'activo' => 1],
            ['id' => 5, 'codigo' => 'AI', 'nombre' => 'Agroindustria', 'proceso_id' => 3, 'activo' => 1],
            ['id' => 6, 'codigo' => 'GH', 'nombre' => 'Gestión Humana y Bienestar', 'proceso_id' => 4, 'activo' => 1],
            ['id' => 7, 'codigo' => 'TI', 'nombre' => 'Sistemas e Infraestructura TIC', 'proceso_id' => 5, 'activo' => 1],
        ];

        foreach ($areas as $area) {
            Area::updateOrCreate(['id' => $area['id']], $area);
        }

        // 3. Tipos de Documento
        $tiposDoc = [
            ['id' => 1, 'codigo' => 'PR', 'nombre' => 'Procedimiento', 'descripcion' => 'Procedimientos operativos y metodológicos', 'activo' => 1],
            ['id' => 2, 'codigo' => 'FT', 'nombre' => 'Formato', 'descripcion' => 'Formatos de captura y registro de datos', 'activo' => 1],
            ['id' => 3, 'codigo' => 'GU', 'nombre' => 'Guía', 'descripcion' => 'Guías metodológicas y de prácticas', 'activo' => 1],
            ['id' => 4, 'codigo' => 'MA', 'nombre' => 'Manual', 'descripcion' => 'Manuales organizacionales y de procesos', 'activo' => 1],
            ['id' => 5, 'codigo' => 'IN', 'nombre' => 'Instructivo', 'descripcion' => 'Instructivos y protocolos paso a paso', 'activo' => 1],
            ['id' => 6, 'codigo' => 'PL', 'nombre' => 'Política / Plan', 'descripcion' => 'Políticas y planes de calidad', 'activo' => 1],
        ];

        foreach ($tiposDoc as $td) {
            TipoDocumento::updateOrCreate(['id' => $td['id']], $td);
        }

        // Obtener usuario administrador o primer usuario
        $adminUser = User::first();
        $adminId = $adminUser ? $adminUser->id : 1;

        // 4. Documentos de Muestra (Coincidentes con la Imagen 4)
        $documentos = [
            [
                'id' => 1,
                'codigo' => 'PR-CA-001',
                'nombre' => 'Procedimiento de Calidad General',
                'descripcion' => 'Directrices generales para la administración del SGC y custodia de procesos.',
                'proceso_id' => 1, // Calidad
                'area_id' => 1, // Calidad y Control
                'tipo_doc_id' => 1, // PR
                'responsable_id' => $adminId,
                'estado' => 'vigente',
                'fecha_elaboracion' => '2024-01-10',
                'fecha_proxima_revision' => '2025-01-15',
                'fecha_publicacion' => '2024-01-15 08:00:00',
                'creado_por' => $adminId,
                'version' => '3.0',
            ],
            [
                'id' => 2,
                'codigo' => 'FT-AG-012',
                'nombre' => 'Formato Registro de Aprendices',
                'descripcion' => 'Control de asistencia, firmas y registro de aprendices en ambientes de aprendizaje.',
                'proceso_id' => 2, // Formación
                'area_id' => 2, // Formación Profesional
                'tipo_doc_id' => 2, // FT
                'responsable_id' => $adminId,
                'estado' => 'vigente',
                'fecha_elaboracion' => '2024-01-18',
                'fecha_proxima_revision' => '2025-01-20',
                'fecha_publicacion' => '2024-01-20 09:30:00',
                'creado_por' => $adminId,
                'version' => '1.0',
            ],
            [
                'id' => 3,
                'codigo' => 'GU-PE-003',
                'nombre' => 'Guía de Prácticas de Campo',
                'descripcion' => 'Guía didáctica y técnica para actividades agropecuarias en unidades de producción.',
                'proceso_id' => 3, // Productivo
                'area_id' => 3, // Pecuaria
                'tipo_doc_id' => 3, // GU
                'responsable_id' => $adminId,
                'estado' => 'vigente',
                'fecha_elaboracion' => '2024-01-25',
                'fecha_proxima_revision' => '2025-02-02',
                'fecha_publicacion' => '2024-02-02 10:15:00',
                'creado_por' => $adminId,
                'version' => '2.0',
            ],
            [
                'id' => 4,
                'codigo' => 'MA-GH-002',
                'nombre' => 'Manual de Convivencia y Bienestar',
                'descripcion' => 'Normativa interna, directrices de bienestar institucional y convivencia en sede.',
                'proceso_id' => 4, // Administrativo
                'area_id' => 6, // Gestión Humana
                'tipo_doc_id' => 4, // MA
                'responsable_id' => $adminId,
                'estado' => 'vigente',
                'fecha_elaboracion' => '2023-12-10',
                'fecha_proxima_revision' => '2024-12-18',
                'fecha_publicacion' => '2023-12-18 14:00:00',
                'creado_por' => $adminId,
                'version' => '4.1',
            ],
            [
                'id' => 5,
                'codigo' => 'PR-TI-009',
                'nombre' => 'Procedimiento Soporte Tecnológico',
                'descripcion' => 'Protocolos de atención a incidencias, mantenimiento y mesas de ayuda TIC.',
                'proceso_id' => 5, // Tecnología
                'area_id' => 7, // Sistemas TIC
                'tipo_doc_id' => 1, // PR
                'responsable_id' => $adminId,
                'estado' => 'vigente',
                'fecha_elaboracion' => '2023-11-01',
                'fecha_proxima_revision' => '2024-11-05',
                'fecha_publicacion' => '2023-11-05 11:45:00',
                'creado_por' => $adminId,
                'version' => '1.2',
            ],
            [
                'id' => 6,
                'codigo' => 'FT-SI-024',
                'nombre' => 'Formato Auditoría Interna de Calidad',
                'descripcion' => 'Checklist y formato de hallazgos para auditorías internas de calidad.',
                'proceso_id' => 1, // Calidad
                'area_id' => 1, // Calidad y Control
                'tipo_doc_id' => 2, // FT
                'responsable_id' => $adminId,
                'estado' => 'vigente',
                'fecha_elaboracion' => '2024-01-20',
                'fecha_proxima_revision' => '2025-01-29',
                'fecha_publicacion' => '2024-01-29 16:20:00',
                'creado_por' => $adminId,
                'version' => '2.0',
            ],
        ];

        foreach ($documentos as $docData) {
            $versionNum = $docData['version'];
            unset($docData['version']);
            unset($docData['id']);

            $doc = Documento::updateOrCreate(['codigo' => $docData['codigo']], $docData);

            // Crear versión vigente
            $version = VersionDoc::updateOrCreate(
                ['documento_id' => $doc->id, 'numero_version' => $versionNum],
                [
                    'descripcion_cambio' => 'Aprobación y publicación oficial en Listado Maestro SGC.',
                    'archivo_ruta' => 'sgc/documentos/' . strtolower($doc->codigo) . '.pdf',
                    'archivo_nombre' => strtolower($doc->codigo) . '_' . str_replace('.', '_', $versionNum) . '.pdf',
                    'archivo_tamano_kb' => rand(250, 1200),
                    'archivo_formato' => 'pdf',
                    'estado' => 'vigente',
                    'publicado_por' => $adminId,
                    'fecha_publicacion' => $doc->fecha_publicacion,
                    'creado_por' => $adminId,
                    'creado_en' => $doc->fecha_publicacion ?? now(),
                ]
            );

            // Publicar en Listado Maestro
            ListadoMaestro::updateOrCreate(
                ['documento_id' => $doc->id],
                [
                    'version_id' => $version->id,
                    'proceso_id' => $doc->proceso_id,
                    'publicado_por' => $adminId,
                    'fecha_pub' => $doc->fecha_publicacion ?? now(),
                    'activo' => 1,
                ]
            );

            // Crear registro en documentos_frecuentes (para los 3 primeros)
            if (in_array($doc->id, [1, 2, 3])) {
                DocumentoFrecuente::updateOrCreate(
                    ['usuario_id' => $adminId, 'documento_id' => $doc->id],
                    [
                        'total_accesos' => 15 - ($doc->id * 3),
                        'ultimo_acceso' => now()->subHours($doc->id),
                    ]
                );
            }

            // Bitácora de trazabilidad
            Bitacora::updateOrCreate(
                [
                    'modulo' => 'Documentos',
                    'entidad' => 'documentos',
                    'entidad_id' => $doc->id,
                    'accion' => 'publicacion_documento',
                ],
                [
                    'usuario_id' => $adminId,
                    'descripcion' => "Publicación oficial del documento {$doc->codigo} (Versión {$versionNum}) en el Listado Maestro.",
                    'datos_nuevos' => ['codigo' => $doc->codigo, 'nombre' => $doc->nombre, 'version' => $versionNum, 'estado' => 'vigente'],
                    'ip_address' => '127.0.0.1',
                    'user_agent' => 'SENA-ERP-Seeder',
                    'resultado' => 'exitoso',
                    'registrado_en' => $doc->fecha_publicacion ?? now(),
                ]
            );
        }
    }
}
