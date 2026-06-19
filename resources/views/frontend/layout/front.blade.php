<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Comunidad | @yield('title')</title>

    <link rel="icon" href="{{ asset('assets/img/sn.png') }}" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        /* ==========================================
           1. VARIABLES GLOBALES Y COLORES
        ========================================== */
        :root {
            --teal-50:   #e8f9f5; --teal-100: #c2eee3; --teal-300: #5dc9a8;
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
            height: 76px;
            position: sticky;
            top: 0;
            z-index: 1040;
            box-shadow: var(--shadow-md);
            padding: 0 1.5rem;
            display: grid;
            grid-template-columns: 1fr auto 1fr;
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

        .nav-links .btn-estadisticas-mid {
            background: rgba(255,255,255,.08);
            border: 1px solid rgba(255,255,255,.2);
        }
        .nav-links .btn-estadisticas-mid:hover {
            background: white; color: var(--teal-700); border-color: white;
        }

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
            background: transparent; border: none; 
            width: 32px; height: 32px; color: white; font-size: 20px; cursor: pointer;
            transition: all 0.2s; display: flex; align-items: center; justify-content: center;
            border-radius: 0;
        }
        .drawer-close:hover { 
            background: transparent;
            opacity: 0.8;
        }

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
        .icon-info { background: #dbeafe; color: #0369a1; }
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
           4. RESPONSIVE Y CONTENIDO (MAIN)
        ========================================== */
        main { flex: 1; padding: 0; }

        /* ==========================================
           MEJORAS EXCLUSIVAS DEL FOOTER
        ========================================== */
        footer { 
            background: white; 
            border-top: 1px solid var(--neutral-200); 
            padding: 35px 0 20px 0; 
        }
        .footer-brand { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            font-weight: 800; 
            background: var(--grad-main); 
            -webkit-background-clip: text; 
            -webkit-text-fill-color: transparent; 
            font-size: 18px; 
            margin-bottom: 4px;
            display: inline-flex;
            align-items: center;
        }
        .footer-brand i {
            background: var(--grad-main);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .footer-subtitle {
            font-size: 12.5px;
            color: var(--neutral-600);
            font-weight: 600;
            line-height: 1.5;
            margin: 0;
        }
        .footer-info-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            color: var(--neutral-600);
            margin-bottom: 6px;
            font-weight: 500;
        }
        .footer-info-item:last-child {
            margin-bottom: 0;
        }
        .footer-info-item i {
            color: var(--sky-500);
            font-size: 14px;
        }
        .footer-info-item a {
            color: var(--neutral-600);
            text-decoration: none;
            transition: color 0.2s ease;
        }
        .footer-info-item a:hover {
            color: var(--teal-500);
        }
        .footer-divider {
            height: 1px;
            background: var(--neutral-200);
            margin: 20px 0 15px 0;
            opacity: 0.6;
        }
        .footer-copyright { 
            color: var(--neutral-400); 
            font-size: 12px; 
            margin: 0; 
            font-weight: 500;
        }

        /* ==========================================
           5. MODAL INFORMACIÓN DEL SISTEMA
        ========================================== */
        .modal-header {
            background: var(--grad-nav);
            border: none;
            padding: 24px 24px;
        }
        .modal-header .btn-close {
            filter: invert(1) brightness(200%);
        }
        .modal-title {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 700;
            color: white;
            font-size: 18px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .modal-body {
            padding: 28px 24px;
        }
        .info-section {
            margin-bottom: 28px;
        }
        .info-section:last-child {
            margin-bottom: 0;
        }
        .info-section-title {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 700;
            color: var(--teal-600);
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .info-item {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 10px 0;
            font-size: 14px;
            line-height: 1.6;
            color: var(--neutral-600);
        }
        .info-item-label {
            font-weight: 600;
            color: var(--neutral-800);
            min-width: 140px;
        }
        .info-item-value {
            flex: 1;
            color: var(--neutral-600);
        }
        .dev-card {
            background: var(--neutral-50);
            border: 1px solid var(--neutral-200);
            border-radius: 12px;
            padding: 14px;
            margin-bottom: 10px;
            transition: all 0.2s;
        }
        .dev-card:hover {
            background: var(--sky-50);
            border-color: var(--sky-300);
        }
        .dev-name {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 700;
            color: var(--teal-600);
            font-size: 14px;
        }
        .dev-role {
            font-size: 12px;
            color: var(--neutral-400);
            margin-top: 2px;
        }

        /* Móviles y Tablets */
        @media (max-width: 991px) {
            .topbar { grid-template-columns: 1fr auto; height: 70px; padding: 0 1rem; }
            .nav-links { display: none; }
            .btn-perfil { display: none; }
            .nav-toggler { display: block; }
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
                <button class="drawer-close" id="drawerClose"><i class="bi bi-list"></i></button>
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

                <div class="drawer-divider"></div>
                <button class="drawer-item" id="btnSysInfo" style="cursor: pointer;">
                    <span class="drawer-item-icon icon-info"><i class="bi bi-info-circle-fill"></i></span> Información del Sistema
                </button>
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

    {{-- FOOTER RESTRUCTURADO Y MEJORADO --}}
    <footer>
        <div class="container">
            <div class="row align-items-center row-gap-3">
                <div class="col-12 col-md-7 text-center text-md-start">
                    <div class="footer-brand">
                        <i class="bi bi-heart-pulse-fill me-2"></i>Comunidad
                    </div>
                    <p class="footer-subtitle">
                        Secretaría de Desarrollo Humano &bull; Secretaría de Innovación y Ciudad Inteligente
                    </p>
                </div>
                
                <div class="col-12 col-md-5 d-flex flex-column align-items-center align-items-md-end text-center text-md-end">
                    <div class="footer-info-item">
                        <i class="bi bi-geo-alt-fill"></i>
                        <span>Lazarte y Brown, San Nicolás de los Arroyos</span>
                    </div>
                    <div class="footer-info-item">
                        <i class="bi bi-envelope-fill"></i>
                        <a href="mailto:sndesarrollohumano@gmail.com">sndesarrollohumano@gmail.com</a>
                    </div>
                </div>
            </div>
            
            <div class="footer-divider"></div>
            
            <div class="row">
                <div class="col-12 text-center">
                    <p class="footer-copyright">
                        &copy; {{ date('Y') }} Municipalidad de San Nicolás de los Arroyos. Todos los derechos reservados.
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <div class="modal fade" id="sysInfoModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-info-circle-fill"></i> Información del Sistema
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <div class="info-section">
                        <div class="info-section-title">
                            <i class="bi bi-cpu"></i> Sistema
                        </div>
                        <div class="info-item">
                            <span class="info-item-label">Nombre:</span>
                            <span class="info-item-value">Comunidad - Gestión Social</span>
                        </div>
                        <div class="info-item">
                            <span class="info-item-label">Versión:</span>
                            <span class="info-item-value">2.1.0</span>
                        </div>
                        <div class="info-item">
                            <span class="info-item-label">Última actualización:</span>
                            <span class="info-item-value">Junio 2024</span>
                        </div>
                        <div class="info-item">
                            <span class="info-item-label">Institución:</span>
                            <span class="info-item-value">Secretaría de Desarrollo Humano<br>Municipalidad de San Nicolás de los Arroyos</span>
                        </div>
                    </div>

                    <div class="info-section">
                        <div class="info-section-title">
                            <i class="bi bi-bookmark"></i> Descripción
                        </div>
                        <div class="info-item">
                            <span class="info-item-value">
                                Plataforma integral de gestión social diseñada para fortalecer el seguimiento y la coordinación de programas y beneficiarios del Desarrollo Humano en San Nicolás de los Arroyos. Facilita la administración de asistencia, estadísticas y grupos familiares con un enfoque colaborativo e innovador.
                            </span>
                        </div>
                    </div>

                    <div class="info-section">
                        <div class="info-section-title">
                            <i class="bi bi-people"></i> Dirigido a
                        </div>
                        <div class="info-item">
                            <span class="info-item-value">
                                Gestores y coordinadores de programas sociales, personal administrativo de la Secretaría de Desarrollo Humano, y professionals del área de intervención social.
                            </span>
                        </div>
                    </div>

                    <div class="info-section">
                        <div class="info-section-title">
                            <i class="bi bi-code-square"></i> Stack Tecnológico
                        </div>
                        <div class="info-item">
                            <span class="info-item-label">Backend:</span>
                            <span class="info-item-value">Laravel 11, PHP 8.2+</span>
                        </div>
                        <div class="info-item">
                            <span class="info-item-label">Frontend:</span>
                            <span class="info-item-value">Bootstrap 5.3, Tailwind CSS</span>
                        </div>
                        <div class="info-item">
                            <span class="info-item-label">Base de datos:</span>
                            <span class="info-item-value">MySQL / PostgreSQL</span>
                        </div>
                        <div class="info-item">
                            <span class="info-item-label">Interactividad:</span>
                            <span class="info-item-value">Alpine.js</span>
                        </div>
                    </div>

                    <div class="info-section">
                        <div class="info-section-title">
                            <i class="bi bi-building"></i> Desarrollado por
                        </div>
                        <div class="dev-card">
                            <div class="dev-name">Cian & Vílchez - Studio de Desarrollo</div>
                            <div class="dev-role">Análisis, diseño e implementación integral</div>
                        </div>
                        <div class="dev-card">
                            <div class="dev-name">Juan Segundo Cian</div>
                            <div class="dev-role">Full-Stack Developer · juansegundocian@gmail.com</div>
                        </div>
                        <div class="dev-card">
                            <div class="dev-name">Hernán Vílchez</div>
                            <div class="dev-role">Full-Stack Developer</div>
                        </div>
                    </div>

                    <div class="info-section">
                        <div class="info-section-title">
                            <i class="bi bi-chat-dots"></i> Soporte y Contacto
                        </div>
                        <div class="info-item">
                            <span class="info-item-label">Email:</span>
                            <span class="info-item-value">juansegundocian@gmail.com</span>
                        </div>
                        <div class="info-item">
                            <span class="info-item-label">Institución:</span>
                            <span class="info-item-value">Secretaría de Desarrollo Humano<br>San Nicolás de los Arroyos, Argentina</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const drawer = document.getElementById('sideDrawer');
            const overlay = document.getElementById('drawerOverlay');
            const openBtn = document.getElementById('openDrawer');
            const navToggler = document.getElementById('navToggler');
            const closeBtn = document.getElementById('drawerClose');
            const btnSysInfo = document.getElementById('btnSysInfo');
            const sysInfoModal = new bootstrap.Modal(document.getElementById('sysInfoModal'));

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

            if (btnSysInfo) {
                btnSysInfo.addEventListener('click', () => {
                    sysInfoModal.show();
                });
            }

            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape' && drawer && drawer.classList.contains('open')) toggleDrawer(false);
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if(session('success'))
    <script>
    Swal.fire({
        toast: true,
        position: 'top-end',
        icon: 'success',
        title: @json(session('success')),
        showConfirmButton: false,
        timer: 3500,
        timerProgressBar: true
    });
    </script>
    @endif

    @if(session('warning'))
    <script>
    Swal.fire({
        toast: true,
        position: 'top-end',
        icon: 'warning',
        title: @json(session('warning')),
        showConfirmButton: false,
        timer: 4000,
        timerProgressBar: true
    });
    </script>
    @endif

    @if(session('error'))
    <script>
    Swal.fire({
        toast: true,
        position: 'top-end',
        icon: 'error',
        title: @json(session('error')),
        showConfirmButton: false,
        timer: 4000,
        timerProgressBar: true
    });
    </script>
    @endif
    @stack('scripts')
</body>
</html>