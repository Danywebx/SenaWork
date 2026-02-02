@extends('layout')

<title>Empleos - SenaWork</title>
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
        min-height: 320px;
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

    <div class="d-flex align-items-center float-start mx-3 m-3">
        <h3>Empleos disponibles</h3>
    </div>

    <form class="d-flex align-items-center float-end m-2" method="GET" action="{{ route('buscar.empleos') }}">
        @csrf
        <input type="text" name="query" class="form-control w-100 mb-1 mb-md-0 mx-1" placeholder="Buscar">
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

<div class="d-flex align-items-center justify-content-end">
    <a class="nav-link d-flex align-items-center" href="javascript:void(0);">
        <i class="{{ Auth::user()->estado_perfil == 1 ? 'ri-eye-fill' : 'ri-eye-off-fill' }}" id="icono-perfil" style="font-size: 1.5rem; margin-right: 5px;"></i>
        <span style="margin-right: 10px;">Estado perfil</span>

        <div class="form-check form-switch">
            <input class="form-check-input" style="cursor:pointer" type="checkbox" id="flexSwitchCheckChecked"
                {{ Auth::user()->estado_perfil == 1 ? 'checked' : '' }}
                onchange="cambiarEstadoPerfil()">
        </div>
    </a>
</div><br>

<script>
    function cambiarEstadoPerfil() {
        let switchElement = document.getElementById('flexSwitchCheckChecked');
        let nuevoEstado = switchElement.checked ? 1 : 0;

        let iconoPerfil = document.getElementById('icono-perfil');
        if (nuevoEstado == 1) {
            iconoPerfil.className = 'ri-eye-fill';
        } else {
            iconoPerfil.className = 'ri-eye-off-fill';
        }

        fetch('{{ route("cambiar.estado") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    estado_perfil: nuevoEstado,
                }),
            })
            .then(response => response.json())
            .then(data => {
                if (!data.success) {
                    switchElement.checked = !switchElement.checked;
                    iconoPerfil.className = switchElement.checked ? 'ri-eye-fill' : 'ri-eye-off-fill';
                }
            });
    }
</script>

