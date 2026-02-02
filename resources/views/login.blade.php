<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Login - SenaWork</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/mi_logo.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

  <style>
    body {
      background-color: #3bb4f3;
    }

    .card-title {
      color: #00304D;
    }

    p {
      color: #00304D;
    }

    .form-check-label {
      color: #00304D;
    }

    .credits {
      color: #fff;
      align-items: center;
      justify-content: center;
      display: flex;
    }

    .credits- {
      color: #0000;
    }

    .logo img {
      max-height: 60px;
      height: 60px;
    }

    .logo span {
      font-size: 45px
    }

    @media (max-width: 768px) {

      .login-container {
        padding: 20px;
        width: 100%;
        max-width: 400px;
        margin: auto;
      }

      .form-control {
        width: 100%;
        margin-bottom: 10px;
      }

      .btn-primary {
        width: 100%;
        margin-top: 10px;
      }

      .login-title {
        font-size: 1.8em;
        text-align: center;
        margin-bottom: 20px;
      }

      .login-logo {
        display: block;
        margin: 0 auto 20px;
        max-width: 120px;
      }
    }

    @media (max-width: 480px) {

      .login-container {
        padding: 15px;
        width: 100%;
        max-width: 320px;
        margin: auto;
      }

      .form-control {
        width: 100%;
        font-size: 14px;
      }

      .btn-primary {
        font-size: 14px;
      }

      .login-title {
        font-size: 1.5em;
      }

      .login-logo {
        max-width: 100px;
      }
    }
  </style>
</head>

<body>

  <main>
    <div class="container">

      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center ">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

              <div class="d-flex justify-content-center py-3">
                <a class="logo d-flex align-items-center w-auto">
                  <img src="assets/img/mi_logo.png" alt="Logo.">
                  <span class="d-none d-lg-block 1rem">SenaWork</span>
                </a>
              </div><!-- End Logo -->

              <div class="card mb-2">

                <div class="card-body">

                  <div class="pt-2 pb-4">
                    <h5 class="card-title text-center pt-4 pb-0 fs-4">Iniciar Sesión</h5>

                  </div>

                  <form class="row needs-validation g-3" method="POST" action="{{ route('login.proceso') }}" novalidate>
                    @csrf
                    <div class="col-12">
                      <label class="form-label">Correo:</label>
                      <div class="input-group has-validation">
                        <input type="email" name="email" id="email" class="form-control" placeholder="" autofocus required>
                        <div class="invalid-feedback">Por favor introduzca su correo!</div>
                      </div>
                      @error('email')
                      <br>
                      <div class="alert alert-danger">{{ $message }}</div>
                      @enderror
                    </div>

                    <div class="col-12">
                      <label class="form-label ">Contraseña:</label>
                      <input type="password" name="password" id="password" class="form-control" placeholder="" required>
                      <div class="invalid-feedback">Por favor introduzca su contraseña!</div>
                      @error('password')
                      <br>
                      <div class="alert alert-danger">{{ $message }}</div>
                      @enderror
                    </div>

                    <div class="col-12">
                      <br><button class="btn btn-primary w-100" type="submit">Iniciar Sesión</button>
                    </div>
                    <div class="col-10 md-6 pb-2 px-2 mx-4 py-2 text-center">
                      ¿No tienes cuenta?
                      <a class="links" href="{{ url('registro') }}">Crear tu cuenta</a></p>
                    </div>
                  </form>
                </div>
              </div>


              <div class="credits col-10 md-6 pb-4 px-2 mx-4">
                <div class="credits">
                  Desarrollado por el equipo<a href="{{ route('equipo') }}" target="_blank"> A7Dev</a>
                </div>
              </div>

            </div>
          </div>
        </div>

      </section>

    </div>
  </main><!-- End #main -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.umd.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.min.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>