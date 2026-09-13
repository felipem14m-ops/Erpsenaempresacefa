<?php

namespace Modules\SICA\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\SICA\Entities\Bloque;
use Modules\SICA\Entities\App;

class BloqueAppSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 1. Crear Bloque: Procesos Estratégicos
        $estrategico = Bloque::updateOrCreate(['slug' => 'estrategicos'], [
            'name' => 'Procesos Estratégicos',
            'description' => 'Direccionamiento institucional, planeación y evaluación de indicadores globales.',
            'icon' => 'fas fa-chess-king',
            'color' => '#39A900',
            'order_index' => 1
        ]);

        // 2. Crear Bloque: Procesos Misionales
        $misional = Bloque::updateOrCreate(['slug' => 'misionales'], [
            'name' => 'Procesos Misionales',
            'description' => 'Operación central de SENA Empresa: gestión agropecuaria, unidades productivas y turnos formativos.',
            'icon' => 'fas fa-bullseye',
            'color' => '#00324D',
            'order_index' => 2
        ]);

        // 3. Crear Bloque: Procesos de Apoyo
        $apoyo = Bloque::updateOrCreate(['slug' => 'apoyos'], [
            'name' => 'Procesos de Apoyo',
            'description' => 'Seguridad laboral, gestión documental centralizada y sistema de gestión de calidad.',
            'icon' => 'fas fa-handshake',
            'color' => '#e65100',
            'order_index' => 3
        ]);

        // Eliminar aplicaciones anteriores que ya no forman parte de la arquitectura del ERP
        $validAppNames = ['SIGE', 'Control ECP', 'Apicola', 'SISIG', 'SST', 'SISGEDI', 'SGC'];
        App::whereNotIn('name', array_merge($validAppNames, ['SICA']))->delete();

        // --- APLICATIVOS / SUBMÓDULOS ---

        // 1. Procesos Estratégicos
        App::updateOrCreate(['name' => 'SIGE'], [
            'bloque_id' => $estrategico->id,
            'url' => '/direccion',
            'color' => '#39A900',
            'icon' => 'fas fa-chart-line',
            'description' => 'Sistema Integrado de Gestión Empresarial. Direccionamiento estratégico, planeación institucional, formulación de metas y toma de decisiones.',
            'description_english' => 'Integrated Enterprise Management System. Strategic planning, institutional goals and executive decision making.'
        ]);

        // 2. Procesos Misionales
        App::updateOrCreate(['name' => 'Control ECP'], [
            'bloque_id' => $misional->id,
            'url' => '/control-ecp',
            'color' => '#00324D',
            'icon' => 'fas fa-user-graduate',
            'description' => 'Control de Etapa Productiva. Administración y seguimiento del desempeño de aprendices en turnos productivos y unidades operativas.',
            'description_english' => 'Productive Stage Control. Management and tracking of apprentices in operational shifts.'
        ]);

        App::updateOrCreate(['name' => 'Apicola'], [
            'bloque_id' => $misional->id,
            'url' => '/apicola',
            'color' => '#f57c00',
            'icon' => 'fas fa-archive',
            'description' => 'Gestión y control integral de la unidad apícola, monitoreo de colmenas, inventario técnico, producción de miel y derivados.',
            'description_english' => 'Comprehensive management and control of the beekeeping unit, hive monitoring, honey production and derivatives.'
        ]);

        App::updateOrCreate(['name' => 'SISIG'], [
            'bloque_id' => $misional->id,
            'url' => '/sisig',
            'color' => '#0288d1',
            'icon' => 'fas fa-tractor',
            'description' => 'Sistema Integrado de Información Ganadera y Granja. Control zootécnico, pesajes, sanidad animal y trazabilidad pecuaria.',
            'description_english' => 'Integrated Livestock and Farm Information System. Zootechnical control, weighing, animal health and livestock traceability.'
        ]);

        // 3. Procesos de Apoyo
        App::updateOrCreate(['name' => 'SST'], [
            'bloque_id' => $apoyo->id,
            'url' => '/sst',
            'color' => '#d32f2f',
            'icon' => 'fas fa-shield-halved',
            'description' => 'Seguridad y Salud en el Trabajo. Prevención de riesgos laborales, inspecciones preventivas, dotación de EPP y protocolos de bioseguridad.',
            'description_english' => 'Occupational Health and Safety. Occupational risk prevention, preventive inspections and biosecurity protocols.'
        ]);

        App::updateOrCreate(['name' => 'SISGEDI'], [
            'bloque_id' => $apoyo->id,
            'url' => '/sisgedi',
            'color' => '#7b1fa2',
            'icon' => 'fas fa-folder-open',
            'description' => 'Sistema de Gestión Documental e Información. Radicación, trazabilidad de correspondencia institucional y archivo digital centralizado.',
            'description_english' => 'Document and Information Management System. Correspondence filing, traceability and centralized digital archive.'
        ]);

        App::updateOrCreate(['name' => 'SGC'], [
            'bloque_id' => $apoyo->id,
            'url' => '/sgc',
            'color' => '#39A900',
            'icon' => 'fas fa-file-shield',
            'description' => 'Sistema de Gestión de Calidad. Control documental, administración de versiones, formatos normalizados, auditorías y acciones de mejora.',
            'description_english' => 'Quality Management System. Document control, version management, standardized forms, audits and improvement actions.'
        ]);
    }
}