@if($empleos->isEmpty())
<p>No se encontraron resultados para su búsqueda.</p>
@else
<div class="row col-12">
    @foreach($empleos as $empleo)
    <div class="col-lg-3 my-2">
        <a data-bs-toggle="modal" data-bs-target="#verEmpleos{{ $empleo->id }}" class="text-decoration-none text-dark">
            <div class="bg-white" style="cursor: pointer;" id="empleos">
                <h4 class="fw-bold mt-3" style="color: #00304D;">
                    <span title="{{ $empleo->nombre }}">
                        {{ \Illuminate\Support\Str::limit($empleo->nombre, 21, '...') }}
                    </span>
                </h4>
                <h6 class="fw-bold" style="color: #00304D;">{{ $empleo->categoria->nombre }}</h6><br>
                <p style="color: #00304D;">Apertura: {{ $empleo->fecha_creacion->format('d/m/Y') }}</p>
                <p style="color: #00304D;">Cierre: {{ $empleo->fecha_cierre->format('d/m/Y') }}</p>
                <form class="btn-content pt-3" action="#" method="POST">
                    <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#verEmpleos{{ $empleo->id }}">Ver - Aplicar</a>
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
                        @if (!$documentosCompletos)
                        <a href="{{ route('perfil') }}" class="btn btn-danger float-end"><i class="bi bi-exclamation-octagon"></i></a>
                        @else
                        <button type="button" class="btn btn-danger float-end" data-bs-toggle="modal" data-bs-target="#reporteModal{{ $empleo->id }}"><i class="bi bi-exclamation-octagon"></i></button>
                        @endif
                        <br>
                        <h5 class="card-title d-inline">Servicio: </h5><span class="card-text"> {{ $empleo->nombre }} </span><br><br>
                        <h5 class="card-title d-inline">Categoría: </h5><span class="card-text"> {{ $empleo->categoria->nombre }} </span><br><br>
                        <h5 class="card-title d-inline">Publicado por: </h5>
                        <span class="card-text">
                            {{ $empleo->usuario->nombre }}
                            @if ($empleo->usuario->s_nombre)
                            {{ $empleo->usuario->s_nombre }}
                            @endif
                            {{ $empleo->usuario->apellido }}
                            @if ($empleo->usuario->s_apellido)
                            {{ $empleo->usuario->s_apellido }}
                            @endif
                        </span><br><br>
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
                            @if (!$documentosCompletos)
                            <a href="{{ route('perfil') }}" class="btn btn-primary">Aplicar</a>
                            @else
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#confirmAplicar{{ $empleo->id }}">Aplicar</button>
                            @endif
                            <button type="button" class="btn btn-secondary mx-2" data-bs-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Confirmación de Aplicación -->
    <div class="modal fade" id="confirmAplicar{{ $empleo->id }}" tabindex="-1" aria-labelledby="confirmAplicarLabel{{ $empleo->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="card">
                    <div class="card-header fw-bold">
                        Confirmación de aplicación
                    </div>
                    <div class="card-body">
                        @if ($empleo->postulaciones->where('usuario_id', Auth::user()->id)->isEmpty())
                        <p style="text-align: center;">¿Estás seguro que deseas aplicar a este empleo?</p>
                        <form method="POST" action="{{ route('empleado.aplicar', ['id' => $empleo->id]) }}">
                            @csrf
                            <div class="d-flex justify-content-center">
                                <button type="submit" class="btn btn-primary mx-2">Confirmar</button>
                                <button type="button" class="btn btn-secondary mx-2" data-bs-dismiss="modal">Cancelar</button>
                            </div>
                        </form>
                        @else
                        <p style="text-align: center;">Ya has aplicado a este empleo</p>
                        <div class="d-flex justify-content-center">
                            <button type="button" class="btn btn-secondary mx-2" data-bs-dismiss="modal">Cerrar</button>
                        </div>
                        @endif
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
                        Reporte de empleo
                    </div>

                    <div class="card-body">
                        <form action="{{ route('empleo.reporte', $empleo->id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="empleo_id" value="{{ $empleo->id }}">
                            <input type="hidden" name="notificador_id" value="{{ Auth::user()->id }}">
                            <input type="hidden" name="tipo_reporte" value="Empleo">

                            <h5 class="card-title d-inline">Servicio: </h5>
                            <span class="card-text"> {{ $empleo->nombre }} </span><br><br>

                            <h5 class="card-title d-inline">Categoría: </h5>
                            <span class="card-text"> {{ $empleo->categoria->nombre }} </span><br><br>

                            <h5 class="card-title d-inline">Publicado por: </h5>
                            <span class="card-text">
                                {{ $empleo->usuario->nombre }}
                                @if ($empleo->usuario->s_nombre)
                                {{ $empleo->usuario->s_nombre }}
                                @endif
                                {{ $empleo->usuario->apellido }}
                                @if ($empleo->usuario->s_apellido)
                                {{ $empleo->usuario->s_apellido }}
                                @endif
                            </span><br><br>

                            <h5 class="card-title d-inline">Descripción: </h5>
                            <span class="card-text"> {{ $empleo->descripcion }} </span><br><br>

                            <h5 class="card-title d-inline">Motivo: </h5>
                            <select name="motivo" id="motivo" class="form-select w-100 mx-1" aria-label="Default select example" required>
                                <option selected disabled>Seleccione...</option>
                                <option value="informacion_falsa">Información falsa o engañosa</option>
                                <option value="fraude">Sospecha de fraude o estafa</option>
                                <option value="discriminacion">Discriminación en los requisitos</option>
                                <option value="contenido_inapropiado">Contenido inapropiado o ofensivo</option>
                                <option value="condiciones_injustas">Condiciones laborales injustas</option>
                                <option value="publicacion_repetida">Publicación repetida o spam</option>
                                <option value="otro">Otro (especificar)</option>
                            </select><br>

                            <h5 class="card-title d-inline">Comentario:</h5>
                            <textarea name="comentario" class="form-control" rows="4" placeholder="Describe el motivo del reporte..." required></textarea>
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
    @endforeach
</div>
@endif
@stop

<a href="#" class="back-to-top d-flex align-items-center justify-content-center">
    <i class="bi bi-arrow-up-short"></i>
</a>