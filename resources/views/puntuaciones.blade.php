@extends('layout')

<title>Mis Puntuaciones - SenaWork</title>
<meta content="" name="description">
<meta content="" name="keywords">

<!-- Favicons -->
<link href="assets/img/mi_logo.png" rel="icon">
<link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

@section('busqueda')
<div class="pagetitle">

    <div class="search-bar">

        <div class="search-form d-flex align-items-center float-start mx-2 m-3">
            <h3>Mis Puntuaciones</h3>
        </div>
        
    </div>

    <div class="col-sm-4 p-3 float-end">
        <form method="POST" action="#">
            <select class="form-select" aria-label="Default select example">
                <option selected disabled>Categorías</option>
                <option value="1">Todo</option>
                <option value="4">Empleados Destacados</option>
                <option value="5">Otros Empleados</option>
                <option value="2">Recientes</option>
                <option value="3">Anteriores</option>

            </select>
        </form>
    </div>
</div>
<hr>

@stop

@section('content')
<div class="pagetitle pt-4">
    <h1>Perfil del Empleado</h1>
</div>
<section class="section profile">
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Empleados Destacados</h5>
                    <div class="d-flex align-items-center">
                        <img src="/assets/img/profile-img.jpg" alt="Especialista" class="rounded-circle me-3" style="width: 100px; height: 100px;">
                        <div>
                            <h4>Jorge Luis Florez</h4>
                            <div class="star-rating">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4">
                        <h5>Agregar Comentario</h5>
                        <form>
                            <div class="mb-3">
                                <label for="comment" class="form-label">Comentario</label>
                                <textarea class="form-control" id="comment" rows="3"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Enviar</button>
                        </form>
                    </div>
                    <div class="mt-4">
                        <h5>Reseñas</h5>
                        <div class="list-group">
                            <div class="list-group-item">
                                <h6>Dieguillo el pillo</h6>
                                <p>Excelente servicio, muy profesional.</p>
                            </div>
                            <div class="list-group-item">
                                <h6>Daniel el travieso</h6>
                                <p>Muy puntual y eficiente.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Otros Empleados</h5>
                    <div class="specialist-card">
                        <div class="d-flex align-items-center">
                            <img src="/assets/img/profile-img.jpg" alt="Especialista" class="rounded-circle me-3" style="width: 50px; height: 50px;">
                            <div>
                                <h6>Sergio el orlando</h6>
                                <div class="star-rating">
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                </div>
                                <p>Entrega rapida y eficiente, pero me faltaba un pedazo de pizza</p>
                            </div>
                        </div>
                    </div>
                    <div class="specialist-card">
                        <div class="d-flex align-items-center">
                            <img src="/assets/img/profile-img.jpg" alt="Especialista" class="rounded-circle me-3" style="width: 50px; height: 50px;">
                            <div>
                                <h6>Felipe Betancourt</h6>
                                <div class="star-rating">
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                </div>
                                <p>Llegada puntual, pero se las da de canino</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
@stop

<a href="#" class="back-to-top d-flex align-items-center justify-content-center">
    <i class="bi bi-arrow-up-short"></i>
</a>