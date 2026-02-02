@extends('layout')

<title>Crear Empleo - SenaWork</title>
<meta content="" name="description">
<meta content="" name="keywords">

<!-- Favicons -->
<link href="assets/img/mi_logo.png" rel="icon">
<link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

@section('content')
<div class="row">
    <div class="card-body">

        <div class="pagetitle mb-1">
            <a href="{{ route('mis.empleos') }}" class="btn btn-danger float-end mt-1">
                <i class="mdi mdi-plus ri ri-arrow-go-back-fill"></i>
                Volver
            </a>
            <h5 class="card-title">Detalles del Empleo</h5>
        </div>

        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form class="row needs-validation" action="{{ route('empleo.proceso') }}" method="POST" enctype="multipart/form-data" novalidate>
            @csrf
            <div class="col-6 mb-3">
                <label for="inputText" class="col-sm-12 col-form-label text-black-50">Nombre del empleo:</label>
                <div class="col-sm-12">
                    <input type="text" name="nombre_empleo" id="nombre_empleo" value="{{ old('nombre_empleo') }}" class="form-control" maxlength="150" required autofocus>
                    <div class="invalid-feedback">Por favor ingrese el nombre!</div>
                </div>
            </div>

            <div class="col-6 mb-3">
                <label for="inputText" class="col-sm-12 col-form-label text-black-50">Categoría:</label>
                <div class="col-sm-12">
                    <select name="categoria" id="categoria" class="form-control" required>
                        <option value="" disabled selected>Seleccione...</option>
                        @foreach($categorias as $categoria)
                        <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback">Por favor ingrese la categoría!</div>
                </div>
            </div>

            <div class="col-6 mb-3">
                <label for="inputText" class="col-sm-12 col-form-label text-black-50">Ubicación:</label>
                <div class="col-sm-12">
                    <input type="text" name="ubicacion" id="ubicacion" value="{{ old('ubicacion') }}" class="form-control" maxlength="100" required>
                    <div class="invalid-feedback">Por favor ingrese la ubicación!</div>
                </div>
            </div>

            <div class="col-6 mb-3">
                <label for="fotos" class="col-sm-12 col-form-label text-black-50">Fotos:</label>
                <div class="col-sm-12">
                    <input type="file" name="fotos[]" id="fotos" class="form-control" accept="image/*" multiple>
                </div>
            </div>

            <script>
                document.getElementById('fotos').addEventListener('change', function() {
                    if (this.files.length > 3) {
                        alert('Solo puedes subir un máximo de 3 imágenes.');
                        this.value = '';
                    }
                });
            </script>

            <div class="col-6 mb-3">
                <label for="inputText" class="col-sm-12 col-form-label text-black-50">Descripción:</label>
                <div class="col-sm-12">
                    <textarea name="descripcion" id="descripcion" style="height: 10px;" class="form-control" maxlength="500" required></textarea>
                    <div class="invalid-feedback">Por favor ingrese la descripción!</div>
                </div>
            </div>

            <div class="col-12 mb-3">
                <label class="col-sm-2 col-form-label"></label>
                <div class="col-sm-3">
                    <button type="submit" class="btn btn-primary col-12">Enviar</button>
                </div>
            </div>
        </form>
    </div>
</div>
@stop