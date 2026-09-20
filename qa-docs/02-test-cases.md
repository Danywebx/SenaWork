# Matriz de casos de prueba

**Producto:** SenaWork · **Versión de referencia:** 1.0 · **Estado:** evidencia de la última ejecución documentada

## Resumen de cobertura

| Indicador | Resultado |
| --- | ---: |
| Casos documentados | 18 |
| PASS | 13 |
| FAIL / defecto conocido | 5 |
| Automatizados directamente | 13 |
| No automatizados actualmente | 5 |

> `PASS` y `FAIL` describen la última evidencia registrada. Los casos marcados como `KNOWN BUG` se conservan en la suite para hacer visible la deuda de calidad.

| ID | Módulo | Escenario | Precondiciones | Resultado esperado | Automatización | Estado |
| --- | --- | --- | --- | --- | --- | --- |
| TC-01 | Autenticación | Registro válido | Usuario no registrado | Crea la cuenta e inicia sesión | `register.spec.ts` | PASS |
| TC-02 | Autenticación | Registro con correo duplicado | Correo existente | Muestra validación de correo único | `register.spec.ts` | PASS |
| TC-03 | Autenticación | Registro con documento duplicado | Documento existente | Muestra validación de documento único | `register.spec.ts` | PASS |
| TC-04 | Autenticación | Registro incompleto | Formulario vacío | Impide envío y muestra validaciones | `register.spec.ts` | PASS |
| TC-05 | Autenticación | Inicio de sesión válido | Usuario semilla activo | Redirige al área según rol | `login.spec.ts` | PASS |
| TC-06 | Autenticación | Credenciales incorrectas | Credenciales inválidas | Muestra mensaje de error | `login.spec.ts` | PASS |
| TC-07 | Autenticación | Cierre de sesión | Sesión activa | Cierra sesión y vuelve a inicio | `inicio.spec.ts` | PASS |
| TC-08 | Cuenta | Eliminar cuenta | Sesión activa | Elimina cuenta y cierra sesión | `profile.spec.ts` | PASS |
| TC-09 | Cuenta | Cambiar contraseña | Sesión activa y contraseña válida | Actualiza contraseña y cierra sesión | `profile.spec.ts` | KNOWN BUG · BUG-007 |
| TC-10 | Cuenta | Contraseña actual incorrecta | Sesión activa | Conserva cuenta y muestra error | `profile.spec.ts` | PASS |
| TC-11 | Perfil | Completar perfil | Documentos PDF disponibles | Guarda documentos y completa el perfil | `profile.spec.ts` | PASS |
| TC-12 | Perfil | Actualizar perfil | Sesión activa y archivos válidos | Guarda datos y muestra la imagen actualizada | `profile.spec.ts` | KNOWN BUG · BUG-004 |
| TC-13 | Perfil | Cambiar rol | Perfil completado | Redirige al área del rol seleccionado | `inicio.spec.ts` | PASS |
| TC-14 | Vacantes | Crear empleo | Empleador con perfil completo | Crea y lista la oferta | `mis-empleos.spec.ts` | PASS |
| TC-15 | Vacantes | Crear empleo incompleto | Empleador con perfil completo | Impide envío y muestra validaciones | Manual | PASS |
| TC-16 | Vacantes | Ver imagen del empleo | Oferta creada con imagen | Muestra la imagen cargada | Manual | KNOWN BUG · BUG-005 |
| TC-17 | Vacantes | Administrar empleo | Empleador con oferta propia | Muestra acciones administrativas | Manual | KNOWN BUG · BUG-006 |
| TC-18 | Búsqueda | Mostrar y filtrar empleos activos | Empleado y ofertas activas | Lista ofertas y filtra por categoría/palabra | Manual | KNOWN BUG · BUG-001/002/003 |

## Detalle de ejecución

Para repetir la suite:

```bash
pnpm exec playwright test
```

Para un caso automatizado concreto:

```bash
pnpm exec playwright test --grep "Cambiar contraseña|Actualizar perfil"
```

Los mensajes y selectores esperados deben mantenerse alineados con los Page Objects y las vistas. Cuando un defecto se corrija, retira el `test.fail` correspondiente, ejecuta la prueba y actualiza esta matriz y el reporte relacionado.
