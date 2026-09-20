# Plan de pruebas — SenaWork

| Campo | Valor |
| --- | --- |
| Producto | SenaWork |
| Tipo de documento | Plan maestro de pruebas |
| Alcance | Web funcional y automatización E2E |
| Versión | 1.0 |
| Estado | Activo |
| Referencias | [Casos de prueba](./02-test-cases.md), [Defectos](./03-bug-reports.md) |

## 1. Objetivo

Definir la estrategia para evaluar que los flujos críticos de SenaWork funcionen de forma consistente para los roles Empleado y Empleador, que los datos se persistan correctamente y que los defectos queden documentados con evidencia reproducible.

## 2. Alcance

### Incluido

- Registro, validaciones de unicidad e inicio de sesión.
- Cierre de sesión, eliminación de cuenta y cambio de contraseña.
- Completar y actualizar perfil, documentos e imagen.
- Cambio de rol y control de acceso.
- Creación, consulta, búsqueda y administración de empleos.
- Postulaciones, estados y calificaciones.
- Persistencia y relaciones principales en MySQL.
- Regresión E2E de los flujos automatizados en `e2e/specs`.

### Fuera de alcance actual

- Pruebas de carga, estrés y endurance.
- Auditoría de seguridad especializada o pruebas de penetración.
- Compatibilidad completa con todos los navegadores y dispositivos.
- Validación de servicios externos no presentes en el repositorio.

## 3. Estrategia

| Nivel | Enfoque | Herramientas |
| --- | --- | --- |
| Funcional | Validación manual de reglas, mensajes, navegación y permisos | Navegador, MySQL Workbench/DBeaver |
| E2E | Flujos críticos de usuario de extremo a extremo | Playwright, TypeScript, Page Object Model |
| Datos | Migraciones, seeders, relaciones, persistencia y limpieza | Laravel Artisan, MySQL |
| Regresión | Ejecución en cada push y pull request hacia `main` | GitHub Actions |

Los escenarios deben ser independientes, usar datos controlados y verificar tanto el resultado visible como la persistencia cuando sea relevante. La suite completa reinicia y siembra la base de datos mediante `global-setup.ts`; las ejecuciones individuales omiten ese reinicio para permitir depuración.

## 4. Entorno de pruebas

- Ubuntu en GitHub Actions.
- PHP 8.2, Laravel 11 y Composer.
- Node.js 20, pnpm 10 y Chromium administrado por Playwright.
- MySQL 8.0 con base `senawork`.
- URL base: `http://127.0.0.1:8000`.
- Usuarios semilla: `test@gmail.com` y `test_empleador@gmail.com`.

Para reproducirlo localmente, sigue las instrucciones del [README principal](../README.md).

## 5. Datos y precondiciones

- La base se prepara con `php artisan migrate --seed`.
- Los correos y números de documento nuevos se generan dinámicamente en los fixtures.
- Los archivos de prueba se encuentran en `e2e/data`.
- No se deben usar credenciales reales, datos personales reales ni secretos en commits.

## 6. Criterios

### Entrada

- Dependencias instaladas sin errores.
- Variables de entorno configuradas.
- Migraciones y seeders ejecutados correctamente.
- Servidor disponible en la URL base.
- Datos y archivos de prueba accesibles.

### Salida

- Los casos críticos automatizados pasan o tienen un defecto conocido trazable.
- No existen errores bloqueantes sin documentar.
- Los defectos tienen pasos de reproducción y resultado esperado/obtenido.
- El reporte HTML de Playwright se genera en ejecuciones E2E.

## 7. Riesgos y mitigaciones

| Riesgo | Impacto | Mitigación |
| --- | --- | --- |
| Datos compartidos entre escenarios | Resultados inestables | `migrate:fresh --seed` y datos dinámicos |
| Diferencias entre SQLite y MySQL | Falsos positivos | Usar MySQL como ambiente de referencia |
| Archivos de carga ausentes o inválidos | Casos incompletos | Mantener fixtures versionados en `e2e/data` |
| Defectos conocidos en la suite | Ruido en CI | Marcarlos explícitamente con `test.fail` y enlazar el bug |
| Cambios de UI sin actualizar Page Objects | Regresiones no detectadas | Revisar selectores y objetos en el mismo PR |

## 8. Entregables

- Esta estrategia.
- Matriz de casos de prueba.
- Reportes de defectos con evidencia.
- Código E2E, fixtures y Page Objects.
- Reporte HTML generado por Playwright en CI.

## 9. Trazabilidad

La matriz identifica qué escenarios están automatizados y los reportes de defectos relacionan cada fallo con sus casos afectados. Antes de cerrar una incidencia se debe ejecutar el caso original y una regresión del flujo relacionado.
