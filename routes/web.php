<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BusquedaController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\EmpleadorController;
use App\Http\Controllers\EmpleoController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

//----------AUTENTICACIÓN----------//
Route::get('/', function () {
    if (Auth::check()) {
        $user = Auth::user();

        if ($user->rol_id == 2) {
            return redirect()->route('empleado');
        } elseif ($user->rol_id == 3) {
            return redirect()->route('empleador');
        }
    } else {
        return redirect()->route('inicio');
    }
});

Route::get('/inicio', [BusquedaController::class, 'index'])->name('inicio')->middleware('guest');

Route::get('login', function () {
    return view('login');
})->name('login')->middleware('guest');

Route::post('login', [AuthController::class, 'login'])->name('login.proceso')->middleware('guest');

Route::get('registro', [AuthController::class, 'registerForm'])->name('registro')->middleware('guest');

Route::post('registro', [AuthController::class, 'register'])->name('registro.proceso')->middleware('guest');

Route::get('home', [UsuarioController::class, 'invitado'])->name('invitado')->middleware('guest');

Route::get('/busqueda-invitado', [BusquedaController::class, 'buscar'])->name('buscar.invitado')->middleware('guest');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('A7Dev', function () {
    return view('equipo');
})->name('equipo');


//----------EMPLEADO----------//
Route::middleware(['auth', 'role:2'])->group(function () {
    Route::get('empleado', [EmpleadoController::class, 'index'])->name('empleado');

    Route::get('/busqueda-empleo', [EmpleadoController::class, 'index'])->name('buscar.empleos');

    Route::post('/cambiar-estado-perfil', [EmpleadoController::class, 'cambiarEstadoPerfil'])->name('cambiar.estado');

    Route::post('/empleado/aplicar/{id}', [EmpleadoController::class, 'aplicar'])->name('empleado.aplicar');

    Route::post('/empleado/reportar/{empleo}', [EmpleadoController::class, 'reportarUsuario'])->name('empleado.reportar');

    Route::post('/empleo/reportar/{empleo}', [EmpleoController::class, 'reportarEmpleo'])->name('empleo.reporte');

    Route::get('/postulaciones', [EmpleadoController::class, 'mostrarPostulaciones'])->name('postulaciones');

    Route::get('/busqueda-postulacion', [EmpleadoController::class, 'mostrarPostulaciones'])->name('buscar.postulaciones');

    Route::post('/cancelar-postulacion/{id}', [EmpleadoController::class, 'cancelarPostulacion'])->name('cancelar.postulacion');

    Route::post('/postulaciones/{empleo}/finalizar', [EmpleadoController::class, 'finalizarPostulacion'])->name('postulacion.finalizar');

    Route::post('/postulaciones/{empleo}/guardar-calificacion', [EmpleadoController::class, 'guardarCalificacion'])->name('guarda.calificacion');
});




//----------AMBOS----------//
Route::middleware(['auth'])->group(function () {

    Route::get('/perfil', [UsuarioController::class, 'perfil'])->name('perfil');

    Route::get('/descargar-mi-portafolio', [UsuarioController::class, 'descargarMiPortafolio'])->name('descargar.miportafolio');

    Route::post('/documentos/subir', [UsuarioController::class, 'subirDocumentos'])->name('subir.documentos');

    Route::post('/perfil/actualizar', [UsuarioController::class, 'actualizarPerfil'])->name('actualizar.perfil');

    Route::get('/perfil/eliminar-foto', [UsuarioController::class, 'eliminarFotoPerfil'])->name('eliminar.foto.perfil');

    Route::post('/cambiar-contrasena', [UsuarioController::class, 'cambiarContrasena'])->name('cambiar.contrasena');

    Route::get('puntuaciones', function () {
        return view('puntuaciones');
    })->name('puntuaciones');

    Route::post('/cambiar-rol', [UsuarioController::class, 'cambiarRol'])->name('cambiar.rol');

    Route::post('/eliminar-cuenta', [AuthController::class, 'eliminarCuenta'])->name('eliminar.cuenta');
});




//----------EMPLEADOR----------//
Route::middleware(['auth', 'role:3'])->group(function () {
    Route::get('empleador', [EmpleadorController::class, 'index'])->name('empleador');

    Route::get('/busqueda-usuarios', [EmpleadorController::class, 'index'])->name('buscar.usuarios');

    Route::get('crear_empleo', [EmpleoController::class, 'index'])->name('crear.empleo');

    Route::post('crearempleo', [EmpleoController::class, 'publicarEmpleo'])->name('empleo.proceso');

    Route::get('empleos', [EmpleadorController::class, 'misEmpleos'])->name('mis.empleos');

    Route::post('/empleo/reportar-usuario/{empleo}', [EmpleadorController::class, 'reportarUsuario'])->name('empleo.reportarUsuario');

    Route::get('/busqueda-empleos', [EmpleadorController::class, 'misEmpleos'])->name('buscar.mis.empleos');

    Route::get('/descargar-portafolio/{usuario_id}', [EmpleadorController::class, 'descargarPortafolio'])->name('descargar.portafolio');

    Route::post('/postulado/seleccionar/{id}', [EmpleadorController::class, 'seleccionarPostulado'])->name('seleccionar.postulado');

    Route::post('eliminar-empleo/{id}', [EmpleadorController::class, 'eliminarEmpleo'])->name('eliminar.empleo');

    Route::post('/empleos/{empleo}/finalizar', [EmpleadorController::class, 'finalizarEmpleo'])->name('empleos.finalizar');

    Route::post('/empleos/{empleo}/guardar-calificacion', [EmpleadorController::class, 'guardarCalificacion'])->name('guardar.calificacion');

    // Route::post('/guardar-calificacion', [EmpleadorController::class, 'guardarCalificacion'])->name('guardar.calificaciond');
});
