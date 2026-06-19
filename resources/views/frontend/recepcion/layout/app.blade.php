<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        Recepción | @yield('title')
    </title>

    <link rel="icon" href="{{ asset('assets/img/sn.png') }}" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Nunito:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            /* Paleta de colores unificada */
            --teal-50:  #e8f9f5;
            --teal-100: #c2eee3;
            --teal-300: #5dc9a8;
            --teal-400: #2db896;
            --teal-500: #17a385;
            --teal-600: #0e8a70;
            --teal-700: #086f59;

            --sky-50:   #e6f5fb;
            --sky-100:  #b3e0f5;
            --sky-300:  #4dbde8;
            --sky-400:  #1aaad8;
            --sky-500:  #0d92c2;
            --sky-600:  #0879a8;
            --sky-700:  #045f87;

            --mint-50:  #f0fdf9;
            --mint-100: #d0f4ec;

            --neutral-50:  #f8fafb;
            --neutral-100: #eef2f5;
            --neutral-200: #dde3ea;
            --neutral-400: #94a3b4;
            --neutral-600: #536070;
            --neutral-800: #1e293b;
            --neutral-900: #0f172a;

            /* Degradados temáticos */
            --grad-main: linear-gradient(135deg, #0d92c2 0%, #17a385 100%);
            --grad-soft: linear-gradient(135deg, #e6f5fb 0%, #e8f9f5 100%);
            --grad-nav:  linear-gradient(180deg, #0879a8 0%, #0e8a70 100%);

            /* Sombras y Radios */
            --shadow-sm: 0 1px 3px rgba(13,146,194,.08), 0 1px 2px rgba(0,0,0,.04);
            --shadow-md: 0 4px 16px rgba(13,146,194,.12), 0 2px 6px rgba(0,0,0,.05);
            --shadow-lg: 0 10px 32px rgba(13,146,194,.16), 0 4px 10px rgba(0,0,0,.06);

            --radius-sm: 8px;
            --radius-md: 12px;
            --radius-lg: 18px;
            --radius-xl: 24px;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: 
                radial-gradient(circle at top left, rgba(13,146,194,.06), transparent 30%),
                radial-gradient(circle at bottom right, rgba(23,163,133,.06), transparent 25%),
                var(--neutral-50);
            min-height: 100vh;
            font-family: 'Nunito', sans-serif;
            color: var(--neutral-800);
        }

        /* SIDEBAR */
        .sidebar {
            width: 260px;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            background: var(--grad-nav);
            padding: 24px 18px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            box-shadow: 6px 0 25px rgba(8,121,168,.15);
            z-index: 1000;
        }

        .brand {
            text-decoration: none;
            color: white;
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 35px;
        }

        .brand-logo {
            width: 44px;
            height: 44px;
            border-radius: var(--radius-md);
            background: rgba(255, 255, 255, 0.18);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            color: white;
        }

        .brand-text h5 {
            margin: 0;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 800;
            font-size: 0.95rem;
            line-height: 1.2;
            letter-spacing: .3px;
        }

        .brand-text span {
            color: rgba(255, 255, 255, .65);
            font-size: .78rem;
            font-weight: 600;
            letter-spacing: .8px;
            text-transform: uppercase;
            display: block;
            margin-top: 2px;
        }

        .sidebar-links {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .sidebar-links a {
            text-decoration: none;
            color: rgba(255, 255, 255, .8);
            padding: 12px 14px;
            border-radius: var(--radius-md);
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 600;
            font-size: 13.5px;
            transition: all .2s ease;
        }

        .sidebar-links a i {
            font-size: 1.05rem;
            opacity: 0.9;
        }

        .sidebar-links a:hover,
        .sidebar-links a.active {
            background: rgba(255, 255, 255, .14);
            color: white;
            transform: translateX(4px);
        }

        .sidebar-links a.active {
            background: white;
            color: var(--sky-700);
            box-shadow: var(--shadow-sm);
        }

        .logout-form {
            margin: 0;
        }

        .logout-btn {
            width: 100%;
            border: 1px solid #fecaca;
            background: #fef2f2;
            color: #ef4444;
            padding: 11px;
            border-radius: var(--radius-md);
            transition: all .2s;
            font-weight: 700;
            font-size: 13.5px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .logout-btn:hover {
            background: #fee2e2;
        }

        /* CONTENT */
        .main {
            margin-left: 260px;
            min-height: 100vh;
            padding: 26px;
        }

        .topbar {
            background: rgba(255, 255, 255, .8);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border: 1px solid rgba(255, 255, 255, .6);
            border-radius: var(--radius-xl);
            padding: 18px 24px;
            margin-bottom: 26px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: var(--shadow-md);
        }

        .topbar-title h4 {
            margin: 0;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 700;
            color: var(--neutral-900);
            font-size: 1.25rem;
        }

        .topbar-title p {
            margin: 4px 0 0;
            color: var(--neutral-600);
            font-size: .88rem;
            font-weight: 500;
        }

        .topbar-badge {
            background: var(--grad-main);
            color: white;
            padding: 8px 16px;
            border-radius: 999px;
            font-size: .82rem;
            font-weight: 700;
            box-shadow: 0 4px 12px rgba(13,146,194,.18);
            display: flex;
            align-items: center;
        }

        .content {
            animation: fade .25s ease;
        }

        @keyframes fade {
            from {
                opacity: 0;
                transform: translateY(6px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        footer {
            margin-top: 40px;
            padding: 20px 0;
            text-align: center;
            color: var(--neutral-400);
            font-size: .82rem;
            font-weight: 600;
            border-top: 1px solid var(--neutral-200);
        }

        /* MOBILE */
        @media(max-width: 992px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
                border-radius: 0 0 var(--radius-xl) var(--radius-xl);
                padding: 20px;
            }

            .brand {
                margin-bottom: 20px;
            }

            .logout-btn {
                margin-top: 15px;
            }

            .main {
                margin-left: 0;
                padding: 18px;
            }

            .topbar {
                flex-direction: column;
                align-items: flex-start;
                gap: 14px;
                padding: 16px;
            }
        }
    </style>
</head>

<body>
    @if(session('error'))
    <script>
    Swal.fire({
        icon: 'warning',
        title: 'Acceso restringido',
        text: '{{ session('error') }}',
        confirmButtonText: 'Aceptar'
    });
    </script>
    @endif

    {{-- SIDEBAR --}}
    <aside class="sidebar">

        <div>
            {{-- BRAND --}}
            <a href="{{ route('recepcion.dashboard') }}" class="brand">
                <div class="brand-logo">
                    <i class="bi bi-grid-1x2-fill"></i>
                </div>
                <div class="brand-text">
                    <h5>Comunidad</h5>
                    <span>Mesa de Entrada</span>
                </div>
            </a>

            {{-- LINKS --}}
            <div class="sidebar-links">
                <a href="{{ route('recepcion.dashboard') }}"
                   class="{{ request()->routeIs('recepcion.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-house-door-fill"></i>
                    Inicio
                </a>

                <a href="{{ route('recepcion.ingresos.index') }}"
                   class="{{ request()->routeIs('recepcion.ingresos.*') ? 'active' : '' }}">
                    <i class="bi bi-journal-text"></i>
                    Ingresos
                </a>

                <a href="{{ route('recepcion.mercaderias.index') }}"
                   class="{{ request()->routeIs('recepcion.mercaderias.*') ? 'active' : '' }}">
                    <i class="bi bi-box-seam"></i>
                    Mercadería
                </a>

                <a href="{{ route('recepcion.sepelios.index') }}"
                   class="{{ request()->routeIs('recepcion.sepelios.*') ? 'active' : '' }}">
                    <i class="bi bi-heartbreak"></i>
                    Sepelios
                </a>

                <a href="{{ route('bajo-peso.index') }}"
                   class="{{ request()->routeIs('bajo.*') ? 'active' : '' }}">
                    <i class="bi bi-people-fill"></i>
                    Bajo peso
                </a>

                <a href="{{ route('estadisticas.dashboard') }}"
                class="{{ request()->routeIs('frontend.estadisticas.*') ? 'active' : '' }}">
                    <i class="bi bi-bar-chart-line-fill"></i>
                    Estadísticas
                </a>
            </div>
        </div>

        

        {{-- LOGOUT --}}
        <form action="{{ route('logout') }}" method="POST" class="logout-form">
            @csrf
            <button class="logout-btn">
                <i class="bi bi-box-arrow-right"></i>
                Cerrar sesión
            </button>
        </form>

    </aside>

    {{-- MAIN --}}
    <main class="main">

        {{-- TOPBAR --}}

        {{-- CONTENT --}}
        <div class="content">
            @yield('content')
        </div>

        {{-- FOOTER --}}
        <footer>
            Comunidad · Mesa de Entrada
        </footer>

    </main>

    @stack('scripts')

</body>
</html>