# 📋 Plan de Pruebas

## 1. Alcance
Este documento define la estrategia de pruebas para la plataforma **SenaWork**, combinando pruebas manuales documentadas con una suite de automatización E2E para los flujos críticos de la aplicación.

## 2. Tipos de Pruebas Ejecutadas
- **Pruebas Funcionales (Manual):** Módulos de autenticación, perfil, publicación de vacantes y postulaciones — documentadas en la [matriz de casos de prueba](./02-test-cases.md).
- **Pruebas E2E Automatizadas:** Automatización de los flujos críticos con Playwright y TypeScript, siguiendo el patrón Page Object Model, integrada en un pipeline de CI/CD.
- **Database Testing:** Verificación de integridad referencial y persistencia mediante consultas SQL en MySQL.

## 3. Entorno de Pruebas
- **DB:** MySQL 8.0 (local vía XAMPP / contenedor en CI)
- **Backend:** Laravel 11 / PHP 8.2
- **Herramientas QA (manual):** MySQL Workbench / DBeaver
- **Herramientas de automatización:** Playwright, TypeScript, pnpm, GitHub Actions

## 4. Estrategia de Automatización
- **Arquitectura:** Page Object Model — cada página del sistema se representa como una clase con sus locators y acciones encapsuladas.
- **Fixtures personalizados:** precondiciones reutilizables (usuario logueado, usuario recién registrado) inyectadas automáticamente en los tests que las requieren.
- **Datos de prueba:** generados dinámicamente en cada ejecución (correos, números de documento) para evitar dependencias entre pruebas y falsos positivos/negativos.
- **Integración continua:** cada push o pull request a `main` dispara la suite completa contra una base de datos MySQL recién sembrada, con el reporte HTML disponible como artifact descargable.
