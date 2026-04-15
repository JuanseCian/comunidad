<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/style-login.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <title>Comunidad - Acceso</title>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #3A7BD5, #00D2FF);
            background-attachment: fixed;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
        }

        .flip-card-container {
            perspective: 1000px;
            max-width: 1000px;
            margin: 20px auto;
        }

        .flip-card-inner {
            transition: transform 0.8s cubic-bezier(0.4, 0.2, 0.2, 1);
            transform-style: preserve-3d;
            display: grid;
        }

        .is-flipped { transform: rotateY(180deg); }

        .flip-card-front, .flip-card-back {
            grid-area: 1 / 1 / 2 / 2;
            backface-visibility: hidden;
        }

        .flip-card-back { transform: rotateY(180deg); }

        .background-image {
            background-image:
                linear-gradient(rgba(30,58,95,0.85), rgba(0,210,255,0.7)),
                url('{{ asset('assets/img/fondo-03.png') }}');
            background-size: cover;
            background-position: center;
        }

        .card {
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
            overflow: hidden;
            border: none;
        }

        .form-control {
            border-radius: 8px;
            padding: 0.6rem 1rem;
        }

        .form-control:focus {
            box-shadow: 0 0 0 0.25rem rgba(58,123,213,0.25);
            border-color: #3A7BD5;
        }

        .btn {
            border-radius: 8px;
            padding: 0.6rem;
            transition: 0.3s;
        }

        .btn:hover {
            transform: translateY(-2px);
        }

        .btn-primary-custom {
            background: linear-gradient(45deg, #3A7BD5, #00D2FF);
            border: none;
            color: white;
        }

        .logo-login {
            max-width: 220px;
        }

        section {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 15px;
        }

        a {
            color: #3A7BD5;
            text-decoration: none;
        }

        a:hover {
            color: #1E3A5F;
            text-decoration: underline;
        }

        footer {
            flex-shrink: 0;
            margin-top: auto;
        }   
    </style>
</head>

<body>

@php
    $flip = request()->routeIs('register') || $errors->any();
@endphp

<section>
    <div class="container flip-card-container">
        <div class="flip-card-inner {{ $flip ? 'is-flipped' : '' }}" id="cardInner">

            <!-- LOGIN -->
            <div class="flip-card-front">
                <div class="card">
                    <div class="row g-0 h-100">

                        <div class="col-md-6 background-image d-none d-md-block">
                            <div class="d-flex align-items-center justify-content-center h-100 text-white text-center">
                                <div>
                                    <h2>Comunidad</h2>
                                    <p>Sistema de gestión social</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 p-4 p-xl-5 bg-white d-flex flex-column justify-content-center">
                            <h3 class="fw-bold mb-4">Iniciar Sesión</h3>

                            @error('login')
                                <div class="alert alert-danger py-2">{{ $message }}</div>
                            @enderror

                            <form method="POST" action="{{ route('login') }}">
                                @csrf

                                <div class="mb-3">
                                    <input type="text" name="login" class="form-control" placeholder="Usuario o Email" required>
                                </div>

                                <div class="mb-4">
                                    <div class="input-group">
                                        <input type="password" name="password" id="login_password" class="form-control" placeholder="••••••••" required>
                                        <button class="btn btn-outline-secondary toggle-password" type="button" data-target="login_password">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                </div>

                                <button class="btn btn-primary-custom w-100">Ingresar</button>
                            </form>

                            <p class="mt-3 text-center">
                                ¿No tenés cuenta?
                                <a href="javascript:void(0)" onclick="flip(true)">Registrate</a>
                            </p>
                        </div>

                    </div>
                </div>
            </div>

            <!-- REGISTER -->
            <div class="flip-card-back">
                <div class="card">
                    <div class="row g-0 h-100">

                        <div class="col-md-6 background-image d-none d-md-block">
                            <div class="d-flex align-items-center justify-content-center h-100 text-white text-center">
                                <div>
                                    <h2>Unite a Comunidad</h2>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 p-4 p-xl-5 bg-white">
                            <h3 class="fw-bold mb-3">Registro</h3>

                            @if ($errors->any())
                                <div class="alert alert-danger py-2">
                                    <ul class="mb-0 ps-3">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form method="POST" action="{{ route('register') }}">
                                @csrf

                                <div class="row g-3">
                                    <div class="col-12">
                                        <input type="text" name="username" class="form-control" placeholder="Usuario" required>
                                    </div>

                                    <div class="col-sm-6">
                                        <input type="password" name="password" class="form-control" placeholder="Contraseña" required>
                                    </div>

                                    <div class="col-sm-6">
                                        <input type="password" name="password_confirmation" class="form-control" placeholder="Confirmar" required>
                                    </div>

                                    <div class="col-12">
                                        <input type="email" name="email" class="form-control" placeholder="Correo Electrónico" required>
                                    </div>

                                    <div class="col-sm-6">
                                        <input type="text" name="nombre" class="form-control" placeholder="Nombre" required>
                                    </div>

                                    <div class="col-sm-6">
                                        <input type="text" name="apellido" class="form-control" placeholder="Apellido" required>
                                    </div>
                                </div>

                                <button class="btn btn-primary-custom w-100 mt-4">Registrarse</button>
                            </form>

                            <p class="mt-4 text-center">
                                ¿Ya tenés cuenta?
                                <a href="javascript:void(0)" onclick="flip(false)">Ingresar</a>
                            </p>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
    
</section>

<footer class="bg-dark text-white py-3 mt-auto">
    <div class="container">
        <div class="row align-items-center">
            
            <div class="col-md-3 text-center text-md-start mb-3 mb-md-0">
                <img src="{{ asset('assets/img/municipalidad_logo.png') }}" 
                     alt="Logo Municipalidad de San Nicolas" 
                     width="150"
                     class="footer-logo">
            </div>

            <div class="col-md-9 text-center text-md-end">
                <p class="mb-0">
                    <i class="fas fa-map-marker-alt"></i> Sistema Comunidad<br>
                    Gestión social y administración<br>
                    
                    <a href="mailto:soporte@comunidad.com" 
                       class="text-white text-decoration-none">
                        <i class="fas fa-envelope"></i> soporte@comunidad.com
                    </a>
                </p>
            </div>

        </div>
    </div>
</footer>

<script>
function flip(showRegister) {
    const card = document.getElementById('cardInner');
    card.classList.toggle('is-flipped', showRegister);
}
</script>

<script>
document.querySelectorAll('.toggle-password').forEach(btn => {
    btn.addEventListener('click', function () {
        const input = document.getElementById(this.dataset.target);
        const icon = this.querySelector('i');

        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.replace('bi-eye', 'bi-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.replace('bi-eye-slash', 'bi-eye');
        }
    });
});
</script>

</body>
</html>