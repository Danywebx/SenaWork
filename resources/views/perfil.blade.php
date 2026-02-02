@extends('layout')

<title>Mi Perfil - SenaWork</title>
<meta content="" name="description">
<meta content="" name="keywords">

<!-- Favicons -->
<link href="assets/img/mi_logo.png" rel="icon">
<link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

@section('content')

<body>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle me-1"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        @foreach ($errors->all() as $error)
        <i class="bi bi-exclamation-octagon me-1"></i>
        {{ $error }}
        @endforeach
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if(!$documentosCompletos)
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-triangle me-1"></i>
        Debes completar tu perfil subiendo los documentos.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="card-body pt-4">

        <div class="pagetitle">
            <h1>Mi perfil</h1>
        </div>


        <!-- ======= Foto de perfil ======= -->
        <section class="section profile">
            <div class="row">
                <div class="col-xl-4">
                    <div class="card">
                        <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

                            <img src="{{ Auth::user()->foto ? Storage::url(Auth::user()->foto) : asset('assets/img/default_profile_photo.jpg') }}" alt="Profile" class="rounded-circle" style="object-fit: cover;">

                            <h2 class="text-center">{{ Auth::user()->nombre }} {{ Auth::user()->s_nombre }} {{ Auth::user()->apellido }} {{ Auth::user()->s_apellido }}</h2>
                        </div>
                    </div>
                </div>
                <!-- ======= End Foto de perfil ======= -->


                <!-- ======= Mi perfil ======= -->
                <div class="col-xl-8">
                    <div class="card">
                        <div class="card-body pt-3">
                            <ul class="nav nav-tabs nav-tabs-bordered">

                                <li class="nav-item">
                                    <button class="nav-link active" data-bs-toggle="tab"
                                        data-bs-target="#profile-overview">Mi perfil</button>
                                </li>

                                <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Editar
                                        Perfil</button>
                                </li>

                                <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="tab"
                                        data-bs-target="#profile-change-password">Cambiar contraseña</button>
                                </li>
                            </ul>

                            <div class="tab-content pt-2">
                                <div class="tab-pane fade show active profile-overview" id="profile-overview">

                                    <div class="">
                                        <br>
                                        <div class="row">
                                            <div class="col-lg-4 col-md-4 label ">Nombre: </div>
                                            <div class="col-lg-8 col-md-8">{{ Auth::user()->nombre }} {{ Auth::user()->s_nombre }} {{ Auth::user()->apellido }} {{ Auth::user()->s_apellido }} </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-4 col-md-4 label">Correo: </div>
                                            <div class="col-lg-8 col-md-8">{{ Auth::user()->correo }}</div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-4 col-md-4 label">Celular: </div>
                                            <div class="col-lg-8 col-md-8">{{ Auth::user()->telefono }}</div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-4 col-md-4 label">Dirección: </div>
                                            <div class="col-lg-8 col-md-8">{{ Auth::user()->direccion }}</div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-4 col-md-4 label">Puntuación:</div>
                                            <div class="col-lg-8 col-md-8">
                                                {{ Auth::user()->prom_puntuaciones }}
                                                @for ($i = 1; $i <= 5; $i++)
                                                    @if ($i <=Auth::user()->prom_puntuaciones)
                                                    <i class="bi bi-star-fill" style="color: gold;"></i>
                                                    @else
                                                    <i class="bi bi-star" style="color: grey;"></i>
                                                    @endif
                                                    @endfor
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-4 col-md-4 label">Documento: </div>
                                            <div class="col-lg-8 col-md-8">{{ Auth::user()->t_documento }} - {{ Auth::user()->n_documento }}</div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-4 col-md-4 label">Mi portafolio: </div>
                                            <div class="col-lg-8 col-md-8">
                                                @if ($documento = \App\Models\Documento::where('usuario_id', Auth::user()->id)->where('tipo', 'portafolio')->first())
                                                <a href="{{ route('descargar.miportafolio') }}" class="">portafolio.pdf</a>
                                                @else
                                                <span>No se ha encontrado ningún portafolio.</span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-4 col-md-4 label">Especialidad: </div>
                                            <div class="col-lg-8 col-md-8"> {{ $categoria->nombre }} </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-4 col-md-4 label">Fecha de nacimiento: </div>
                                            <div class="col-lg-8 col-md-8">{{ Auth::user()->fecha_nacimiento->format('d/m/Y') }}</div>
                                        </div><br>

                                        <div class="text-center">
                                            @if (!$documentosCompletos)
                                            <button type="submit" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#cardModal1">Completar perfil</button>
                                            @endif
                                            <a class="btn btn-danger" data-bs-toggle="modal"
                                                data-bs-target="#eliminarCuenta">
                                                <i class="bi bi-trash"></i>
                                                <span>Eliminar cuenta</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>


                                <!-- Pop-up "Eliminar" -->
                                <div class="modal fade" id="eliminarCuenta" tabindex="-1" aria-labelledby="eliminarCuenta" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="card">
                                                <div class="card-header fw-bold text-center">
                                                    Eliminar cuenta
                                                </div>
                                                <div class="card-body">
                                                    <h3 class="card-title text-center">¿Estás seguro de que deseas eliminar tu cuenta?</h3>
                                                    <p class="card-text">Esta acción no se puede deshacer y no podrás recuperar tu información.</p>

                                                    <div class="d-flex justify-content-center">
                                                        <form action="{{ route('eliminar.cuenta') }}" method="POST">
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


                                <!-- Pop-up "Completar perfil" -->
                                <div class="modal fade" id="cardModal1" tabindex="-1" aria-labelledby="cardModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="card">
                                                <div class="card-header fw-bold text-center">Completar Perfil</div>
                                                <div class="card-body">
                                                    <h5 class="card-title text-center">Completa tu perfil para disfrutar de todos nuestros privilegios libremente</h5>
                                                    <br>

                                                    <form class="row g-3" method="POST" action="{{ route('subir.documentos') }}" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="col-12">
                                                            <label for="documentoIdentidad" class="form-label">Documento Identidad (.pdf)</label>
                                                            <input type="file" name="documento_identidad" class="form-control" id="documentoIdentidad" accept=".pdf" required>
                                                        </div>
                                                        <div class="col-12">
                                                            <label for="antecedentes" class="form-label">Antecedentes Judiciales (.pdf)</label>
                                                            <input type="file" name="antecedentes_judiciales" class="form-control" id="antecedentes" accept=".pdf" required>
                                                        </div>
                                                        <div class="col-12">
                                                            <label for="portafolio" class="form-label">Portafolio (.pdf)</label>
                                                            <input type="file" name="portafolio" class="form-control" id="portafolio" accept=".pdf" required>
                                                        </div>

                                                        <div class="text-center pt-1">
                                                            <br><button type="submit" class="btn btn-primary">Enviar</button>
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <script>
                                    document.getElementById('perfilForm').addEventListener('submit', function(event) {
                                        let valid = true;
                                        const maxFileSize = 5 * 1024 * 1024; // 5MB in bytes

                                        const docIdentidad = document.getElementById('docIdentidad');
                                        if (docIdentidad.files.length > 1 || docIdentidad.files[0].size > maxFileSize || !docIdentidad.files[0].type.includes('pdf')) {
                                            document.getElementById('docIdentidadError').style.display = 'block';
                                            valid = false;
                                        } else {
                                            document.getElementById('docIdentidadError').style.display = 'none';
                                        }

                                        const antecedentes = document.getElementById('antecedentes');
                                        if (antecedentes.files.length > 1 || antecedentes.files[0].size > maxFileSize || !antecedentes.files[0].type.includes('pdf')) {
                                            document.getElementById('antecedentesError').style.display = 'block';
                                            valid = false;
                                        } else {
                                            document.getElementById('antecedentesError').style.display = 'none';
                                        }

                                        const portafolio = document.getElementById('portafolio');
                                        if (portafolio.files.length > 1 || portafolio.files[0].size > maxFileSize || !portafolio.files[0].type.includes('pdf')) {
                                            document.getElementById('portafolioError').style.display = 'block';
                                            valid = false;
                                        } else {
                                            document.getElementById('portafolioError').style.display = 'none';
                                        }

                                        if (!valid) {
                                            event.preventDefault();
                                        }
                                    });
                                </script>
                                <!-- ======= End Mi perfil ======= -->


                                <!-- ======= Editar perfil ======= -->
                                <div class="tab-pane fade profile-edit pt-1" id="profile-edit">
                                    <br>
                                    <form class="row needs-validation" action="{{ route('actualizar.perfil') }}" method="POST" enctype="multipart/form-data" novalidate>
                                        @csrf
                                        <div class="row mb-3">
                                            <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Foto perfil</label>
                                            <div class="col-md-8 col-lg-9">
                                                <img id="profilePreview" src="{{ Auth::user()->foto ? Storage::url(Auth::user()->foto) : '/assets/img/default_profile_photo.jpg' }}" alt="Profile" style="width: 150px; height: 150px; object-fit: cover;">
                                                <div class="pt-2">
                                                    <label for="profileImageUpload" class="btn btn-primary btn-sm" title="Subir nueva imagen de perfil">
                                                        <i class="bi bi-upload"></i> Subir
                                                    </label>
                                                    <input type="file" id="profileImageUpload" name="foto" accept="image/*" class="d-none" onchange="previewImage(event)">

                                                    @if (Auth::user()->foto)
                                                    <a href="{{ route('eliminar.foto.perfil') }}" class="btn btn-danger btn-sm" title="Eliminar mi imagen de perfil">
                                                        <i class="bi bi-trash"></i> Eliminar
                                                    </a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>


                                        <script>
                                            function previewImage(event) {
                                                var reader = new FileReader();
                                                reader.onload = function() {
                                                    var output = document.getElementById('profilePreview');
                                                    output.src = reader.result;
                                                }
                                                reader.readAsDataURL(event.target.files[0]);
                                            }
                                        </script>

                                        <div class="row mb-3">
                                            <label for="celular" class="col-md-4 col-lg-3 col-form-label">Celular: </label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="celular" type="text" class="form-control" id="celular" value="{{ Auth::user()->telefono }}" minlength="10" maxlength="10">
                                                <div class="invalid-feedback">Por favor ingrese su celular!</div>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="portafolio" class="col-md-4 col-lg-3 col-form-label">Mi portafolio: </label>
                                            <div class="col-md-8 col-lg-9">
                                                <input type="file" id="portafolioUpload" name="portafolio" accept="application/pdf" class="form-control">
                                                <small class="text-muted">Sube tu portafolio en formato PDF (máx. 2MB).</small>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="categoria" class="col-md-4 col-lg-3 col-form-label">Especialidad: </label>
                                            <div class="col-md-8 col-lg-9">
                                                <select name="categoria" id="categoria" class="form-control" required>
                                                    <option value="{{ Auth::user()->categoria_id }}">{{ Auth::user()->categoria->nombre }}</option>
                                                    @foreach($categorias as $categoria)
                                                    <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="text-center">
                                            <br><button type="submit" class="btn btn-primary">Guardar cambios</button>
                                        </div>
                                    </form>
                                </div>

                                <!-- ======= End Editar perfil ======= -->


                                <!-- ======= Cambiar contraseña ======= -->
                                <div class="tab-pane fade pt-3" id="profile-change-password">
                                    <form action="{{ route('cambiar.contrasena') }}" method="POST">
                                        @csrf

                                        <div class="row mb-3">
                                            <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Contraseña actual</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="password" type="password" class="form-control" id="currentPassword" minlength="8" required>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">Nueva contraseña</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="newpassword" type="password" class="form-control" id="newPassword" minlength="8" required>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Confirmar nueva contraseña</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="renewpassword" type="password" class="form-control" id="renewPassword" minlength="8" required>
                                            </div>
                                        </div>

                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary">Cambiar contraseña</button>
                                        </div>
                                    </form>
                                </div>

                                <!-- ======= Cambiar contraseña ======= -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

</body>
@stop