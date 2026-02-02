@extends('layout')

<title>Mis Empleos - SenaWork</title>
<meta content="" name="description">
<meta content="" name="keywords">

<!-- Favicons -->
<link href="assets/img/mi_logo.png" rel="icon">
<link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

<!-- <=========== Estilos ===========> -->
@section('styles')
<style>
    #empleos {
        border-radius: 10px;
        text-align: center;
        padding: 20px;
        box-shadow: 0px 0px 1px;
        min-height: 300px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    #empleos:hover {
        box-shadow: 2px 2px 5px;
    }

    #empleos .btn {
        display: none;
    }

    #empleos:hover .btn {
        display: inline;
    }

    .btn-content {
        height: 35px;
    }

    .card-header {
        text-align: center;
    }

    .btn {
        display: inline;
    }
</style>
@stop

<!-- <=========== Header del contenido ===========> -->
@section('busqueda')

<div class="pagetitle">
    <div class="d-flex align-items-center float-start mx-2 m-3">
        <h3>Mis empleos</h3>
    </div>

    <form class="d-flex align-items-center float-end m-2" method="GET" action="{{ route('buscar.mis.empleos') }}">
        @csrf
        <select name="orden" id="orden" class="form-select w-100 mx-1" aria-label="Default select example">
            <option selected disabled>Ordenar por...</option>
            <option value="az" {{ request('orden') == 'az' ? 'selected' : '' }}>A-Z </option>
            <option value="za" {{ request('orden') == 'za' ? 'selected' : '' }}>Z-A </option>
            <option value="estado" {{ request('orden') == 'estado' ? 'selected' : '' }}>Estado </option>
            <option value="antigua" {{ request('orden') == 'antigua' ? 'selected' : '' }}>Fecha más antigua</option>
            <option value="reciente" {{ request('orden') == 'reciente' ? 'selected' : '' }}>Fecha más reciente</option>
        </select>

        <select name="categoria" id="categoria" class="form-select w-100 mx-1" aria-label="Default select example">
            <option selected disabled>Categorías</option>
            @foreach($categorias as $categoria)
            <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
            @endforeach
        </select>
        <button type="submit" class="btn btn-primary pt-3"><i class="bi bi-search"></i></button>
    </form>
</div>
<hr>

@stop

