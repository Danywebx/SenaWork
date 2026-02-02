@extends('layout')

<title>Mis Postulaciones - SenaWork</title>
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

    .modal-header {
        background-color: #00304D;
        color: #fff;
        text-align: center;
    }

    .card-text {
        text-align: start;
    }
</style>
@stop

<!-- <=========== Header del contenido ===========> -->
@section('busqueda')

<div class="pagetitle">

    <div class="d-flex align-items-center float-start mx-2 m-3">
        <h3>Mis postulaciones</h3>
    </div>

    <form class="d-flex align-items-center float-end m-2" method="GET" action="{{ route('buscar.postulaciones') }}">
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

@if($postulaciones->isEmpty())
<p>No se encontraron resultados para su búsqueda.</p>
@else
<div class="row col-12">
    @foreach($postulaciones as $postulacion)
    <div class="col-lg-3 py-2">
        <a data-bs-toggle="modal" data-bs-target="#verPostulacion{{ $postulacion->id }}" class="text-decoration-none text-dark">
            <div class="bg-white" style="cursor: pointer;" id="empleos">
                <h4 class="fw-bold mt-3" style="color: #00304D;">
                    <span title="{{ $postulacion->empleo->nombre }}">
                        {{ \Illuminate\Support\Str::limit($postulacion->empleo->nombre, 21, '...') }}
                    </span>
                </h4>
                <h6 class="fw-bold" style="color: #00304D;">{{ $postulacion->empleo->categoria->nombre }}</h6><br>
                <h6 class="fw-bold" style="color: #00304D;">Estado: {{ $postulacion->estado_postulacion }}</h6>
                <form class="btn-content pt-3" action="#" method="POST">
                    <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#verPostulacion{{ $postulacion->id }}">Ver</a>
                </form>
            </div>
        </a>
    </div>


    <!-- Pop-up "Ver Postulación" -->
    <div class="modal fade" id="verPostulacion{{ $postulacion->id }}" tabindex="-1" aria-labelledby="verPostulacionLabel{{ $postulacion->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="card">
                    <div class="card-header fw-bold" style="text-align:center">
                        Información del empleo
                    </div>
                    <div class="card-body">
                        @if($postulacion->estado_postulacion == 'Seleccionado')
                        <button type="button" class="btn btn-danger float-end" data-bs-toggle="modal" data-bs-target="#modalReportar{{ $postulacion->id }}">
                            <i class="bi bi-exclamation-octagon"></i>
                        </button>
                        @endif<br>
                        <h5 class="card-title d-inline">Servicio: </h5><span class="card-text"> {{ $postulacion->empleo->nombre }} </span><br><br>
                        <h5 class="card-title d-inline">Categoría: </h5><span class="card-text"> {{ $postulacion->empleo->categoria->nombre }} </span><br><br>
                        <h5 class="card-title d-inline">Publicado por: </h5>
                        <span class="card-text">
                            {{ $postulacion->empleo->usuario->nombre }}
                            @if ($postulacion->empleo->usuario->s_nombre)
                            {{ $postulacion->empleo->usuario->s_nombre }}
                            @endif
                            {{ $postulacion->empleo->usuario->apellido }}
                            @if ($postulacion->empleo->usuario->s_apellido)
                            {{ $postulacion->empleo->usuario->s_apellido }}
                            @endif
                        </span><br><br>
                        <h5 class="card-title d-inline">Fecha de apertura: </h5><span class="card-text"> {{ $postulacion->empleo->fecha_creacion->format('d/m/Y') }} </span><br><br>
                        <h5 class="card-title d-inline">Fecha de cierre: </h5><span class="card-text"> {{ $postulacion->empleo->fecha_cierre->format('d/m/Y') }} </span><br><br>
                        <h5 class="card-title d-inline">Fecha de aplicación: </h5><span class="card-text"> {{ $postulacion->fecha_inicio->format('d/m/Y') }} </span><br><br>
                        <h5 class="card-title d-inline">Ubicación: </h5><span class="card-text"> {{ $postulacion->empleo->ubicacion }} </span><br><br>
                        <h5 class="card-title d-inline">Descripción: </h5><br><span class="card-text"> {{ $postulacion->empleo->descripcion }} </span><br><br>
                        <h5 class="card-title d-inline">Fotos: </h5><br>

                        @if ($postulacion->empleo->fotos)
                        @foreach (json_decode($postulacion->empleo->fotos) as $foto)
                        <a href="{{ Storage::url($foto) }}" target="_blank">
                            <img src="{{ Storage::url($foto) }}" alt="Foto del Empleo" class="img-thumbnail" style="width: 100px; height: 100px; object-fit: cover;">
                        </a>
                        @endforeach
                        @else
                        <p>No hay fotos disponibles para este empleo.</p>
                        @endif

                        <br><br>
                        <div class="d-flex justify-content-center">

                            @if($postulacion->estado_postulacion == 'Realizado' && is_null($postulacion->puntuacion_empleador))
                            <button class="btn btn-success mx-2" type="button" data-bs-toggle="modal" data-bs-target="#finalizarEmpleo{{ $postulacion->id }}">Calificar</button>
                            @endif

                            @if ($postulacion->estado_postulacion == 'En espera')
                            <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#cancelarPostu{{ $postulacion->id }}">Cancelar</button>
                            @endif

                            <button type="button" class="btn btn-secondary mx-2" data-bs-dismiss="modal">Cerrar</button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal para finalizar empleo -->
    <div class="modal fade" id="finalizarEmpleo{{ $postulacion->id }}" tabindex="-1" aria-labelledby="finalizarEmpleoLabel{{ $postulacion->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="card">
                    <div class="card-header fw-bold">Finalizar empleo</div>
                    <div class="card-body">
                        <h3 class="card-title">¿Estás seguro de que deseas finalizar el trabajo?</h3>
                        <p class="card-text">Esta acción no se podrá deshacer.</p>

                        <div class="d-flex justify-content-center">
                            <form action="{{ route('postulacion.finalizar', $postulacion->id) }}" method="POST">
                                @csrf
                                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalCalificacion{{ $postulacion->id }}">Aceptar</button>
                                <button type="button" class="btn btn-secondary mx-2" data-bs-dismiss="modal">Cancelar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- Modal de calificación -->
    <div class="modal fade" id="modalCalificacion{{ $postulacion->id }}" tabindex="-1" data-bs-backdrop="false" aria-labelledby="modalCalificacionLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="card">
                    <div class="card-header fw-bold" id="ratingModalLabel">Calificar al empleado</div>
                    <div class="card-body">
                        <form action="{{ route('guarda.calificacion', $postulacion->id) }}" method="POST">
                            @csrf

                            <div class="form-group text-center">
                                <h5 class="card-title d-inline text-center" for="calificacion">Calificación:</h5><br><br>
                                <div id="stars-{{ $postulacion->id }}" class="d-flex justify-content-center stars">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i class="bi bi-star-fill star mx-2" data-value="{{ $i }}" style="color: grey; font-size: 2rem; cursor: pointer;"></i>
                                        @endfor
                                </div>
                                <input type="hidden" name="calificacion" id="input-calificacion-{{ $postulacion->id }}" value="1">
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



    <!-- <=========== Pop-up "Cancelar" ===========> -->
    <div class="modal fade" id="cancelarPostu{{ $postulacion->id }}" tabindex="-1" aria-labelledby="cardModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="card">
                    <div class="card-header fw-bold text-center">
                        Eliminar tu postulación
                    </div>
                    <div class="card-body">
                        <h3 class="card-title">¿Estás seguro de que deseas cancelar tu postulación?</h3>
                        <p class="card-text">Esta acción no se puede deshacer y no podrás aplicar de nuevo a esta oferta.</p>

                        <div class="d-flex justify-content-center">
                            <form action="{{ route('cancelar.postulacion', $postulacion->id) }}" method="POST">
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


    <div class="modal fade" id="modalReportar{{ $postulacion->id }}" tabindex="-1" aria-labelledby="modalReportarLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="card">
                    <div class="card-header fw-bold">
                        Reportar Usuario
                    </div>

                    <div class="card-body">
                        <form action="{{ route('empleado.reportar', $postulacion->empleo_id) }}" method="POST">
                            @csrf

                            <h5 class="card-title d-inline">Usuario:</h5>
                            <span class="card-text">
                                {{ $postulacion->empleo->usuario->nombre }}
                                {{ $postulacion->empleo->usuario->s_nombre }}
                                {{ $postulacion->empleo->usuario->apellido }}
                                {{ $postulacion->empleo->usuario->s_apellido }}
                            </span><br><br>

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

                            <div class="d-flex justify-content-center mt-3">
                                <button type="submit" class="btn btn-danger">Enviar Reporte</button>
                                <button type="button" class="btn btn-secondary mx-2" data-bs-dismiss="modal">Cerrar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @endforeach
</div>
@endif
@stop

<a href="#" class="back-to-top d-flex align-items-center justify-content-center">
    <i class="bi bi-arrow-up-short"></i>
</a>