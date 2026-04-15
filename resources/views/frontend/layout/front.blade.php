<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Comunidad')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

    <style>
        body {
            background: #f4f7fb;
            min-height: 100vh;
        }

        /* NAVBAR */
        .navbar-custom {
            background: linear-gradient(135deg, #3A7BD5 0%, #00D2FF 100%);
            padding: 0.5rem 0;
            box-shadow: 0 4px 15px rgba(0,0,0,0.12);
        }

        .navbar-brand {
            font-size: 1.3rem;
            font-weight: 700;
        }

        .logo-animado {
            transition: 0.3s;
        }

        .logo-animado:hover {
            transform: scale(1.05);
        }

        .navbar-custom .nav-link {
            color: rgba(255,255,255,0.9);
            padding: 10px 18px !important;
            border-radius: 10px;
            transition: 0.2s;
        }

        .navbar-custom .nav-link:hover {
            background: rgba(255,255,255,0.15);
            color: #fff;
        }

        .nav-admin {
            background: #1E3A5F !important;
            color: #fff !important;
            padding: 10px 25px !important;
            border-radius: 20px;
        }

        /* BUSCADOR */
        .search-container {
            max-width: 380px;
            width: 100%;
        }

        .search-input {
            border-radius: 20px 0 0 20px;
        }

        .search-btn {
            border-radius: 0 20px 20px 0;
        }

        /* FOOTER */
        footer {
            background: #1E3A5F;
            color: white;
            padding: 1rem 0;
        }

        .footer-logo {
            max-height: 55px;
            filter: brightness(0) invert(1);
        }

        .fade-page {
            animation: fadePage 0.5s ease;
        }

        @keyframes fadePage {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* BOTÓN INFO */
        .btn-flotante {
            position: fixed;
            bottom: 25px;
            right: 25px;
            width: 55px;
            height: 55px;
            background: linear-gradient(45deg, #3A7BD5, #00D2FF);
            color: white;
            border-radius: 50%;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            box-shadow: 0 4px 15px rgba(0,0,0,0.3);
        }

        .btn-flotante:hover {
            transform: scale(1.1);
        }

        .modal-header {
            background: linear-gradient(135deg, #3A7BD5, #00D2FF);
            color: white;
        }
    </style>
</head>

<body class="d-flex flex-column min-vh-100">

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark navbar-custom">
    <div class="container-fluid px-4">

        <a class="navbar-brand" href="{{ route('home') }}">
            Comunidad
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="nav">
            <ul class="navbar-nav w-100 align-items-lg-center">

                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="bi bi-people"></i> Usuarios
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="bi bi-bar-chart"></i> Estadísticas
                    </a>
                </li>

                @auth
                <li class="nav-item ms-lg-auto search-container">
                    <form class="d-flex">
                        <input type="text" class="form-control form-control-sm search-input" placeholder="Buscar...">
                        <button class="btn btn-light search-btn">
                            <i class="bi bi-search"></i>
                        </button>
                    </form>
                </li>
                @endauth

                <li class="nav-item ms-lg-3">
                    @auth
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="btn btn-dark btn-sm rounded-pill px-4">
                                Salir
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-light btn-sm rounded-pill px-4 fw-bold">
                            Ingresar
                        </a>
                    @endauth
                </li>

            </ul>
        </div>
    </div>
</nav>

<!-- CONTENT -->
<main class="container flex-grow-1 py-4 fade-page">
    @yield('content')
</main>

<!-- FOOTER -->
<footer class="mt-auto">
    <div class="container">
        <div class="row text-center text-md-start align-items-center">

            <div class="col-md-4 mb-3 mb-md-0">
                <h6 class="fw-bold">Comunidad</h6>
                <small>Sistema de gestión social</small>
            </div>

            <div class="col-md-4 text-center mb-3 mb-md-0">
                <small>© {{ date('Y') }} Todos los derechos reservados</small>
            </div>

            <div class="col-md-4 text-md-end">
                <small>soporte@comunidad.com</small>
            </div>

        </div>
    </div>
</footer>

<!-- BOTÓN INFO -->
<button class="btn-flotante" data-bs-toggle="modal" data-bs-target="#infoModal">
    <i class="bi bi-info-circle"></i>
</button>

<!-- MODAL -->
<div class="modal fade" id="infoModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Sistema Comunidad</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <p class="text-muted">
                    Sistema de gestión social para administración de usuarios,
                    estadísticas y seguimiento de información.
                </p>
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">
                    Cerrar
                </button>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
});

@if(session('success'))
    Toast.fire({ icon: 'success', title: "{{ session('success') }}" });
@endif

@if(session('error'))
    Toast.fire({ icon: 'error', title: "{{ session('error') }}" });
@endif
</script>

</body>
</html>