<!-- <=========== Contenido Principal ===========> -->
@section('content')

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="bi bi-check-circle me-1"></i>
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <i class="bi bi-exclamation-octagon me-1"></i>
    {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div>
    <form class="d-flex float-end" method="" action="#">
        <a href="{{ route('crear.empleo') }}" class="btn btn-primary w-100">
            <i class="mdi mdi-plus bi bi-bag-plus-fill"></i>
            Crear Empleo
        </a>
    </form>
</div>

@if($empleos->isEmpty())
<p>No tienes empleos en esta categoría.</p>
@else
<div class="row col-12">
    @foreach($empleos as $empleo)
    <div class="col-lg-3 py-2">
        <a data-bs-toggle="modal" data-bs-target="#verEmpleos{{ $empleo->id }}" class="text-decoration-none text-dark">
            <div class="bg-white" style="cursor: pointer;" id="empleos">
                <h4 class="fw-bold mt-3" style="color: #00304D;">
                    <span title="{{ $empleo->nombre }}">
                        {{ \Illuminate\Support\Str::limit($empleo->nombre, 21, '...') }}
                    </span>
                </h4>
                <h6 class="fw-bold" style="color: #00304D;">{{ $empleo->categoria->nombre }}</h6><br>
                <h6 class="fw-bold" style="color: #00304D;">Estado: {{ $empleo->estado_empleo }}</h6>
                <form class="btn-content pt-3" action="#" method="POST">
                    <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#verEmpleos{{ $empleo->id }}">Ver</a>
                </form>
            </div>
        </a>
    </div>


    <!-- <=========== Pop-up "Ver-Aplicar" ===========> -->
    <div class="modal fade" id="verEmpleos{{ $empleo->id }}" tabindex="-1" aria-labelledby="cardModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="card">
                    <div class="card-header fw-bold">
                        Información del empleo
                    </div>
                    <div class="card-body">
                        @if($empleo->estado_empleo === 'En proceso')
                        <button type="button" class="btn btn-danger float-end" data-bs-toggle="modal" data-bs-target="#reporteModal{{ $empleo->id }}">
                            <i class="bi bi-exclamation-octagon"></i>
                        </button>
                        @endif<br>
                        <h5 class="card-title d-inline">Servicio: </h5><span class="card-text"> {{ $empleo->nombre }} </span><br><br>
                        @if($empleo->estado_empleo == 'En proceso')
                        @php
                        $postulacionSeleccionada = $empleo->postulaciones()->where('estado_postulacion', 'Seleccionado')->first();
                        @endphp


                        @if($postulacionSeleccionada)
                        <h5 class="card-title d-inline">Seleccionado: </h5>
                        <span class="card-text">
                            {{ $postulacionSeleccionada->usuario->nombre }}
                            {{ $postulacionSeleccionada->usuario->s_nombre }}
                            {{ $postulacionSeleccionada->usuario->apellido }}
                            {{ $postulacionSeleccionada->usuario->s_apellido }}
                        </span><br><br>
                        @endif
                        @endif

                        @if($empleo->estado_empleo == 'Finalizado')
                        @php
                        $postulacion = $empleo->postulaciones()->where('estado_postulacion', 'Realizado')->first();
                        @endphp

                        @if($postulacion)
                        <h5 class="card-title d-inline">Seleccionado: </h5>
                        <span class="card-text">
                            {{ $postulacion->usuario->nombre }}
                            {{ $postulacion->usuario->s_nombre }}
                            {{ $postulacion->usuario->apellido }}
                            {{ $postulacion->usuario->s_apellido }}
                        </span><br><br>
                        @endif
                        @endif
                        <h5 class="card-title d-inline">Categoría: </h5><span class="card-text"> {{ $empleo->categoria->nombre }} </span><br><br>
                        <h5 class="card-title d-inline">Fecha de apertura: </h5><span class="card-text"> {{ $empleo->fecha_creacion->format('d/m/Y') }} </span><br><br>
                        <h5 class="card-title d-inline">Fecha de cierre: </h5><span class="card-text"> {{ $empleo->fecha_cierre->format('d/m/Y') }} </span><br><br>
                        <h5 class="card-title d-inline">Ubicación: </h5><span class="card-text"> {{ $empleo->ubicacion }} </span><br><br>
                        <h5 class="card-title d-inline">Descripción: </h5><br><span class="card-text"> {{ $empleo->descripcion }} </span><br><br>
                        <h5 class="card-title d-inline">Fotos: </h5><br>

                        @if ($empleo->fotos)
                        @foreach (json_decode($empleo->fotos) as $foto)
                        <a href="{{ Storage::url($foto) }}" target="_blank">
                            <img src="{{ Storage::url($foto) }}" alt="Foto del Empleo" class="img-thumbnail" style="width: 100px; height: 100px; object-fit: cover;">
                        </a>
                        @endforeach
                        @else
                        <p>No hay fotos disponibles para este empleo.</p>
                        @endif

                        <br><br>
                        <div class="d-flex justify-content-center">

                            @if($empleo->estado == 1 && $empleo->estado_empleo == 'En proceso')
                            <button class="btn btn-success mx-2" type="button" data-bs-toggle="modal" data-bs-target="#finalizarEmpleo{{ $empleo->id }}">Finalizar</button>
                            @endif

                            @if($empleo->estado == 1 && $empleo->estado_empleo == 'Publicado')
                            <button class="btn btn-danger mx-2" type="button" data-bs-toggle="modal" data-bs-target="#eliminarEmpleo{{ $empleo->id }}">Eliminar</button>
                            <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#verPostulados{{ $empleo->id }}">Ver Postulados</button>
                            @endif

                            <button type="button" class="btn btn-secondary mx-2" data-bs-dismiss="modal">Cerrar</button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal "Reporte" -->
    <div class="modal fade" id="reporteModal{{ $empleo->id }}" tabindex="-1" aria-labelledby="reporteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="card">
                    <div class="card-header fw-bold">
                        Reporte de usuario
                    </div>

                    <div class="card-body">
                        <form action="{{ route('empleo.reportarUsuario', $empleo->id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="empleo_id" value="{{ $empleo->id }}">

                            @if($empleo->estado_empleo == 'En proceso')
                            @php
                            $postulacionSeleccionada = $empleo->postulaciones()->where('estado_postulacion', 'Seleccionado')->first();
                            @endphp


                            @if($postulacionSeleccionada)
                            <h5 class="card-title d-inline">Usuario:</h5>
                            <span class="card-text">
                                {{ $postulacionSeleccionada->usuario->nombre }}
                                {{ $postulacionSeleccionada->usuario->s_nombre }}
                                {{ $postulacionSeleccionada->usuario->apellido }}
                                {{ $postulacionSeleccionada->usuario->s_apellido }}
                            </span><br><br>
                            @endif
                            @endif

                            <h5 class="card-title d-inline">Motivo:</h5>
                            <select name="motivo" id="motivo" class="form-select w-100 mx-1" aria-label="Default select example" required>
                                <option selected disabled>Seleccione...</option>
                                <option value="informacion_falsa">Información falsa o engañosa</option>
                                <option value="salario_irrealista">Salario muy por debajo del estándar</option>
                                <option value="fraude">Sospecha de fraude o estafa</option>
                            </select><br>

                            <h5 class="card-title d-inline">Comentario:</h5>
                            <textarea name="comentario" class="form-control" rows="4" placeholder="Escriba un comentario adicional..." required></textarea>
                            <br>

                            <div class="d-flex justify-content-center">
                                <button type="submit" class="btn btn-danger">Enviar reporte</button>
                                <button type="button" class="btn btn-secondary mx-2" data-bs-dismiss="modal">Cerrar</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Ver Postulados -->
    <div class="modal fade" id="verPostulados{{ $empleo->id }}" tabindex="-1" aria-labelledby="postuladosLabel{{ $empleo->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="card-header fw-bold">
                    Postulados
                </div>

                <div class="card-body">
                    <div class="row align-items-center mb-3 fw-bold">
                        <div class="col-md-3 text-center">
                            <span>Nombre</span>
                        </div>
                        <div class="col-md-3 text-center">
                            <span>Categoría</span>
                        </div>
                        <div class="col-md-2 text-center">
                            <span>Puntuación</span>
                        </div>
                        <div class="col-md-2 text-center">
                            <span>Fecha</span>
                        </div>
                        <div class="col-md-2 text-end">
                            <span class="mx-5">Acción</span>
                        </div>
                    </div>
                    <hr>

                    <div class="card-body">
                        @foreach ($postulacionesEnEspera[$empleo->id] as $postulacion)
                        <div class="row align-items-center mb-3">
                            <div class="col-md-3 text-center">
                                <span><strong>{{ $postulacion->usuario->nombre }} {{ $postulacion->usuario->s_nombre }} {{ $postulacion->usuario->apellido }} {{ $postulacion->usuario->s_apellido }}</strong></span>
                            </div>

                            <div class="col-md-3 text-center">
                                <span>{{ $postulacion->usuario->categoria->nombre }}</span>
                            </div>

                            <div class="col-md-2 text-center">
                                <span>
                                    {{ $postulacion->usuario->prom_puntuaciones }}
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <=$postulacion->usuario->prom_puntuaciones)
                                        <i class="bi bi-star-fill" style="color: gold;"></i>
                                        @else
                                        <i class="bi bi-star" style="color: grey;"></i>
                                        @endif
                                        @endfor
                                </span>
                            </div>

                            <div class="col-md-2 text-center">
                                <span>{{ $postulacion->fecha_inicio->format('d/m/Y') }}</span>
                            </div>

                            <div class="col-md-2 d-flex justify-content-end">
                                <form action="" method="GET" class="me-2">
                                    @csrf
                                    <a class="btn btn-warning btn-sm bi bi-telephone-fill" data-bs-toggle="modal" data-bs-target="#verContacto"></a>
                                </form>
                                <form action="{{ route('descargar.portafolio', $postulacion->usuario_id) }}" method="GET" class="me-2">
                                    @csrf
                                    <button type="submit" class="btn btn-info btn-sm bi bi-file-earmark-person-fill"></button>
                                </form>
                                <form action="{{ route('seleccionar.postulado', $postulacion->id) }}" method="POST" class="me-2">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm bi bi-person-check-fill"></button>
                                </form>
                            </div>
                        </div>
                        <hr>
                        @endforeach
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- <=========== Pop-up "Contactar" ===========> -->
    <div class="modal fade" id="verContacto" tabindex="-1" aria-labelledby="verContacto" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="card">
                    <div class="card-header fw-bold">
                        Contactar
                    </div>
                    <div class="card-body">
                        <h5 class="card-title text-center">Próximamente:</h5>
                        <div class="d-flex justify-content-center">
                            <img src="assets/img/icon-whatsapp.png" alt="Icon Whatsapp">
                            <img src="assets/img/icon-telegram.png" alt="Icon Telegram">
                        </div>
                        <br><br>

                        <div class="d-flex justify-content-center">
                            <button type="button" class="btn btn-secondary mx-2" data-bs-dismiss="modal">Cerrar</button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- <=========== Pop-up "Eliminar" ===========> -->
    <div class="modal fade" id="eliminarEmpleo{{ $empleo->id }}" tabindex="-1" aria-labelledby="eliminarEmpleoLabel{{ $empleo->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="card">
                    <div class="card-header fw-bold">
                        Eliminar empleo
                    </div>
                    <div class="card-body">
                        <h3 class="card-title">¿Estás seguro de que deseas eliminar este empleo?</h3>
                        <p class="card-text">Esta acción no se puede deshacer y no podrás recuperar esta información.</p>

                        <div class="d-flex justify-content-center">
                            <form action="{{ route('eliminar.empleo', $empleo->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-danger mx-2">Aceptar</button>
                                <button type="button" class="btn btn-secondary mx-2" data-bs-dismiss="modal">Cancelar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- Modal para finalizar empleo -->
    <div class="modal fade" id="finalizarEmpleo{{ $empleo->id }}" tabindex="-1" aria-labelledby="finalizarEmpleoLabel{{ $empleo->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="card">
                    <div class="card-header fw-bold">Finalizar empleo</div>
                    <div class="card-body">
                        <h3 class="card-title">¿Estás seguro de que deseas finalizar el empleo?</h3>
                        <p class="card-text">Esta acción no se podrá deshacer.</p>

                        <div class="d-flex justify-content-center">
                            <form action="{{ route('empleos.finalizar', $empleo->id) }}" method="POST">
                                @csrf
                                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalCalificacion{{ $empleo->id }}">Aceptar</button>
                                <button type="button" class="btn btn-secondary mx-2" data-bs-dismiss="modal">Cancelar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- Modal de calificación -->
    <div class="modal fade" id="modalCalificacion{{ $empleo->id }}" tabindex="-1" data-bs-backdrop="false" aria-labelledby="modalCalificacionLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="card">
                    <div class="card-header fw-bold" id="ratingModalLabel">Calificar al empleado</div>
                    <div class="card-body">
                        <form action="{{ route('guardar.calificacion', $empleo->id) }}" method="POST">
                            @csrf

                            <div class="form-group text-center">
                                <h5 class="card-title d-inline text-center" for="calificacion">Calificación:</h5><br><br>
                                <div id="stars-{{ $empleo->id }}" class="d-flex justify-content-center stars">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i class="bi bi-star-fill star mx-2" data-value="{{ $i }}" style="color: grey; font-size: 2rem; cursor: pointer;"></i>
                                        @endfor
                                </div>
                                <input type="hidden" name="calificacion" id="input-calificacion-{{ $empleo->id }}" value="1">
                            </div>

                            <div class="form-group">
                                <br>
                                <h5 class="card-title d-inline" for="comentario">Comentario:</h5>
                                <textarea name="comentario" class="form-control" rows="4" required></textarea><br>
                            </div>

                            <div class="d-flex justify-content-center">
                                <button type="submit" class="btn btn-success mt-3">Enviar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const starContainers = document.querySelectorAll('.stars');

            starContainers.forEach(starContainer => {
                const stars = starContainer.querySelectorAll('.star');
                const inputCalificacion = starContainer.nextElementSibling;

                stars.forEach(star => {
                    star.addEventListener('mouseover', function() {
                        resetStars(stars);
                        this.style.color = 'gold';
                        let previousSibling = this.previousElementSibling;

                        while (previousSibling) {
                            previousSibling.style.color = 'gold';
                            previousSibling = previousSibling.previousElementSibling;
                        }
                    });

                    star.addEventListener('mouseout', function() {
                        resetStars(stars, inputCalificacion.value);
                    });

                    star.addEventListener('click', function() {
                        inputCalificacion.value = this.getAttribute('data-value');
                        resetStars(stars, inputCalificacion.value);
                    });
                });
            });

            function resetStars(stars, value = 0) {
                stars.forEach((star, index) => {
                    if (index < value) {
                        star.style.color = 'gold';
                    } else {
                        star.style.color = 'grey';
                    }
                });
            }
        });
    </script>

    @endforeach
</div>
@endif
@stop

<a href="#" class="back-to-top d-flex align-items-center justify-content-center">
    <i class="bi bi-arrow-up-short"></i>
</a>