<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Comunidad | @yield('title')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        /* ==========================================
           1. VARIABLES GLOBALES Y COLORES
        ========================================== */
        :root {
            --teal-50:  #e8f9f5; --teal-100: #c2eee3; --teal-300: #5dc9a8;
            --teal-400: #2db896; --teal-500: #17a385; --teal-600: #0e8a70; --teal-700: #086f59;
            --sky-50:   #e6f5fb; --sky-100:  #b3e0f5; --sky-300:  #4dbde8;
            --sky-400:  #1aaad8; --sky-500:  #0d92c2; --sky-600:  #0879a8; --sky-700:  #045f87;
            --neutral-50:  #f8fafb; --neutral-100: #eef2f5; --neutral-200: #dde3ea;
            --neutral-400: #94a3b4; --neutral-600: #536070; --neutral-800: #1e293b;

            --grad-main: linear-gradient(135deg, #0d92c2 0%, #17a385 100%);
            --grad-nav:  linear-gradient(90deg, #0879a8 0%, #0e8a70 100%);
            --shadow-sm: 0 2px 4px rgba(0,0,0,.04);
            --shadow-md: 0 4px 12px rgba(13,146,194,.08);
            --shadow-lg: 0 10px 32px rgba(0,0,0,.12);
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
            overflow-x: hidden;
        }

        .topbar {
            background: var(--grad-nav);
            height: 76px; /* Header más gordito */
            position: sticky;
            top: 0;
            z-index: 1040;
            box-shadow: var(--shadow-md);
            padding: 0 1.5rem;
            display: grid;
            grid-template-columns: 1fr auto 1fr; /* Clave para un centrado perfecto */
            align-items: center;
            transition: all 0.3s ease;
        }

        .nav-brand-wrapper { justify-self: start; }
        .nav-brand {
            display: flex; align-items: center; gap: 12px; text-decoration: none;
        }
        .nav-brand-icon {
            width: 42px; height: 42px; 
            background: rgba(255,255,255,.15);
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 20px; color: white;
        }
        .nav-brand-text { display: flex; flex-direction: column; }
        .nav-brand-text span:first-child {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 800; font-size: 16px; color: white; line-height: 1.1;
        }
        .nav-brand-text span:last-child {
            font-size: 11px; color: rgba(255,255,255,.7);
            font-weight: 600; letter-spacing: 1px; text-transform: uppercase;
        }

        .nav-links {
            justify-self: center;
            display: flex; align-items: center; gap: 12px;
            list-style: none; margin: 0; padding: 0;
        }
        .nav-links > li > a {
            display: flex; align-items: center; gap: 8px;
            padding: 10px 16px; border-radius: 10px;
            color: rgba(255,255,255,.8); font-weight: 700; font-size: 14.5px;
            text-decoration: none; transition: all 0.2s ease;
        }
        .nav-links > li > a:hover, .nav-links > li > a.active {
            color: white; background: rgba(255,255,255,.15);
        }

        /* Estilo especial sutil para el botón Estadísticas en el centro */
        .nav-links .btn-estadisticas-mid {
            background: rgba(255,255,255,.08);
            border: 1px solid rgba(255,255,255,.2);
        }
        .nav-links .btn-estadisticas-mid:hover {
            background: white; color: var(--teal-700); border-color: white;
        }

        /* Acciones (Derecha) */
        .nav-actions { justify-self: end; display: flex; align-items: center; gap: 12px; }
        
        .btn-perfil {
            width: 44px; height: 44px;
            border-radius: 50%; border: 2px solid rgba(255,255,255,.4);
            background: white; color: var(--teal-600);
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 800; font-size: 15px;
            cursor: pointer; transition: all 0.2s;
            display: flex; align-items: center; justify-content: center;
            box-shadow: var(--shadow-sm);
        }
        .btn-perfil:hover { transform: scale(1.05); border-color: white; box-shadow: var(--shadow-md); }

        .nav-toggler {
            display: none; background: rgba(255,255,255,.15);
            border: 1px solid rgba(255,255,255,.2); border-radius: 10px; 
            color: white; padding: 8px 14px; font-size: 22px; cursor: pointer;
        }

        /* ==========================================
           3. DRAWER UNIFICADO (Panel Móvil y Perfil)
        ========================================== */
        .drawer-overlay {
            position: fixed; inset: 0; background: rgba(15, 23, 42, 0.4);
            backdrop-filter: blur(4px); z-index: 1050; opacity: 0; pointer-events: none;
            transition: opacity 0.3s ease;
        }
        .drawer-overlay.open { opacity: 1; pointer-events: all; }

        .drawer {
            position: fixed; top: 0; right: 0; bottom: 0;
            width: 340px; max-width: 85vw; background: white; z-index: 1060;
            transform: translateX(100%); transition: transform 0.35s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex; flex-direction: column; box-shadow: -8px 0 30px rgba(0,0,0,.1);
        }
        .drawer.open { transform: translateX(0); }

        .drawer-head { background: var(--grad-nav); padding: 24px 20px; position: relative; }
        .drawer-close {
            position: absolute; top: 16px; right: 16px;
            background: rgba(255,255,255,.2); border: none; border-radius: 50%;
            width: 32px; height: 32px; color: white; font-size: 18px; cursor: pointer;
            transition: background 0.2s; display: flex; align-items: center; justify-content: center;
        }
        .drawer-close:hover { background: rgba(255,255,255,.35); }

        .drawer-avatar-big {
            width: 64px; height: 64px; border-radius: 50%; background: white; color: var(--teal-600);
            font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 800; font-size: 22px;
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 12px; border: 3px solid rgba(255,255,255,.5);
        }
        .drawer-name { font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 700; font-size: 18px; color: white; }
        .drawer-role { font-size: 13px; color: rgba(255,255,255,.8); }

        .drawer-body { flex: 1; overflow-y: auto; padding: 16px; }
        .drawer-section-label {
            font-size: 11px; font-weight: 800; letter-spacing: 1px;
            text-transform: uppercase; color: var(--neutral-400); margin: 16px 0 8px 8px;
        }
        
        .drawer-item {
            display: flex; align-items: center; gap: 12px; padding: 10px 12px;
            border-radius: 10px; color: var(--neutral-800); font-size: 14.5px; font-weight: 600;
            text-decoration: none; transition: background 0.2s; border: none; width: 100%; text-align: left; background: transparent;
        }
        .drawer-item:hover { background: var(--neutral-100); color: var(--teal-700); }
        .drawer-item-icon {
            width: 34px; height: 34px; border-radius: 8px;
            display: flex; align-items: center; justify-content: center; font-size: 16px;
        }
        
        .icon-teal { background: var(--teal-50); color: var(--teal-600); }
        .icon-sky { background: var(--sky-50); color: var(--sky-600); }
        .icon-purple { background: #f3f0ff; color: #7c3aed; }
        .drawer-divider { height: 1px; background: var(--neutral-200); margin: 12px 0; }

        .drawer-foot { padding: 16px; border-top: 1px solid var(--neutral-100); }
        .btn-logout-drawer {
            display: flex; align-items: center; justify-content: center; gap: 8px;
            width: 100%; padding: 12px; border-radius: 10px;
            background: #fef2f2; border: 1px solid #fecaca; color: #ef4444; font-size: 14px; font-weight: 700;
            cursor: pointer; transition: background 0.2s;
        }
        .btn-logout-drawer:hover { background: #fee2e2; }

        /* ==========================================
           4. RESPONSIVE Y CONTENIDO
        ========================================== */
        main { flex: 1; padding: 0; }
        footer { background: white; border-top: 1px solid var(--neutral-200); padding: 24px 0; text-align: center; }
        .footer-brand { font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 800; background: var(--grad-main); -webkit-background-clip: text; -webkit-text-fill-color: transparent; font-size: 15px; margin-bottom: 4px; }
        footer p { color: var(--neutral-400); font-size: 13px; margin: 0; }

        /* Móviles y Tablets: El Navbar superior desaparece y todo va al Drawer */
        @media (max-width: 991px) {
            .topbar { grid-template-columns: 1fr auto; height: 70px; padding: 0 1rem; }
            .nav-links { display: none; } /* Ocultamos los links centrales */
            .btn-perfil { display: none; } /* Ocultamos el avatar (ya está en el drawer) */
            .nav-toggler { display: block; } /* Mostramos el botón hamburguesa unificado */
            .desktop-only { display: none !important; }
        }
        @media (min-width: 992px) {
            .mobile-only { display: none !important; }
        }
    </style>
</head>
<body>

    <div class="drawer-overlay" id="drawerOverlay"></div>

    <aside class="drawer" id="sideDrawer" role="dialog" aria-modal="true">
        @auth
            <div class="drawer-head">
                <button class="drawer-close" id="drawerClose"><i class="bi bi-x-lg"></i></button>
                <div class="drawer-avatar-big">
                    {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                </div>
                <div class="drawer-name">{{ auth()->user()->name }}</div>
                <div class="drawer-role">
                    {{ auth()->user()->rol_id == 3 ? 'Administrador' : 'Usuario' }}
                </div>
            </div>

            <div class="drawer-body">
                <div class="mobile-only">
                    <div class="drawer-section-label">Menú Principal</div>
                    <a class="drawer-item" href="{{ route('home') }}">
                        <span class="drawer-item-icon icon-teal"><i class="bi bi-house-door"></i></span> Inicio
                    </a>
                    <a class="drawer-item" href="{{ route('asistencia.index') }}">
                        <span class="drawer-item-icon icon-sky"><i class="bi bi-calendar-check"></i></span> Asistencia
                    </a>
                    <a class="drawer-item" href="{{ route('estadisticas.dashboard') }}">
                        <span class="drawer-item-icon icon-purple"><i class="bi bi-graph-up-arrow"></i></span> Estadísticas
                    </a>
                    <div class="drawer-divider"></div>
                </div>

                <div class="drawer-section-label">Mi Cuenta</div>
                <a class="drawer-item" href="{{ route('profile.edit') ?? '#' }}">
                    <span class="drawer-item-icon icon-teal"><i class="bi bi-person-fill"></i></span> Gestionar Perfil
                </a>

                <div class="drawer-divider"></div>

                <div class="drawer-section-label">Programas Sociales</div>
                @if(isset($programas) && $programas->count() > 0)
                    @foreach($programas as $p)
                        <a class="drawer-item" href="{{ route('frontend.programas.show', $p->id) }}">
                            <span class="drawer-item-icon icon-teal"><i class="bi bi-folder2-open"></i></span> {{ $p->nombre }}
                        </a>
                    @endforeach
                @else
                    <p class="text-muted small ms-2 mt-2">No hay programas cargados.</p>
                @endif

                @if(auth()->user()->rol_id == 3)
                    <div class="drawer-divider"></div>
                    <a class="drawer-item" href="{{ route('admin.home') }}">
                        <span class="drawer-item-icon icon-purple"><i class="bi bi-gear-fill"></i></span> Panel de Administración
                    </a>
                @endif
            </div>

            <div class="drawer-foot">
                <form action="{{ route('logout') }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit" class="btn-logout-drawer">
                        <i class="bi bi-box-arrow-right"></i> Cerrar Sesión
                    </button>
                </form>
            </div>
        @endauth
    </aside>

    <nav class="topbar" id="mainNav">
        <div class="nav-brand-wrapper">
            <a class="nav-brand" href="{{ route('home') }}">
                <div class="nav-brand-icon"><i class="bi bi-heart-pulse-fill"></i></div>
                <div class="nav-brand-text">
                    <span>Comunidad</span>
                    <span>Gestión Social</span>
                </div>
            </a>
        </div>

        <ul class="nav-links">
            <li>
                <a href="{{ route('home') }}" @class(['active' => request()->routeIs('home')])>
                    <i class="bi bi-house-door"></i> Inicio
                </a>
            </li>
            <li>
                <a href="{{ route('asistencia.index') }}" @class(['active' => request()->routeIs('asistencia.*')])>
                    <i class="bi bi-calendar-check"></i> Asistencia
                </a>
            </li>
            <li>
                <a href="{{ route('estadisticas.dashboard') }}" class="btn-estadisticas-mid @if(request()->routeIs('estadisticas.*')) active @endif">
                    <i class="bi bi-graph-up-arrow"></i> Estadísticas
                </a>
            </li>
        </ul>

        <div class="nav-actions">
            @auth 
                <button class="btn-perfil desktop-only" id="openDrawer" title="{{ auth()->user()->name }}">
                    {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                </button>
            @else
                <a href="{{ route('login') }}" class="btn-nav-login" style="background:white; color:var(--teal-600); padding:8px 18px; border-radius:10px; text-decoration:none; font-weight:700;">
                    <i class="bi bi-box-arrow-in-right"></i> Ingresar
                </a>
            @endauth
            
            <button class="nav-toggler" id="navToggler"><i class="bi bi-list"></i></button>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer>
        <div class="container">
            <div class="footer-brand"><i class="bi bi-heart-pulse-fill me-1"></i> Comunidad</div>
            <p>&copy; {{ date('Y') }} Secretaría de Desarrollo Humano. Innovación Social.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const drawer = document.getElementById('sideDrawer');
            const overlay = document.getElementById('drawerOverlay');
            const openBtn = document.getElementById('openDrawer'); // Avatar Desktop
            const navToggler = document.getElementById('navToggler'); // Hamburguesa Móvil
            const closeBtn = document.getElementById('drawerClose');

            // Función unificada para abrir/cerrar el Drawer
            const toggleDrawer = (forceState) => {
                const isOpen = forceState !== undefined ? forceState : !drawer.classList.contains('open');
                drawer.classList.toggle('open', isOpen);
                overlay.classList.toggle('open', isOpen);
                document.body.style.overflow = isOpen ? 'hidden' : '';
            };

            if (openBtn) openBtn.addEventListener('click', () => toggleDrawer(true));
            if (navToggler) navToggler.addEventListener('click', () => toggleDrawer(true));
            if (closeBtn) closeBtn.addEventListener('click', () => toggleDrawer(false));
            if (overlay) overlay.addEventListener('click', () => toggleDrawer(false));

            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape' && drawer && drawer.classList.contains('open')) toggleDrawer(false);
            });
        });
    </script>
    @stack('scripts')
</body>
</html>