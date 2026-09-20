# Documentación de aseguramiento de calidad

Esta carpeta reúne la evidencia QA de SenaWork y está pensada para facilitar la revisión del proyecto por parte de equipos técnicos, reclutadores y colaboradores.

## Documentos

| Documento | Propósito |
| --- | --- |
| [01-test-plan.md](./01-test-plan.md) | Alcance, estrategia, ambientes, riesgos, entradas y criterios de salida. |
| [02-test-cases.md](./02-test-cases.md) | Casos funcionales, resultado esperado, cobertura automatizada y estado. |
| [03-bug-reports.md](./03-bug-reports.md) | Defectos reproducibles con severidad, prioridad, evidencia y trazabilidad. |

## Convenciones

- `PASS`: el comportamiento cumplió el resultado esperado en la última ejecución registrada.
- `FAIL`: el comportamiento no cumplió el resultado esperado.
- `KNOWN BUG`: el caso está automatizado, pero se conserva como fallo esperado mediante `test.fail` hasta corregir el defecto.
- Los estados son una fotografía de la última ejecución documentada, no una garantía permanente.
- Los datos sensibles no deben almacenarse en estos documentos. Utiliza datos de prueba y variables de entorno.

## Cómo actualizar la evidencia

1. Ejecuta la suite desde la raíz con `pnpm exec playwright test`.
2. Registra fecha, entorno y resultado en la matriz de casos.
3. Si aparece un comportamiento inesperado, crea o actualiza un reporte en `03-bug-reports.md` con pasos mínimos reproducibles.
4. Enlaza el caso de prueba con el defecto y actualiza el estado cuando exista una corrección verificada.
