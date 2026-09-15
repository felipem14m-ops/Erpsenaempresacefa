# Trazabilidad de Notificaciones SGC

Este documento explica de manera detallada cómo fluye la información en la nueva implementación de notificaciones orientada a objetos (POO) para el módulo SGC.

---

## 1. El Origen: Controlador de Solicitudes
Todo comienza cuando un usuario realiza una acción clave en el sistema a través del controlador `SolicitudController`. 
En lugar de programar la lógica de enviar correos o crear alertas directamente aquí (lo cual ensucia el código), aplicamos el patrón **Observador**.

- **Al Radicar (`store`)**: Cuando el Líder de Área radica una nueva solicitud, justo después de guardarla en la base de datos, el controlador *grita* al sistema: `"¡Ey, se acaba de radicar una solicitud!"` disparando el evento:
  ```php
  event(new SolicitudRadicada($sol));
  ```
- **Al Responder (`aprobar` o `rechazar`)**: Cuando el Responsable de Calidad da un dictamen, el controlador *grita*: `"¡Ey, la solicitud fue respondida!"`
  ```php
  event(new SolicitudRespondida($solicitud));
  ```

---

## 2. Los Mensajeros: Clases de Eventos
Los Eventos son simplemente clases "mensajeras" cuyo único propósito es transportar la información (en este caso, el objeto `$solicitud`) desde el Controlador hacia quienes estén escuchando.

- **`Modules/SGC/Events/SolicitudRadicada.php`**
- **`Modules/SGC/Events/SolicitudRespondida.php`**

Estos archivos no contienen lógica, solo cargan el paquete (`$solicitud`) en su interior.

---

## 3. Los Receptores: Listeners (Oyentes)
En el archivo `EventServiceProvider.php` (dentro de la carpeta `Providers` de tu módulo), conectamos cada Evento con su respectivo Listener (Oyente). 
Los Listeners están esperando en silencio, y cuando escuchan que un evento específico ocurrió, se activan.

#### A. `NotificarResponsableCalidad`
- **Escucha a:** `SolicitudRadicada`
- **¿Qué hace?**: Toma el paquete (`$solicitud`). Luego, busca en la base de datos a todos los usuarios que tengan el rol de Responsable de Calidad (rol con slug `resp_calidad`). 
- Por cada Responsable encontrado, inserta un registro en la tabla `notificaciones` diciendo: *"Nueva Solicitud Radicada"*.

#### B. `NotificarLiderArea`
- **Escucha a:** `SolicitudRespondida`
- **¿Qué hace?**: Toma el paquete, revisa quién fue el creador de la solicitud (`$solicitud->solicitado_por`) e inserta una alerta en la tabla `notificaciones` para ese usuario específico diciendo: *"Tu solicitud ha sido procesada con estado X"*.

---

## 4. La Distribución Visual: View Composer
Ahora que tenemos notificaciones guardadas en la base de datos, ¿cómo las mostramos en la barra superior de navegación sin tener que modificar cada función del controlador? Usando un **View Composer**.

- **`Modules/SGC/Http/ViewComposers/NotificacionesComposer.php`**: Esta clase se ejecuta automáticamente cada vez que se va a renderizar una vista de layout.
- Consulta en la base de datos: *"Tráeme las notificaciones del usuario que tiene la sesión iniciada (`Auth::id()`) y que NO hayan sido leídas (`leida = false`)"*.
- Inyecta el resultado en la variable `$notificacionesSinLeer`.

El **`SGCServiceProvider.php`** es quien le dice a Laravel: *"Oye, cada vez que cargues la vista `NavbarAdmin.blade.php`, ejecuta el `NotificacionesComposer` y pásale esa información"*.

---

## 5. El Destino Final: La Interfaz de Usuario (UI)
Finalmente, en el archivo **`NavbarAdmin.blade.php`**, la variable inyectada `$notificacionesSinLeer` ya está disponible por arte de magia.

- **El Contador (Badge)**: Comprobamos cuántas hay con `{{ $notificacionesSinLeer->count() }}`. Si hay más de 0, mostramos la bolita amarilla con el número sobre la campanita.
- **La Lista (Dropdown)**: Usando un ciclo `@foreach($notificacionesSinLeer as $notificacion)`, iteramos cada registro y mostramos su título y su mensaje dentro de un menú desplegable nativo de Bootstrap.
- **El Tiempo**: Usamos `diffForHumans()` de Carbon para mostrar fechas relativas y amigables como *"hace 2 horas"* o *"hace 5 minutos"*.

## Resumen Gráfico del Flujo
`Controlador` ➜ dispara ➜ `Evento` ➜ transporta a ➜ `Listener` ➜ guarda en BD ➜ `ViewComposer` ➜ inyecta a ➜ `NavbarAdmin.blade.php`
