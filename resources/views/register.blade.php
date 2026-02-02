<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Registro - SenaWork</title>
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

      .register-container {
        padding: 20px;
        width: 100%;
        max-width: 400px;
        margin: auto;
      }

      .form-control {
        width: 100%;
        margin-bottom: 10px;
      }

      .btn-primary,
      .btn-secondary {
        width: 100%;
        margin-top: 10px;
      }

      .register-title {
        font-size: 1.8em;
        text-align: center;
        margin-bottom: 20px;
      }

      .register-logo {
        display: block;
        margin: 0 auto 20px;
        max-width: 120px;
      }
    }

    @media (max-width: 480px) {

      .register-container {
        padding: 15px;
        width: 100%;
        max-width: 320px;
        margin: auto;
      }

      .form-control {
        width: 100%;
        font-size: 14px;
      }

      .btn-primary,
      .btn-secondary {
        font-size: 14px;
      }

      .register-title {
        font-size: 1.5em;
      }

      .register-logo {
        max-width: 100px;
      }
    }
  </style>
</head>

<body>
  <main>
    <div class="container">
      <div class="container">
        <div class="row justify-content-center">
          <div class="d-flex flex-column align-items-center justify-content-center">

            <div class="d-flex justify-content-center py-4">
              <a class="logo d-flex align-items-center w-auto">
                <img src="assets/img/mi_logo.png" alt="Logo.">
                <span class="d-none d-lg-block">SenaWork</span>
              </a>
            </div><!-- End Logo -->

            <div class="card mb-3">

              <div class="card-body">

                <div class="pt-4 pb-2">
                  <h5 class="card-title text-center pb-0 fs-4">Crear cuenta</h5>
                  <p class="text-center small">Ingresa tus datos para crear una cuenta</p>
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

                <div id="registro-form">
                  <form class="row needs-validation mx-5" method="POST" action="{{ route('registro.proceso') }}" novalidate>
                    @csrf
                    <div class="col-6 mb-3">
                      <label for="nombres" class="form-label">Nombres:</label>
                      <input type="text" name="nombres" class="form-control" id="nombres" placeholder="" value="{{ old('nombres') }}" required autofocus>
                      <div class="invalid-feedback">Por favor ingrese sus nombres completos!</div>
                    </div>

                    <div class="col-6 mb-3">
                      <label for="apellidos" class="form-label">Apellidos:</label>
                      <input type="text" name="apellidos" class="form-control" id="apellidos" placeholder="" value="{{ old('apellidos') }}" required>
                      <div class="invalid-feedback">Por favor ingrese sus apellidos completos!</div>
                    </div>

                    <div class="col-6 mb-3">
                      <label for="inputText" class="form-label">Tipo de documento: </label>
                      <div class="col-sm-12">
                        <select name="tipo_documento" id="tipo_documento" class="form-control" required>
                          <option value="" disabled selected>Seleccione...</option>
                          <option value="Cédula de ciudadanía">Cédula de ciudadanía</option>
                          <option value="Cédula de extranjería">Cédula de extranjería</option>
                        </select>
                        <div class="invalid-feedback">Por favor ingrese su tipo de documento!</div>
                      </div>
                    </div>

                    <div class="col-6 mb-3">
                      <label for="numero_documento" class="form-label">Número de documento: </label>
                      <input type="number" name="numero_documento" class="form-control" id="numero_documento" minlength="9" maxlength="10" placeholder="" value="{{ old('numero_documento') }}" required>
                      <div class="invalid-feedback">Por favor ingrese su número de documento!</div>
                    </div>

                    <script>
                      const inputDocumento = document.getElementById('numero_documento');

                      inputDocumento.addEventListener('input', function(e) {
                        if (this.value.length > 10) {
                          this.value = this.value.slice(0, 10);
                        }
                      });

                      inputDocumento.addEventListener('keydown', function(e) {
                        if (e.key === 'e' || e.key === '-' || e.key === '+' || e.key === '.' || e.key === ',' || e.key.length > 1 && e.key !== 'Backspace' && e.key !== 'ArrowLeft' && e.key !== 'ArrowRight') {
                          e.preventDefault();
                        }
                      });

                      inputDocumento.addEventListener('blur', function() {
                        if (this.value.length < 9) {
                          this.setCustomValidity('El número de documento debe tener entre 9 y 10 dígitos');
                        } else {
                          this.setCustomValidity('');
                        }
                      });
                    </script>

                    <div class="col-6 mb-3">
                      <label for="inputDate" class="col-sm-12 col-form-label">Fecha de nacimiento: </label>
                      <div class="col-sm-12">
                        <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" class="form-control " value="{{ old('fecha_nacimiento') }}" required>
                        <div class="invalid-feedback">Por favor ingrese su fecha de nacimiento!</div>
                      </div>
                    </div>

                    <script>
                      document.addEventListener('DOMContentLoaded', function() {
                        var today = new Date();

                        var maxDate = new Date(today.getFullYear() - 18, today.getMonth(), today.getDate());

                        var minDate = new Date(today.getFullYear() - 100, today.getMonth(), today.getDate());

                        var formattedMaxDate = maxDate.toISOString().split('T')[0];
                        var formattedMinDate = minDate.toISOString().split('T')[0];

                        document.getElementById('fecha_nacimiento').setAttribute('max', formattedMaxDate);
                        document.getElementById('fecha_nacimiento').setAttribute('min', formattedMinDate);
                      });
                    </script>

                    <div class="col-6 mb-3">
                      <label for="celular" class="form-label">Celular: </label>
                      <input type="number" name="celular" class="form-control" id="celular" minlength="10" maxlength="10" pattern="[0-9]{10}" placeholder="" value="{{ old('celular') }}" required>
                      <div class="invalid-feedback">Por favor ingrese su número de contacto!</div>
                    </div>

                    <script>
                      const inputCelular = document.getElementById('celular');

                      inputCelular.addEventListener('input', function(e) {
                        if (this.value.length > 10) {
                          this.value = this.value.slice(0, 10);
                        }
                      });

                      inputCelular.addEventListener('keydown', function(e) {
                        if (e.key === 'e' || e.key === '-' || e.key === '+' || e.key === '.' || e.key === ',' || e.key.length > 1 && e.key !== 'Backspace' && e.key !== 'ArrowLeft' && e.key !== 'ArrowRight') {
                          e.preventDefault();
                        }
                      });
                    </script>

                    <div class="col-6 mb-3">
                      <label for="yourPassword" class="form-label">Dirección: </label>
                      <input type="text" name="direccion" class="form-control" id="direccion" placeholder="" value="{{ old('direccion') }}" required>
                      <div class="invalid-feedback">Por favor ingrese su dirección!</div>
                    </div>

                    <div class="col-6 mb-3">
                      <label for="yourEmail" class="form-label">Correo: </label>
                      <input type="email" name="email" class="form-control" id="email" placeholder="" value="{{ old('email') }}" required>
                      <div class="invalid-feedback">Por favor ingrese su correo electrónico!</div>
                    </div>

                    <div class="col-6 mb-3">
                      <label for="yourPassword" class="form-label">Contraseña: </label>
                      <input type="password" name="password" class="form-control" id="password" placeholder="" minlength="8" required>
                      <div class="invalid-feedback">Por favor ingrese su contraseña!</div>
                    </div>

                    <div class="col-6 mb-3">
                      <label for="yourPassword" class="form-label">Confirmar contraseña: </label>
                      <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" placeholder="" minlength="8" required>
                      <div class="invalid-feedback">Por favor ingrese su contraseña!</div>
                    </div>

                    <div class="col-6 mb-3">
                      <label for="inputText" class="form-label">Categoría: </label>
                      <div class="col-sm-12">
                        <select name="categoria" id="categoria" class="form-control" required>
                          <option value="" disabled selected>Seleccione...</option>
                          @foreach($categorias as $categoria)
                          <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                          @endforeach
                        </select>
                        <div class="invalid-feedback">Por favor ingrese su categoría!</div>
                      </div>
                    </div>

                    <div class="col-6 mb-3">
                      <label class="form-label text-left">¿Cómo deseas iniciar?:</label>
                      <div class="d-flex align-items-center">
                        <div class="form-check me-3 my-2">
                          <input class="form-check-input" type="checkbox" name="rol" value="2" id="empleadoCheck">
                          <label class="form-check-label" for="empleadoCheck">
                            Empleado
                          </label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" name="rol" value="3" id="empleadorCheck">
                          <label class="form-check-label" for="empleadorCheck">
                            Empleador
                          </label>
                        </div>
                      </div>
                      <div class="invalid-feedback">Por favor selecciona tu rol!</div>
                    </div>


                    <script>
                      const empleadoCheck = document.getElementById('empleadoCheck');
                      const empleadorCheck = document.getElementById('empleadorCheck');

                      empleadoCheck.addEventListener('change', function() {
                        if (empleadoCheck.checked) {
                          empleadorCheck.checked = false;
                        }
                      });

                      empleadorCheck.addEventListener('change', function() {
                        if (empleadorCheck.checked) {
                          empleadoCheck.checked = false;
                        }
                      });
                    </script>

                    <div class="col-12">
                      <input type="checkbox" name="terms" id="terms" class="form-check-input" {{ old('terms') ? 'checked' : '' }} required>
                      <label class="form-check-label" for="terms">
                        Acepto los <a href="#">términos y condiciones</a>
                      </label>
                    </div><br><br>

                    <div class="col-12 mb-3">
                      <button class="btn btn-primary w-100" type="submit">Crear cuenta</button>
                    </div>

                    <div class="col-12 md-6 pb-2 px-2 mx-4 py-2 text-center">
                      ¿Ya tienes una cuenta?
                      <a href="{{ url('login') }}">Iniciar sesión</a>
                    </div>
                  </form>
                </div>
              </div>
            </div>

            <div class="credits mb-3">
              Desarrollado por el equipo <a href="{{ route('equipo') }}" target="_blank">A7Dev</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
  <!-- End #main -->

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