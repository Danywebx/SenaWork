@extends('layout')

<title>Empleados - SenaWork</title>
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
        min-height: 430px;
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
        <h3>Empleados disponibles</h3>
    </div>

    <form class="d-flex align-items-center float-end m-2" method="GET" action="{{ route('buscar.usuarios') }}">
        <input type="text" name="query" id="query" class="form-control w-100 mb-1 mb-md-0 mx-1" placeholder="Buscar">
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

@if($usuarios->isEmpty())
<p>No se encontraron usuarios según los filtros aplicados.</p>
@else
<div class="row col-12">
    @foreach($usuarios as $usuario)
    <div class="col-lg-3 py-2">
        <a data-bs-toggle="modal" data-bs-target="#verUsuario{{ $usuario->id }}" class="text-decoration-none text-dark">
            <div class="bg-white" style="cursor: pointer;" id="empleos">
                <div class="d-flex justify-content-center align-items-center">
                    <img src="{{ $usuario->foto ? Storage::url($usuario->foto) : asset('assets/img/default_profile_photo.jpg') }}"
                        alt="Foto de perfil de {{ $usuario->nombre }}"
                        class="rounded-circle d-flex" width="140" height="140" style="object-fit: cover;">
                </div>

                <h4 class="fw-bold mt-3" style="color: #00304D; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                    <span title="{{ $usuario->nombre }} {{ $usuario->s_nombre }} {{ $usuario->apellido }} {{ $usuario->s_apellido }}">
                        {{ \Illuminate\Support\Str::limit($usuario->nombre . ' ' . $usuario->apellido, 12, '...') }}
                    </span>
                </h4>

                <h6 class="fw-bold" style="color: #00304D;">{{ $usuario->categoria->nombre }} </h6><br>

                <p style="color: #00304D;">Calificación:<br></p>
                <div class="star-rating">
                    <p style="color: #00304D;">
                        {{ $usuario->prom_puntuaciones }}
                        @for ($i = 1; $i <= 5; $i++)
                            @if ($i <=$usuario->prom_puntuaciones)
                            <i class="bi bi-star-fill" style="color: gold;"></i>
                            @else
                            <i class="bi bi-star" style="color: grey;"></i>
                            @endif
                            @endfor
                    </p>
                </div>

                <form class="btn-content pt-3" action="#" method="POST">
                    <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#verUsuario{{ $usuario->id }}">Ver</a>
                </form>
            </div>
        </a>
    </div>

    <!-- <=========== Pop-up "VerEmpleado"===========> -->
    <div class="modal fade" id="verUsuario{{ $usuario->id }}" tabindex="-1" aria-labelledby="cardModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="card">
                    <div class="card-header fw-bold">
                        Información del usuario
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-center align-items-center">
                            <img src="{{ $usuario->foto ? Storage::url($usuario->foto) : asset('assets/img/default_profile_photo.jpg') }}"
                                alt="Foto de perfil de {{ $usuario->nombre }}"
                                class="rounded-circle d-flex" width="140" height="140" style="object-fit: cover;">
                        </div><br><br>
                        <h5 class="card-title d-inline">Nombre: </h5><span class="card-text">
                            {{ $usuario->nombre }}
                            @if ($usuario->s_nombre)
                            {{ $usuario->s_nombre }}
                            @endif
                            {{ $usuario->apellido }}
                            {{ $usuario->s_apellido }}
                        </span><br><br>
                        <h5 class="card-title d-inline">Categoría: </h5><span class="card-text">{{ $usuario->categoria->nombre }}</span><br><br>
                        <h5 class="card-title d-inline">Puntuación: </h5><span class="card-text">
                            {{ $usuario->prom_puntuaciones }}
                            @for ($i = 1; $i <= 5; $i++)
                                @if ($i <=$usuario->prom_puntuaciones)
                                <i class="bi bi-star-fill" style="color: gold;"></i>
                                @else
                                <i class="bi bi-star" style="color: grey;"></i>
                                @endif
                                @endfor
                        </span><br><br><br>

                        <div class="d-flex justify-content-center">
                            @if (!$documentosCompletos)
                            <a href="{{ route('perfil') }}" class="btn btn-success">Contactar</a>
                            @else
                            <a class="btn btn-success" data-bs-toggle="modal" data-bs-target="#verContacto">Contactar</a>
                            @endif
                            <button type="button" class="btn btn-secondary mx-2" data-bs-dismiss="modal">Cerrar</button>
                        </div>
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
    @endforeach
</div>
@endif
@stop



<a href="#" class="back-to-top d-flex align-items-center justify-content-center">
    <i class="bi bi-arrow-up-short"></i>
</a>