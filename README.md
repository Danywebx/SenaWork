
<p align="center">
  <img src="./public/assets/img/mi_logo.png" alt="SenaWork Logo" width="200">
</p>


# SenaWork

SenaWork es una plataforma digital orientada a conectar empleadores y trabajadores del sector informal, facilitando la publicación, búsqueda y aplicación a oportunidades laborales.

El proyecto busca proporcionar un espacio digital que facilite la comunicación entre ambas partes y mejore el acceso a oportunidades de empleo, especialmente para personas que cuentan con experiencia empírica o que no disponen de una titulación académica formal.


## Requisitos 🛠️

Para ejecutar el proyecto localmente se requiere contar con:

- Git
- Composer
- Laravel 11
- PHP 8.2 y MySQL (Puedes utilizar Xampp)


## Ejecutar localmente 🚀

Clonar el proyecto

```bash
  git clone https://github.com/Danywebx/SenaWork.git
```

Ir al directorio del proyecto

```bash
  cd SenaWork
```

Instalar dependencias

```bash
  composer install
```

Copiar archivo .env

```bash
  cp .env.example .env
```

Configurar la conexión a la base de datos MySQL

```bash
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

Ejecutar migraciones

```bash 
  php artisan migrate
```

Iniciar servidor

```bash 
  php artisan serve
```
## Autores ✒️

Proyecto desarrollado como parte del proceso de formación en Análisis y Desarrollo de Software (ADSO).


## Licencia 📄

Este proyecto tiene fines académicos y de desarrollo.

