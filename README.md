<p align="center">
  <img src="./public/assets/img/mi_logo.png" alt="SenaWork Logo" width="200">
</p>

# SenaWork

![Playwright Tests](https://github.com/Danywebx/SenaWork/actions/workflows/playwright.yml/badge.svg)

SenaWork es una plataforma digital orientada a conectar empleadores y trabajadores del sector informal, facilitando la publicación, búsqueda y aplicación a oportunidades laborales.

El proyecto busca proporcionar un espacio digital que facilite la comunicación entre ambas partes y mejore el acceso a oportunidades de empleo, especialmente para personas que cuentan con experiencia empírica o que no disponen de una titulación académica formal.

## Tecnologías ⚙️

**Aplicación:**
- **Backend:** Laravel 11 (PHP 8.2)
- **Frontend:** Bootstrap
- **Base de Datos:** MySQL 8.0

**Testing & Automatización:**
- **Framework E2E:** Playwright + TypeScript
- **Arquitectura de pruebas:** Page Object Model + Fixtures personalizados
- **CI/CD:** GitHub Actions (pipeline con MySQL, migraciones, seeders y suite E2E completa en cada push/PR)
- **Gestor de paquetes:** pnpm

## Requisitos 🛠️

Para ejecutar el proyecto localmente se requiere contar con:
- Git
- Composer
- PHP 8.2+
- MySQL 8.0 (puedes usar XAMPP)
- Node.js 20+ y pnpm

## Ejecutar localmente 🚀

Clonar el proyecto

```bash
git clone https://github.com/Danywebx/SenaWork.git
```

Ir al directorio del proyecto

```bash
cd SenaWork
```

Instalar dependencias de PHP

```bash
composer install
```

Copiar archivo .env

```bash
cp .env.example .env
```

Configurar la conexión a la base de datos MySQL

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=senawork
DB_USERNAME=root
DB_PASSWORD=
```

Generar la clave de la aplicación

```bash
php artisan key:generate
```

Ejecutar migraciones y seeders

```bash
php artisan migrate --seed
```

Iniciar servidor

```bash
php artisan serve
```

## Pruebas QA 🧪

SenaWork cuenta con una estrategia de pruebas integral documentada en la carpeta [qa-docs](./qa-docs):

- [Plan de pruebas](./qa-docs/01-test-plan.md)
- [Casos de prueba](./qa-docs/02-test-cases.md)
- [Reporte de Bugs](./qa-docs/03-bug-reports.md)

### Suite de automatización E2E (Playwright + TypeScript)

Los casos de prueba críticos del flujo de autenticación y perfil están automatizados con **Playwright**, siguiendo el patrón **Page Object Model** y usando **fixtures** para precondiciones reutilizables (registro, login). La suite corre automáticamente en cada push/PR vía **GitHub Actions**, contra una base de datos MySQL limpia en cada ejecución.

Para correr la suite localmente:

```bash
pnpm install
pnpm exec playwright install --with-deps
pnpm exec playwright test
```

Ver el reporte HTML tras la ejecución:

```bash
npx playwright show-report
```
## Autores ✒️

Proyecto desarrollado como parte del proceso de formación en Análisis y Desarrollo de Software (ADSO).

## Licencia 📄

Este proyecto tiene fines académicos y de desarrollo.
