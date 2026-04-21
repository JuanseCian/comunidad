<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comunidad | @yield('title')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Nunito:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
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

            --grad-main: linear-gradient(135deg, #0d92c2 0%, #17a385 100%);
            --grad-soft: linear-gradient(135deg, #e6f5fb 0%, #e8f9f5 100%);
            --grad-nav:  linear-gradient(90deg, #0879a8 0%, #0e8a70 100%);

            --shadow-sm: 0 1px 3px rgba(13, 146, 194, 0.08), 0 1px 2px rgba(0,0,0,0.04);
            --shadow-md: 0 4px 16px rgba(13, 146, 194, 0.12), 0 2px 6px rgba(0,0,0,0.05);
            --shadow-lg: 0 10px 32px rgba(13, 146, 194, 0.16), 0 4px 10px rgba(0,0,0,0.06);

            --radius-sm: 8px;
            --radius-md: 12px;
            --radius-lg: 18px;
            --radius-xl: 24px;
        }

        *, *::before, *::after { box-sizing: border-box; }

        body {
            background: var(--neutral-50);
            font-family: 'Nunito', sans-serif;
            color: var(--neutral-800);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
        }

        /* ── TOPBAR ── */
        .topbar {
            background: var(--grad-nav);
            padding: 0;
            position: sticky;
            top: 0;
            z-index: 1050;
            box-shadow: 0 2px 20px rgba(8, 121, 168, 0.25);
        }

        .topbar .container-fluid {
            display: flex;
            align-items: stretch;
            min-height: 62px;
        }

        /* Brand */
        .nav-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 0 24px 0 16px;
            text-decoration: none;
            border-right: 1px solid rgba(255,255,255,0.12);
            flex-shrink: 0;
        }

        .nav-brand-icon {
            width: 36px;
            height: 36px;
            background: rgba(255,255,255,0.2);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            color: white;
        }

        .nav-brand-text {
            display: flex;
            flex-direction: column;
            line-height: 1.1;
        }

        .nav-brand-text span:first-child {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 800;
            font-size: 15px;
            color: white;
            letter-spacing: 0.5px;
        }

        .nav-brand-text span:last-child {
            font-size: 10px;
            color: rgba(255,255,255,0.65);
            font-weight: 500;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        /* Nav links */
        .nav-links {
            display: flex;
            align-items: stretch;
            list-style: none;
            margin: 0;
            padding: 0;
            flex: 1;
        }

        .nav-links > li {
            display: flex;
            align-items: stretch;
        }

        .nav-links > li > a,
        .nav-links > li > .nav-drop-toggle {
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 0 18px;
            color: rgba(255,255,255,0.82);
            font-weight: 600;
            font-size: 13.5px;
            text-decoration: none;
            transition: background 0.2s, color 0.2s;
            position: relative;
            cursor: pointer;
            border: none;
            background: none;
        }

        .nav-links > li > a:hover,
        .nav-links > li > .nav-drop-toggle:hover,
        .nav-links > li > a.active {
            color: white;
            background: rgba(255,255,255,0.1);
        }

        .nav-links > li > a::after,
        .nav-links > li > a.active::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 18px;
            right: 18px;
            height: 2px;
            background: rgba(255,255,255,0);
            border-radius: 2px 2px 0 0;
            transition: background 0.2s;
        }

        .nav-links > li > a.active::after {
            background: white;
        }

        /* Dropdown */
        .nav-dropdown {
            position: relative;
        }

        .nav-dropdown-menu {
            display: none;
            position: absolute;
            top: calc(100% + 0px);
            left: 0;
            min-width: 200px;
            background: white;
            border-radius: 0 0 var(--radius-md) var(--radius-md);
            box-shadow: var(--shadow-lg);
            padding: 6px;
            z-index: 100;
            border: 1px solid var(--neutral-200);
            border-top: 3px solid var(--teal-400);
        }

        .nav-dropdown:hover .nav-dropdown-menu {
            display: block;
        }

        .nav-dropdown-menu a {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 9px 14px;
            border-radius: var(--radius-sm);
            color: var(--neutral-800);
            font-size: 13.5px;
            font-weight: 600;
            text-decoration: none;
            transition: background 0.15s;
        }

        .nav-dropdown-menu a:hover {
            background: var(--mint-100);
            color: var(--teal-600);
        }

        .nav-dropdown-menu a i {
            color: var(--teal-500);
            font-size: 14px;
        }

        /* Divider */
        .nav-divider {
            width: 1px;
            background: rgba(255,255,255,0.12);
            margin: 10px 0;
        }

        /* Right zone */
        .nav-right {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 0 16px;
            border-left: 1px solid rgba(255,255,255,0.12);
        }

        .nav-user-pill {
            display: flex;
            align-items: center;
            gap: 8px;
            background: rgba(255,255,255,0.12);
            border-radius: 40px;
            padding: 5px 14px 5px 5px;
        }

        .nav-avatar {
            width: 32px;
            height: 32px;
            background: rgba(255,255,255,0.9);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 12px;
            color: var(--teal-600);
        }

        .nav-username {
            color: white;
            font-size: 13px;
            font-weight: 600;
        }

        .btn-nav-admin {
            background: rgba(255,255,255,0.15);
            border: 1px solid rgba(255,255,255,0.25);
            color: white;
            border-radius: 8px;
            padding: 6px 14px;
            font-size: 12.5px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 6px;
            text-decoration: none;
            transition: background 0.2s;
        }

        .btn-nav-admin:hover {
            background: rgba(255,255,255,0.25);
            color: white;
        }

        .btn-nav-logout {
            background: rgba(255, 80, 80, 0.2);
            border: 1px solid rgba(255,100,100,0.3);
            color: white;
            border-radius: 8px;
            padding: 6px 12px;
            font-size: 12.5px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 5px;
            cursor: pointer;
            transition: background 0.2s;
        }

        .btn-nav-logout:hover {
            background: rgba(255,80,80,0.35);
        }

        .btn-nav-login {
            background: white;
            color: var(--teal-600);
            border: none;
            border-radius: 8px;
            padding: 7px 18px;
            font-size: 13px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 6px;
            text-decoration: none;
            transition: transform 0.15s, box-shadow 0.15s;
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        }

        .btn-nav-login:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 14px rgba(0,0,0,0.2);
            color: var(--teal-700);
        }

        /* Mobile toggler */
        .nav-toggler {
            display: none;
            background: rgba(255,255,255,0.12);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 8px;
            color: white;
            padding: 6px 10px;
            font-size: 18px;
            cursor: pointer;
            margin-left: auto;
        }

        /* ── MAIN ── */
        main {
            flex: 1;
        }

        /* ── FOOTER ── */
        footer {
            background: white;
            border-top: 1px solid var(--neutral-200);
            padding: 20px 0;
        }

        footer .footer-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 8px;
        }

        footer .footer-brand {
            display: flex;
            align-items: center;
            gap: 8px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 700;
            font-size: 14px;
            background: var(--grad-main);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        footer p {
            color: var(--neutral-400);
            font-size: 12.5px;
            margin: 0;
        }

        /* ── RESPONSIVE ── */
        @media (max-width: 991px) {
            .nav-links, .nav-divider { display: none; }
            .nav-toggler { display: flex; }
            .nav-right { border-left: none; margin-left: auto; }

            .nav-mobile-open .nav-links {
                display: flex;
                flex-direction: column;
                position: absolute;
                top: 62px;
                left: 0;
                right: 0;
                background: var(--sky-700);
                padding: 8px;
                box-shadow: var(--shadow-lg);
                z-index: 999;
            }

            .nav-links > li > a,
            .nav-links > li > .nav-drop-toggle {
                padding: 12px 16px;
                border-radius: 8px;
            }

            .nav-dropdown-menu {
                position: static;
                box-shadow: none;
                border: none;
                border-top: none;
                border-radius: var(--radius-sm);
                background: rgba(255,255,255,0.08);
                margin: 4px 0;
            }

            .nav-dropdown-menu a {
                color: rgba(255,255,255,0.82);
            }

            .nav-dropdown-menu a:hover {
                background: rgba(255,255,255,0.1);
                color: white;
            }
        }
    </style>
</head>
<body>

<nav class="topbar" id="mainNav">
    <div class="container-fluid">

        <a class="nav-brand" href="{{ route('home') }}">
            <div class="nav-brand-icon">
                <i class="bi bi-heart-pulse-fill"></i>
            </div>
            <div class="nav-brand-text">
                <span>Comunidad</span>
                <span>Gestión Social</span>
            </div>
        </a>

        <ul class="nav-links ms-2" id="navLinks">
            <li>
                <a class="active" href="{{ route('home') }}">
                    <i class="bi bi-house-door"></i> Inicio
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="bi bi-person-badge"></i> Recepción
                </a>
            </li>
            <li class="nav-dropdown">
                <span class="nav-drop-toggle">
                    <i class="bi bi-collection"></i> Programas <i class="bi bi-chevron-down ms-1" style="font-size:10px;"></i>
                </span>
                <div class="nav-dropdown-menu">
                    <a href="#"><i class="bi bi-mortarboard"></i> Envión</a>
                    <a href="#"><i class="bi bi-egg-fried"></i> UDI / Más Vida</a>
                    <a href="#"><i class="bi bi-heart-pulse"></i> Bajo Peso</a>
                    <a href="#"><i class="bi bi-building-up"></i> Multiespacio</a>
                </div>
            </li>
            <li>
                <a href="#">
                    <i class="bi bi-box-seam"></i> Mercadería
                </a>
            </li>
        </ul>

        <div class="nav-divider"></div>

        <div class="nav-right">
            @auth
                @if(auth()->user()->rol_id == 3)
                    <a href="{{ route('admin.home') }}" class="btn-nav-admin">
                        <i class="bi bi-gear-fill"></i> Admin
                    </a>
                @endif

                <div class="nav-user-pill">
                    <div class="nav-avatar">
                        {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                    </div>
                    <span class="nav-username">{{ auth()->user()->name }}</span>
                </div>

                <form action="{{ route('logout') }}" method="POST" style="margin:0;">
                    @csrf
                    <button type="submit" class="btn-nav-logout">
                        <i class="bi bi-box-arrow-right"></i> Salir
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn-nav-login">
                    <i class="bi bi-box-arrow-in-right"></i> Ingresar
                </a>
            @endauth
        </div>

        <button class="nav-toggler" onclick="toggleNav()">
            <i class="bi bi-list"></i>
        </button>

    </div>
</nav>

<main>
    @yield('content')
</main>

<footer>
    <div class="container">
        <div class="footer-inner">
            <div class="footer-brand">
                <i class="bi bi-heart-pulse-fill" style="background: var(--grad-main); -webkit-background-clip: text;"></i>
                Gestión Social · Comunidad
            </div>
            <p>&copy; {{ date('Y') }} &nbsp;·&nbsp; Innovación para la Comunidad</p>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function toggleNav() {
        document.getElementById('mainNav').classList.toggle('nav-mobile-open');
    }
</script>
</body>
</html>