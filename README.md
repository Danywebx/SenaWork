<p align="center">
  <img src="./public/assets/img/mi_logo.png" alt="SenaWork Logo" width="200">
</p>

# SenaWork

![Playwright Tests](https://github.com/Danywebx/SenaWork/actions/workflows/playwright.yml/badge.svg)

Plataforma web para conectar empleadores con trabajadores del sector informal. SenaWork permite publicar y buscar oportunidades, gestionar perfiles y documentos, postularse a empleos y administrar el ciclo de una postulación.

## Índice

- [Funcionalidades](#funcionalidades)
- [Tecnologías](#tecnologías)
- [Arquitectura de pruebas](#arquitectura-de-pruebas)
- [Requisitos](#requisitos)
- [Instalación y ejecución](#instalación-y-ejecución)
- [Pruebas](#pruebas)
- [Documentación QA](#documentación-qa)
- [Estado conocido](#estado-conocido)
- [Contribución](#contribución)
- [Licencia](#licencia)

## Funcionalidades

- Registro, inicio y cierre de sesión.
- Perfiles para los roles **Empleado** y **Empleador**.
- Carga de documentos y actualización de información personal.
- Publicación y gestión de oportunidades laborales.
- Búsqueda de empleos por palabra clave y categoría.
- Postulación, seguimiento y calificación de procesos laborales.
- Reporte de usuarios y ofertas.

## Tecnologías

| Capa | Tecnología |
| --- | --- |
| Backend | Laravel 11, PHP 8.2+ |
| Frontend | Blade, Bootstrap, Vite |
| Persistencia | MySQL 8.0 (CI y entorno recomendado) |
| Automatización | Playwright 1.63+, TypeScript |
| Calidad continua | GitHub Actions |
| Gestión de paquetes | Composer y pnpm |

## Arquitectura de pruebas

La automatización E2E está organizada con:

- **Page Object Model:** acciones y localizadores encapsulados en `e2e/page-objects`.
- **Fixtures reutilizables:** registro, autenticación y completar perfil en `e2e/fixtures`.
- **Datos de prueba:** archivos controlados en `e2e/data` y datos dinámicos para evitar colisiones.
- **Aislamiento:** `global-setup.ts` ejecuta `php artisan migrate:fresh --seed` al correr la suite completa.
- **CI:** cada push o pull request hacia `main` instala la aplicación, prepara MySQL, compila Vite y ejecuta Playwright en Chromium. El reporte HTML se conserva como artifact durante 14 días.

## Requisitos

- Git
- PHP 8.2 o superior y extensiones requeridas por Laravel
- Composer
- Node.js 20 o superior
- pnpm 10 o superior
- MySQL 8.0 para reproducir el entorno de CI (XAMPP, Docker o instalación local)

## Instalación y ejecución

```bash
git clone https://github.com/Danywebx/SenaWork.git
cd SenaWork
composer install
pnpm install
cp .env.example .env
php artisan key:generate
```

### Configuración recomendada con MySQL

Crea una base de datos llamada `senawork` y configura `.env`:

```env
APP_URL=http://127.0.0.1:8000
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=senawork
DB_USERNAME=root
DB_PASSWORD=
```

Después ejecuta:

```bash
php artisan migrate --seed
pnpm build
php artisan serve
```

La aplicación estará disponible en <http://127.0.0.1:8000>.

## Pruebas

### Suite E2E

Instala los navegadores una sola vez:

```bash
pnpm exec playwright install --with-deps
```

Ejecuta todos los escenarios:

```bash
pnpm exec playwright test
```

Ejecuta un archivo o caso específico:

```bash
pnpm exec playwright test e2e/specs/login.spec.ts
pnpm exec playwright test --grep "Registrar usuario"
```

Abre el reporte HTML:

```bash
pnpm exec playwright show-report
```

## Documentación QA

La documentación está centralizada en [`qa-docs/`](./qa-docs/):

- [Guía de documentación QA](./qa-docs/README.md)
- [Plan de pruebas](./qa-docs/01-test-plan.md)
- [Matriz de casos de prueba](./qa-docs/02-test-cases.md)
- [Reportes de defectos](./qa-docs/03-bug-reports.md)

## Estado conocido

La suite automatizada identifica dos escenarios marcados como `test.fail` por defectos conocidos: cierre de sesión después de cambiar la contraseña y visualización de la foto después de actualizar el perfil. Además, la exploración funcional registró defectos de búsqueda, imágenes de ofertas y administración de empleos. El detalle, la severidad, la evidencia y el impacto están en [03-bug-reports.md](./qa-docs/03-bug-reports.md).

Los estados de los casos representan la última ejecución documentada; deben actualizarse cuando cambie la aplicación o se ejecute nuevamente la suite.

## Contribución

1. Crea una rama descriptiva desde `main`.
2. Implementa el cambio y agrega o actualiza pruebas.
3. Ejecuta las pruebas relevantes y actualiza la documentación QA si cambia el comportamiento.
4. Abre un pull request describiendo el cambio, la evidencia y los riesgos conocidos.

## Licencia

Proyecto académico y de portafolio desarrollado durante el proceso de formación en Análisis y Desarrollo de Software (ADSO).
