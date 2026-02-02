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
    </style>
</head>

<body>    
    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center">
        <div class="d-flex align-items-center justify-content-between">
            <i class="bi bi-list toggle-sidebar-btn pr-2"></i>

            <a href="{{ route('empleado') }}" class="logo d-flex align-items-center px-3">
                <img src="/assets/img/mi_logo.png" alt="Logo">
                <span class="d-none d-lg-block">SenaWork</span>
            </a>
        </div>

        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">

                <li class="nav-item dropdown">

                    <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
                        <i class="bi bi-bell"></i>
                        <span class="badge bg-primary badge-number"></span>
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
                        <li class="dropdown-header">
                            Tienes 1 notificación
                            <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">Ver todas</span></a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li class="notification-item">
                            <i class="bi bi-exclamation-circle text-warning"></i>
                            <div>
                                <h4>Equipo SenaWork</h4>
                                <p>Próximamente!</p>
                            </div>
                        </li>
                    </ul>
                </li>

                <li class="nav-item dropdown pe-3">
                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#"
                        data-bs-toggle="dropdown">
                        <img src="{{ Auth::user()->foto ? Storage::url(Auth::user()->foto) : asset('assets/img/default_profile_photo.jpg') }}" alt="Profile" class="rounded-circle" style="object-fit: cover;">
                        @auth
                        <span class="d-none d-md-block dropdown-toggle ps-2">{{ Auth::user()->nombre }}</span>
                        @endauth

                    </a>

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="{{ url('perfil') }}">
                                <i class="bi bi-person"></i>
                                <span>Mi Perfil</span>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item d-flex align-items-center"><i class="bi bi-box-arrow-right"></i>Cerrar sesión</button>
                            </form>
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
                <a class="nav-link collapsed" href="{{ route('empleado') }}">
                    <i class="bi bi-house-fill"></i>
                    <span>Inicio</span>
                </a>
            </li>

            @if (Auth::user()->rol_id == 3)
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{ route('mis.empleos') }}">
                    <i class="bi bi-bag-fill"></i>
                    <span>Mis empleos</span>
                </a>
            </li>
            @endif

            @if (Auth::user()->rol_id == 2)
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{ url('postulaciones') }}">
                    <i class="ri-history-fill"></i>
                    <span>Mis postulaciones</span>
                </a>
            </li>
            @endif

            <!-- @if (Auth::user()->rol_id == 2 || Auth::user()->rol_id == 3)
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{ url('puntuaciones') }}">
                    <i class="bi bi-star-fill"></i>
                    <span>Mis puntuaciones</span>
                </a>
            </li>
            @endif -->
        </ul>

        <form action="{{ route('cambiar.rol') }}" method="POST" class="d-inline-block">
            @csrf
            <div class="button-group-container">
                <h6 style="text-align: center;">Cambiar tipo de usuario</h6>
                <div class="btn-group d-flex align-items-bottom" role="group" aria-label="Basic outlined example">

                    <button type="submit" name="rol" value="2"
                        class="btn {{ Auth::user()->rol_id == 2 ? 'btn-light' : 'btn-outline-light' }}">
                        Empleado
                    </button>


                    <button type="submit" name="rol" value="3"
                        class="btn {{ Auth::user()->rol_id == 3 ? 'btn-light' : 'btn-outline-light' }}">
                        Empleador
                    </button>
                </div>
            </div>
        </form>
    </aside>


    <!-- ======= Contenido Principal ======= -->
    <main id="main" class="main bg-gray">
        <div class=" card col-12 bg-white">
            @yield('busqueda')
            <div class="card-body">
                @yield('content')
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