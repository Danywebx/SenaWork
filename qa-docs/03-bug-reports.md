# 🐛 Reporte de Fallos (Bug Reports)

### BUG-001: No se muestran los empleos activos desde la página de inicio
- **Severidad:** Alta | **Prioridad:** Alta
- **Descripción:** Al acceder a la página de inicio no se muestran los empleos activos.
- **Rol:** Empleado.
- **Entorno:** Local / Navegador Brave 1.93 / MySQL 8.0
- **Precondiciones:** Existir 1 o más empleos registrados que estén activos y estar logueado.
- **Pasos para reproducir:**
  1. Iniciar sesión como Empleado.
  2. Acceder a la página de Inicio.
- **Resultado Esperado:** Mostrar todos los empleos que estén activos.
- **Resultado Obtenido:** No se muestra ni un solo empleo.
- **Captura de pantalla:**
![image1](./screenshots/Screenshot%20From%202026-08-25%2001-05-07.png)
<br>


### BUG-002: No se muestran los empleos al filtrarlos por categoría
- **Severidad:** Alta | **Prioridad:** Alta
- **Descripción:** Al seleccionar una categoría y dar "Enter" o click en el botón de buscar no se muestran los empleos que pertenecen a esta categoría y estan activos.
- **Rol:** Empleado.
- **Entorno:** Local / Navegador Brave 1.93 / MySQL 8.0
- **Precondiciones:** Existir 1 o más empleos que pertenezcan a la categoría seleccionada, que estos empleos estén activos y estar logueado.
- **Pasos para reproducir:**
  1. Iniciar sesión como Empleado.
  2. Acceder a la página de Inicio.
  3. Seleccionar una de las categorías disponibles.
  4. Dar "Enter" o click en el botón de busqueda.
- **Resultado Esperado:** Mostrar todos los empleos activos que pertenecen a la categoría seleccionada.
- **Resultado Obtenido:** No se muestra ni un solo empleo.
- **Captura de pantalla:**
![image2](./screenshots/Screenshot%20From%202026-08-25%2002-10-37.png)
<br>


### BUG-003: El filtro de palabra clave no muestra resultados al buscar un empleo por su nombre
- **Severidad:** Alta | **Prioridad:** Alta
- **Descripción:** Al escribir el nombre de un empleo en el filtro de palabra clave no se muestra ningún resultado, pero si se escribe una pequeña parte de la descripción si se muestra.
- **Rol:** Empleado.
- **Entorno:** Local / Navegador Brave 1.93 / MySQL 8.0
- **Precondiciones:** Existir 1 o más empleos que contengan la misma palabra en su nombre, que estos empleos estén activos y estar logueado.
- **Pasos para reproducir:**
  1. Iniciar sesión como Empleado.
  2. Acceder a la página de Inicio.
  3. Escribir la palabra clave en el filtro de busqueda.
  4. Dar "Enter" o click en el botón de busqueda.
- **Resultado Esperado:** Mostrar todos los empleos activos que en su nombre contengan la palabra clave que se buscó en el filtro.
- **Resultado Obtenido:** No se muestra ni un solo empleo.
- **Captura de pantalla:**
![image3](./screenshots/Screenshot%20From%202026-08-25%2002-09-23.png)
<br>


### BUG-004: No se muestra la imagen de perfil
- **Severidad:** Media | **Prioridad:** Media
- **Descripción:** Al cargar y actualizar una foto de perfil, está no se muestra.
- **Rol:** Empleado/Empleador.
- **Entorno:** Local / Navegador Brave 1.93 / MySQL 8.0
- **Precondiciones:** Seleccionar una imagen y estar logueado.
- **Pasos para reproducir:**
  1. Iniciar sesión como Empleado o Empleador.
  2. Acceder a la página del perfil.
  3. Ir a la sección "Editar Perfil".
  4. Dar click en el botón "Subir".
  5. Seleccionar una imagen.  
  6. Dar click en el botón "Guardar cambios".
- **Resultado Esperado:** La página se debe recargar y se debe presentar la imagen de perfil actualizada en los espacios correspondientes.
- **Resultado Obtenido:** No se muestra la imagen de perfil en ningun espacio.
- **Captura de pantalla:**
![image4](./screenshots/Screenshot%20From%202026-08-25%2002-30-40.png)
<br>


### BUG-005: No se muestra la imagen del empleo al crearlo
- **Severidad:** Media | **Prioridad:** Media
- **Descripción:** Al cargar y publicar un empleo la imagen no se muestra.
- **Rol:** Empleador.
- **Entorno:** Local / Navegador Brave 1.93 / MySQL 8.0
- **Precondiciones:** Seleccionar una imagen y estar logueado.
- **Pasos para reproducir:**
  1. Iniciar sesión como Empleador.
  2. Acceder a la página "Mis empleos".
  3. Dar click en el botón "Crear Empleo".
  4. Registrar el formulario.
  5. Seleccionar una imagen.  
  6. Dar click en el botón "Enviar".
  7. Ver el empleo creado.
- **Resultado Esperado:** Al crear el empleo el sistema te debe redirigir a la página "Mis empleos", y al revisar el empleo creado debería poderse visualizar la imagen previamente cargada en el formulario.
- **Resultado Obtenido:** No se muestra la imagen del empleo.
- **Captura de pantalla:**
![image4](./screenshots/Screenshot%20From%202026-08-25%2002-40-31.png)
<br>


### BUG-006: No se puede acceder a la administración de empleo
- **Severidad:** Alta | **Prioridad:** Alta
- **Descripción:** Al acceder a la información de un empleo no se muestra el botón "Administrar".
- **Rol:** Empleador.
- **Entorno:** Local / Navegador Brave 1.93 / MySQL 8.0
- **Precondiciones:** Existir 1 o más empleos creados por el usuario, que estos empleos estén activos y estar logueado.
- **Pasos para reproducir:**
  1. Iniciar sesión como Empleador.
  2. Acceder a la página "Mis empleos".
  3. Dar click sobre un empleo o en el botón "Ver".  
- **Resultado Esperado:** Al acceder a la información del empleo se debe mostrar un botón "Administrar" que te permitirá tomar acciones administrativas sobre este empleo, tales como: Editar, ver candidatos, filtrar candidatos, seleccionar candidato, eliminar empleo.
- **Resultado Obtenido:** No se muestra el botón "Administrar".
- **Captura de pantalla:**
![image4](./screenshots/Screenshot%20From%202026-08-25%2002-40-31.png)
<br>