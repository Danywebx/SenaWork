# Reportes de defectos

**Producto:** SenaWork · **Ambiente de referencia:** local/CI, MySQL 8.0, Chromium · **Convención:** severidad = impacto, prioridad = urgencia de corrección

## Resumen

| Estado | Cantidad |
| --- | ---: |
| Abiertos | 7 |
| Cerrados | 0 |
| Total documentado | 7 |

## BUG-001 — No se muestran empleos activos

- **Severidad / prioridad:** Alta / Alta
- **Módulo:** Búsqueda de empleos
- **Rol:** Empleado
- **Precondiciones:** Sesión activa y al menos una oferta activa.
- **Pasos:** Iniciar sesión como Empleado y abrir `/empleado`.
- **Esperado:** Se listan todas las ofertas activas.
- **Obtenido:** La lista aparece vacía.
- **Trazabilidad:** TC-18
- **Evidencia:** [captura](./screenshots/Screenshot%20From%202026-08-25%2001-05-07.png)
- **Estado:** Abierto

## BUG-002 — El filtro por categoría no devuelve resultados

- **Severidad / prioridad:** Alta / Alta
- **Módulo:** Búsqueda de empleos
- **Rol:** Empleado
- **Precondiciones:** Existe una oferta activa de la categoría seleccionada.
- **Pasos:** Abrir `/empleado`, seleccionar una categoría y buscar.
- **Esperado:** Se muestran las ofertas activas de esa categoría.
- **Obtenido:** No se muestran resultados.
- **Trazabilidad:** TC-18
- **Evidencia:** [captura](./screenshots/Screenshot%20From%202026-08-25%2002-10-37.png)
- **Estado:** Abierto

## BUG-003 — La búsqueda por nombre no devuelve resultados

- **Severidad / prioridad:** Alta / Alta
- **Módulo:** Búsqueda por palabra clave
- **Rol:** Empleado
- **Precondiciones:** Existe una oferta activa cuyo nombre contiene la palabra buscada.
- **Pasos:** Abrir `/empleado`, escribir el nombre o parte del nombre y buscar.
- **Esperado:** Se muestran las ofertas cuyo nombre coincide.
- **Obtenido:** La búsqueda por nombre no devuelve resultados; la descripción puede comportarse de forma distinta.
- **Trazabilidad:** TC-18
- **Evidencia:** [captura](./screenshots/Screenshot%20From%202026-08-25%2002-09-23.png)
- **Estado:** Abierto

## BUG-004 — La imagen de perfil no se visualiza después de actualizarla

- **Severidad / prioridad:** Media / Media
- **Módulo:** Perfil
- **Roles:** Empleado y Empleador
- **Precondiciones:** Sesión activa y una imagen válida.
- **Pasos:** Abrir `/perfil`, editar perfil, cargar una imagen y guardar.
- **Esperado:** La imagen se muestra en la navegación y en la tarjeta del perfil.
- **Obtenido:** La actualización informa éxito, pero la imagen no se visualiza.
- **Trazabilidad:** TC-12; `e2e/specs/profile.spec.ts` lo marca como `test.fail`.
- **Evidencia:** [captura](./screenshots/Screenshot%20From%202026-08-25%2002-30-40.png)
- **Estado:** Abierto

## BUG-005 — La imagen de una oferta no se visualiza

- **Severidad / prioridad:** Media / Media
- **Módulo:** Publicación de empleos
- **Rol:** Empleador
- **Precondiciones:** Sesión activa, perfil completo y una imagen válida.
- **Pasos:** Crear una oferta desde `/crear_empleo` con imagen y abrirla desde `/empleos`.
- **Esperado:** La oferta muestra la imagen cargada.
- **Obtenido:** La oferta se crea, pero la imagen no se muestra.
- **Trazabilidad:** TC-16
- **Evidencia:** [captura](./screenshots/Screenshot%20From%202026-08-25%2002-40-31.png)
- **Estado:** Abierto

## BUG-006 — No se muestra la administración de una oferta

- **Severidad / prioridad:** Alta / Alta
- **Módulo:** Administración de empleos
- **Rol:** Empleador
- **Precondiciones:** El usuario tiene una oferta activa propia.
- **Pasos:** Abrir `/empleos`, seleccionar una oferta y consultar su detalle.
- **Esperado:** Se muestra el botón `Administrar` con acciones sobre la oferta.
- **Obtenido:** El botón no aparece.
- **Trazabilidad:** TC-17
- **Evidencia:** [captura](./screenshots/Screenshot%20From%202026-08-25%2002-40-31.png)
- **Estado:** Abierto

## BUG-007 — Cambiar contraseña no cierra la sesión

- **Severidad / prioridad:** Alta / Alta
- **Módulo:** Seguridad de cuenta
- **Rol:** Usuario autenticado
- **Precondiciones:** Sesión activa y contraseña actual válida.
- **Pasos:** Abrir `/perfil`, cambiar la contraseña y enviar el formulario.
- **Esperado:** Se actualiza la contraseña, se invalida la sesión y se redirige a `/inicio`.
- **Obtenido:** La operación se ejecuta, pero la sesión no se cierra como se espera.
- **Trazabilidad:** TC-09; `e2e/specs/profile.spec.ts` lo marca como `test.fail`.
- **Estado:** Abierto

## Criterio de cierre

Un defecto se considera cerrado cuando existe una corrección integrada, el caso original pasa, se ejecuta una regresión del módulo afectado y la evidencia de esta matriz se actualiza.
