<?php

namespace Modules\SGC\Traits;

use Modules\SGC\Models\Bitacora;

trait RegistraBitacora
{
    /**
     * Registra un evento de auditoría en la bitácora del módulo SGC.
     *
     * @param string $accion Nombre de la acción (ej: 'crear_proceso', 'editar_area')
     * @param string $entidad Nombre de la tabla o entidad (ej: 'procesos', 'areas', 'tipos_documento')
     * @param int|null $entidadId ID del registro afectado
     * @param array|null $datosAnteriores Estado previo del registro
     * @param array|null $datosNuevos Estado actual/nuevo del registro
     * @param string $resultado Resultado de la operación ('exitoso' o 'fallido')
     */
    public function registrar(
        string $accion,
        string $entidad,
        ?int $entidadId = null,
        ?array $datosAnteriores = null,
        ?array $datosNuevos = null,
        string $resultado = 'exitoso'
    ): void {
        $descripcion = match ($accion) {
            'crear_proceso'                 => 'Creación de nuevo proceso en el SGC.',
            'editar_proceso'                => 'Modificación de datos del proceso.',
            'cambiar_estado_proceso'        => 'Cambio de estado activo/inactivo del proceso.',
            'eliminar_proceso'              => 'Eliminación de proceso del SGC.',
            'crear_area'                    => 'Creación de nueva área en el SGC.',
            'editar_area'                   => 'Modificación de datos del área.',
            'cambiar_estado_area'           => 'Cambio de estado activo/inactivo del área.',
            'eliminar_area'                 => 'Eliminación de área del SGC.',
            'crear_tipo_documento'          => 'Creación de nuevo tipo documental.',
            'editar_tipo_documento'         => 'Modificación de datos del tipo documental.',
            'cambiar_estado_tipo_documento' => 'Cambio de estado activo/inactivo del tipo documental.',
            'eliminar_tipo_documento'       => 'Eliminación de tipo documental del SGC.',
            default                         => "Operación '{$accion}' ejecutada sobre la entidad '{$entidad}'.",
        };

        Bitacora::registrar(
            $accion,
            $descripcion,
            $entidad,
            $entidadId,
            $datosAnteriores,
            $datosNuevos,
            $resultado
        );
    }
}
