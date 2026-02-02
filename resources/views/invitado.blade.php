<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">


    <title>SenaWork</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="assets/img/mi_logo.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="/assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="/assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="/assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="/assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="/assets/vendor/simple-datatables/style.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="/assets/css/style.css" rel="stylesheet">

    <!-- Lightbox CSS -->
    <link href="https://cdn.jsdelivr.net/npm/lightbox2@2.11.3/dist/css/lightbox.min.css" rel="stylesheet">

    @yield('styles')

    <style>
        .button-group-container {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 1rem;
            background-color: inherit;
            border-top: 1px solid #e9ecef;
            color: #fff;
        }

        .form-check-input:checked {
            background-color: #263850;
            border-color: #263850;
        }

        .footer-credits {
            color: #fff;
        }

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
</head>

<body>
    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center">
        <div class="d-flex align-items-center justify-content-between">
            <i class="bi bi-list toggle-sidebar-btn pr-2"></i>

            <a href="{{ route('invitado') }}" class="logo d-flex align-items-center px-3">
                <img src="/assets/img/mi_logo.png" alt="Logo">
                <span class="d-none d-lg-block">SenaWork</span>
            </a>
        </div>

        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">

                <li class="d-flex justify-content-center mx-2">
                    <a class="nav-link nav-profile d-flex align-items-center pe-0 mx-1 fw-bold" href="{{ route('login') }}">Iniciar sesión</a>
                    <a class="nav-link nav-profile d-flex align-items-center pe-0 mx-1 fw-bold" href="{{ route('registro') }}">Registrarse</a>
                </li>

                <li class="nav-item dropdown pe-3">
                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#"
                        data-bs-toggle="dropdown">
                        <img src="assets/img/default_profile_photo.jpg" alt="Profile" class="rounded-circle" style="object-fit: cover;">
                        <span class="d-none d-md-block dropdown-toggle ps-2 fw-bold">Invitado</span>
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="{{ route('login') }}">
                                <i class="bi bi-person"></i>
                                <span>Mi Perfil</span>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a href="{{ route('login') }}" class="dropdown-item d-flex align-items-center"><i class="bi bi-box-arrow-right"></i>Cerrar sesión</a>
                        </li>
                    </ul>
                </li>

            </ul>
        </nav>

    </header>


    <!-- ======= Menú Hamburguesa ======= -->
    <aside id="sidebar" class="sidebar">

        <ul class="sidebar-nav" id="sidebar-nav">
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{ route('invitado') }}">
                    <i class="bi bi-house-fill"></i>
                    <span>Inicio</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="{{ route('login') }}">
                    <i class="bi bi-bag-fill"></i>
                    <span>Mis empleos</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="{{ route('login') }}">
                    <i class="ri-history-fill"></i>
                    <span>Mis postulaciones</span>
                </a>
            </li>    
        </ul>

        <form action="{{ route('login') }}" method="GET" class="d-inline-block">
            @csrf
            <div class="button-group-container">
                <h6 style="text-align: center;">Cambiar tipo de usuario</h6>
                <div class="btn-group d-flex align-items-bottom" role="group" aria-label="Basic outlined example">

                    <a href="{{ route('login') }}" name="rol" value=""
                        class="btn btn-light">
                        Empleado
                    </a>


                    <a href="{{ route('login') }}" name="rol" value=""
                        class="btn btn-outline-light">
                        Empleador
                    </a>
                </div>
            </div>
        </form>
    </aside>


    <!-- ======= Contenido Principal ======= -->
    <main id="main" class="main bg-gray">
        <div class=" card col-12 bg-white">


            <div class="pagetitle">

                <div class="d-flex align-items-center float-start mx-3 m-3">
                    <h3>Empleos disponibles</h3>
                </div>

                <form class="d-flex align-items-center float-end m-2" method="GET" action="{{ route('buscar.invitado') }}">
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


            <div class="card-body">

                <div>
                    <form class="d-flex float-end" method="" action="#">
                        <a href="{{ route('login') }}" class="btn btn-primary w-100">
                            <i class="mdi mdi-plus bi bi-bag-plus-fill"></i>
                            Crear Empleo
                        </a>
                    </form>
                </div>

                @if($empleos->isEmpty())
                <p>No se encontraron resultados para su búsqueda.</p>
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
                                <p style="color: #00304D;">Apertura: {{ $empleo->fecha_creacion->format('d/m/Y') }}</p>
                                <p style="color: #00304D;">Cierre: {{ $empleo->fecha_cierre->format('d/m/Y') }}</p>
                                <form class="btn-content pt-1" action="#" method="GET">
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
                                            <a href="{{ route('login') }}" class="btn btn-primary">Aplicar</a>
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
            </div>
        </div>
    </main>


    <!-- ======= Footer ======= -->
    <footer id="footer" class="footer">
        <div class="credits col-10 md-6 pb-4 px-2 mx-4">
            <div class="credits">
                Desarrollado por el equipo <a href="{{ route('equipo') }}" target="_blank">A7Dev</a>
            </div>
        </div>
    </footer>


    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- ======= Vendor JS Files ======= -->
    <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/chart.js/chart.umd.js"></script>
    <script src="assets/vendor/echarts/echarts.min.js"></script>
    <script src="assets/vendor/quill/quill.min.js"></script>
    <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
    <script src="assets/vendor/tinymce/tinymce.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>
    <script src="assets/js/main.js"></script>

    <!-- Lightbox JS -->
    <script src="https://cdn.jsdelivr.net/npm/lightbox2@2.11.3/dist/js/lightbox.min.js"></script>

    @yield('js')
</body>

</html>