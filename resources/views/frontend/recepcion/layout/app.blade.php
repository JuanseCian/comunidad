<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recepción | @yield('title')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body{
            background:#f5f7fb;
            min-height:100vh;
        }

        .topbar{
            height:60px;
            background:linear-gradient(90deg,#0d92c2,#17a385);
            display:flex;
            align-items:center;
            justify-content:space-between;
            padding:0 20px;
            box-shadow:0 2px 10px rgba(0,0,0,.08);
        }

        .brand{
            color:white;
            font-weight:700;
            font-size:20px;
            text-decoration:none;
        }

        .nav-links{
            display:flex;
            gap:10px;
            align-items:center;
        }

        .nav-links a{
            color:white;
            text-decoration:none;
            padding:8px 14px;
            border-radius:8px;
            font-size:14px;
            font-weight:600;
            transition:.2s;
        }

        .nav-links a:hover{
            background:rgba(255,255,255,.15);
        }

        .page{
            padding:25px;
        }

        .card-home{
            border:none;
            border-radius:18px;
            box-shadow:0 3px 15px rgba(0,0,0,.05);
            transition:.2s;
        }

        .card-home:hover{
            transform:translateY(-3px);
        }

        .card-home .icon{
            width:55px;
            height:55px;
            border-radius:14px;
            display:flex;
            align-items:center;
            justify-content:center;
            font-size:24px;
            margin-bottom:15px;
            background:#e8f9f5;
            color:#17a385;
        }

        footer{
            background:white;
            border-top:1px solid #ddd;
            padding:15px;
            margin-top:40px;
            text-align:center;
            color:#777;
            font-size:14px;
        }
    </style>
</head>
<body>

<nav class="topbar">

    <a href="{{ route('recepcion.dashboard') }}" class="brand">
        Comunidad · Recepción
    </a>

    <div class="nav-links">

        <a href="{{ route('recepcion.dashboard') }}">
            <i class="bi bi-house"></i>
            Inicio
        </a>

        <a href="{{ route('recepcion.ingresos.index') }}">
            <i class="bi bi-journal-text"></i>
            Ingresos
        </a>

        <a href="{{ route('personas.index') }}">
            <i class="bi bi-people"></i>
            Personas
        </a>

        <form action="{{ route('logout') }}" method="POST">
            @csrf

            <button class="btn btn-light btn-sm">
                Salir
            </button>
        </form>

    </div>

</nav>

<main class="page">
    @yield('content')
</main>

<footer>
    Comunidad · Mesa de Entrada
</footer>

@stack('scripts')
</body>
</html>