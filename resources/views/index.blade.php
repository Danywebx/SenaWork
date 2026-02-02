<!DOCTYPE html>
<html lang="es">

<head>
    <title>Inicio - SenaWork</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Favicons -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href="assets/img/mi_logo.png" rel="icon">

    <!-- <=========== Estilos ===========> -->
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }

        html,
        body {
            height: 100%;
            margin: 0;
        }

        .container-banner {
            min-height: 100vh;
            background-color: white;
        }

        .header {
            background-color: #3AA7F2;
            color: #fff;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: relative;
        }

        .header h1 {
            flex-grow: 1;
            text-align: center;
        }

        .header img {
            height: 50px;
            position: absolute;
            left: 20px;
        }

        .header .auth-links {
            position: absolute;
            right: 20px;
        }

        .header .auth-links a {
            color: #fff;
            margin-left: 20px;
            text-decoration: none;
            font-weight: bold;
        }

        .header .auth-links a:hover {
            color: #263850;
        }

        .banner {
            background-color: #3AA7F2;
            color: #fff;
            padding: 50px 0;
            text-align: center;
            position: relative;
            z-index: 1;
        }

        .banner::before {
            content: '';
            background-color: #fff;
            border-radius: 50% 50% 0 0 / 10% 10% 0 0;
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 100px;
            z-index: -1;
        }

        .search-bar {
            background-color: #fff;
            padding: 10px;
            border-radius: 50px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            margin: 20px auto;
            max-width: 700px;
            gap: 15px;
        }

        .search-bar input[type="text"] {
            flex-grow: 2;
            padding: 10px;
            border-radius: 30px;
            border: 1px solid #ddd;
        }

        .search-bar select,
        .search-bar input {
            border: 1px solid #e0e0e0;
            padding: 10px 15px;
            border-radius: 30px;
            width: 300px;
            outline: none;
        }

        .search-bar input {
            flex-grow: 1;
        }

        .search-bar select {
            flex-grow: 1;
            width: 260px;
            cursor: pointer;
        }

        .search-bar button {
            background-color: #3AA7F2;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 30px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .search-bar button:hover {
            background-color: #263850;
        }

        .search-bar select:focus,
        .search-bar input:focus {
            border-color: gray;
        }

        .statistics {
            text-align: center;
            margin: 50px 0;
        }

        .statistics div {
            display: inline-block;
            margin: 0 20px;
        }


        @media (max-width: 768px) {
            .header img {
                height: 40px;
            }

            .header {
                flex-direction: column;
                text-align: center;
            }
        }

        @media (max-width: 768px) {

            .search-bar {
                flex-direction: column;
                max-width: 100%;
            }

            .search-bar input[type="text"],
            .search-bar select,
            .search-bar button {
                width: 100%;
                margin-bottom: 10px;
            }

            .search-bar button {
                width: 20%;
            }

            .header {
                flex-direction: column;
                text-align: center;
            }

            .header h1 {
                margin-top: 60px;
                font-size: 1.8em;
            }

            .header .auth-links {
                margin: 10px 0;
            }

            .header .auth-links a {
                margin: 0 10px;
                font-size: 1em;
            }
        }

        @media (max-width: 480px) {

            .search-bar {
                flex-direction: column;
            }

            .search-bar select,
            .search-bar input {
                width: 100%;
            }

            .search-bar button {
                width: 20%;
            }

            .header h1 {
                font-size: 1.4em;
            }

            .statistics div {
                margin: 10px 0;
            }
        }

        @media (max-width: 768px) {
            .statistics div {
                display: block;
                margin: 10px 0;
                text-align: center;
            }
        }
    </style>
</head>

<body>

    <div class="header">
        <img src="{{ asset('/assets/img/mi_logo.png') }}" alt="Logo SenaWork">
        <h1>¡Impulsando empleos, potenciando vidas!</h1>
        <div class="auth-links">
            <a href="{{ route('login') }}">Iniciar sesión</a>
            <a href="{{ route('registro') }}">Registrarse</a>
        </div>
    </div>

    <div class="container-banner">
        <div class="banner">
            <h3>Encuentra el empleo que encaja contigo</h3>
            <div class="search-bar">
                <form action="{{ route('buscar.invitado') }}" method="GET" style="display: flex; gap: 10px;">
                    @csrf
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon1">
                        </span>
                        <input type="text" name="query" placeholder="Buscar" class="form-control" aria-label="Buscar" aria-describedby="basic-addon1">
                    </div>

                    <select name="categoria" id="categoria" class="form-select">
                        <option value="" disabled selected>Categorías</option>
                        @foreach($categorias as $categoria)
                        <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                        @endforeach
                    </select>

                    <button type="submit" class="btn btn-primary">Buscar</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>