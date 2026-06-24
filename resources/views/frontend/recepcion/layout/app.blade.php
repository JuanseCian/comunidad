<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Recepción | @yield('title')</title>

    <link rel="icon" href="{{ asset('assets/img/sn.png') }}" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Nunito:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
            overflow-x: hidden;
        }

        /* OVERLAY MÓVIL */
        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(15, 23, 42, 0.4);
            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);
            z-index: 998;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .sidebar-overlay.show {
            opacity: 1;
            visibility: visible;
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
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
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
            overflow-y: auto;
            flex-grow: 1;
            margin-bottom: 20px;
        }

        .sidebar-links::-webkit-scrollbar { width: 4px; }
        .sidebar-links::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.2); border-radius: 4px; }

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

        /* PANEL INFERIOR (Info + Logout) */
        .sidebar-footer {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .info-btn {
            width: 100%;
            border: 1px solid rgba(255, 255, 255, 0.2);
            background: rgba(255, 255, 255, 0.08);
            color: white;
            padding: 11px;
            border-radius: var(--radius-md);
            transition: all .2s;
            font-weight: 600;
            font-size: 13.5px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            cursor: pointer;
        }

        .info-btn:hover {
            background: rgba(255, 255, 255, 0.18);
        }

        .logout-form { margin: 0; }

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
            transition: margin 0.3s ease;
        }

        /* TOPBAR */
        .topbar {
            background: rgba(255, 255, 255, .8);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border: 1px solid rgba(255, 255, 255, .6);
            border-radius: var(--radius-xl);
            padding: 16px 24px;
            margin-bottom: 26px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: var(--shadow-md);
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .menu-toggle {
            display: none;
            background: var(--neutral-100);
            border: none;
            color: var(--neutral-800);
            padding: 8px 12px;
            border-radius: var(--radius-sm);
            cursor: pointer;
            transition: background 0.2s;
        }

        .menu-toggle:hover {
            background: var(--neutral-200);
        }

        .topbar-title h4 {
            margin: 0;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 700;
            color: var(--neutral-900);
            font-size: 1.25rem;
        }

        .topbar-title p {
            margin: 2px 0 0;
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
            gap: 6px;
        }

        .content {
            animation: fade .25s ease;
        }

        @keyframes fade {
            from { opacity: 0; transform: translateY(6px); }
            to { opacity: 1; transform: translateY(0); }
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

        /* ==========================================
           MODAL INFORMACIÓN DEL SISTEMA (Estilos Premium)
        ========================================== */
        #sysInfoModal .modal-content {
            border-radius: 20px;
            border: none;
            box-shadow: var(--shadow-lg);
            overflow: hidden;
            background: #ffffff;
        }
        #sysInfoModal .modal-header {
            background: var(--grad-nav);
            border: none;
            padding: 24px 28px;
            position: relative;
        }
        #sysInfoModal .modal-title {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 800;
            color: white;
            font-size: 20px;
            letter-spacing: -0.3px;
        }
        #sysInfoModal .modal-header .btn-close {
            filter: invert(1) brightness(200%);
            opacity: 0.8;
            transition: all 0.2s;
        }
        #sysInfoModal .modal-header .btn-close:hover {
            opacity: 1;
            transform: scale(1.1);
        }
        #sysInfoModal .modal-body {
            padding: 32px 28px;
            background: #fdfefe;
        }
        .info-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 24px;
        }
        @media (min-width: 768px) {
            .info-grid { grid-template-columns: repeat(2, 1fr); }
            .info-section.full-width { grid-column: span 2; }
        }
        .info-section {
            background: white;
            border: 1px solid var(--neutral-200);
            border-radius: 16px;
            padding: 20px;
            box-shadow: var(--shadow-sm);
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .info-section:hover { box-shadow: 0 6px 16px rgba(0,0,0,.03); }
        .info-section-title {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 800;
            color: var(--teal-600);
            font-size: 13.5px;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 10px;
            border-bottom: 2px solid var(--teal-50);
            padding-bottom: 8px;
        }
        .info-section-title i { font-size: 16px; }
        .info-item {
            display: flex;
            flex-direction: column;
            gap: 4px;
            padding: 8px 0;
            font-size: 14.5px;
            border-bottom: 1px dashed var(--neutral-100);
        }
        .info-item:last-child { border-bottom: none; padding-bottom: 0; }
        
        @media (min-width: 480px) {
            .info-item { flex-direction: row; align-items: flex-start; gap: 12px; }
            .info-item-label { min-width: 130px; max-width: 130px; margin-bottom: 0; }
        }
        .info-item-label { font-weight: 700; color: var(--neutral-800); }
        .info-item-value { flex: 1; color: var(--neutral-600); line-height: 1.5; }
        .info-text-block { color: var(--neutral-600); font-size: 14.5px; line-height: 1.6; margin: 0; }
        
        .dev-cards-container { display: grid; grid-template-columns: 1fr; gap: 12px; }
        @media (min-width: 576px) {
            .dev-cards-container { grid-template-columns: repeat(2, 1fr); }
            .dev-card.studio-card { grid-column: span 2; }
        }
        .dev-card {
            background: var(--neutral-50);
            border: 1px solid var(--neutral-200);
            border-radius: 12px;
            padding: 16px;
            display: flex;
            align-items: center;
            gap: 14px;
            transition: all 0.25s ease;
        }
        .dev-card:hover {
            background: var(--sky-50);
            border-color: var(--sky-300);
            transform: translateY(-2px);
        }
        .dev-icon-box {
            width: 40px; height: 40px; border-radius: 10px;
            display: flex; align-items: center; justify-content: center; font-size: 18px;
        }
        .dev-info { flex: 1; }
        .dev-name { font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 700; color: var(--neutral-800); font-size: 14.5px; line-height: 1.2; }
        .dev-role { font-size: 12.5px; color: var(--neutral-600); margin-top: 4px; font-weight: 500; }
        
        .icon-teal { background: var(--teal-50); color: var(--teal-600); }
        .icon-sky { background: var(--sky-50); color: var(--sky-600); }
        .icon-purple { background: #f3f0ff; color: #7c3aed; }

        /* MOBILE RESPONSIVE GENERAL */
        @media(max-width: 992px) {
            .sidebar {
                transform: translateX(-100%);
                width: 280px;
                border-radius: 0 24px 24px 0;
            }
            .sidebar.show { transform: translateX(0); }
            .main { margin-left: 0; padding: 16px; }
            .menu-toggle { display: block; }
            .topbar { padding: 14px 16px; border-radius: var(--radius-lg); }
            .topbar-badge { display: none; }
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

    {{-- OVERLAY PARA MÓVILES --}}
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    {{-- SIDEBAR --}}
    <aside class="sidebar" id="sidebar">
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
                <a href="{{ route('recepcion.dashboard') }}" class="{{ request()->routeIs('recepcion.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-house-door-fill"></i> Inicio
                </a>
                <a href="{{ route('recepcion.ingresos.index') }}" class="{{ request()->routeIs('recepcion.ingresos.*') ? 'active' : '' }}">
                    <i class="bi bi-journal-text"></i> Ingresos
                </a>
                <a href="{{ route('recepcion.mercaderias.index') }}" class="{{ request()->routeIs('recepcion.mercaderias.*') ? 'active' : '' }}">
                    <i class="bi bi-box-seam"></i> Mercadería
                </a>
                <a href="{{ route('recepcion.sepelios.index') }}" class="{{ request()->routeIs('recepcion.sepelios.*') ? 'active' : '' }}">
                    <i class="bi bi-heartbreak"></i> Sepelios
                </a>
                <a href="{{ route('bajo-peso.index') }}" class="{{ request()->routeIs('bajo.*') ? 'active' : '' }}">
                    <i class="bi bi-people-fill"></i> Bajo peso
                </a>
                <a href="{{ route('estadisticas.dashboard') }}" class="{{ request()->routeIs('frontend.estadisticas.*') ? 'active' : '' }}">
                    <i class="bi bi-bar-chart-line-fill"></i> Estadísticas
                </a>
            </div>
        </div>

        {{-- FOOTER DEL SIDEBAR --}}
        <div class="sidebar-footer">
            {{-- INFO DEL SISTEMA --}}
            <button class="info-btn" id="btnSysInfo">
                <i class="bi bi-info-circle"></i> Info del Sistema
            </button>

            {{-- LOGOUT --}}
            <form action="{{ route('logout') }}" method="POST" class="logout-form">
                @csrf
                <button class="logout-btn" type="submit">
                    <i class="bi bi-box-arrow-right"></i> Cerrar sesión
                </button>
            </form>
        </div>
    </aside>

    {{-- MAIN --}}
    <main class="main">

        {{-- TOPBAR --}}
        <div class="topbar">
            <div class="topbar-left">
                <button class="menu-toggle" id="menuToggleBtn">
                    <i class="bi bi-list fs-4"></i>
                </button>
                <div class="topbar-title">
                    <h4>@yield('title', 'Panel Principal')</h4>
                    <p>Gestión de Recepción</p>
                </div>
            </div>

            <div class="topbar-badge">
                <i class="bi bi-person-circle"></i>
                <span>{{ Auth::user()->nombre ?? 'Usuario' }}</span>
            </div>
        </div>

        {{-- CONTENT --}}
        <div class="content">
            @yield('content')
        </div>

        {{-- FOOTER --}}
        <footer>
            <h6>Comunidad • Mesa de Entrada</h6>
            <p>Secretaría de Desarrollo Humano • Secretaría de Innovación y Ciudad Inteligente</p>
            <p>© {{ date('Y') }} Municipalidad de San Nicolás de los Arroyos</p>
        </footer>

    </main>

    <!-- MODAL PREMIUM TOTALMENTE INTEGRADO -->
    <div class="modal fade" id="sysInfoModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-info-circle-fill me-2"></i>Información del Sistema
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <div class="info-grid">
                        
                        <!-- SECCIÓN SISTEMA -->
                        <div class="info-section">
                            <div class="info-section-title">
                                <i class="bi bi-cpu"></i>Especificaciones
                            </div>
                            <div class="info-item">
                                <span class="info-item-label">Nombre:</span>
                                <span class="info-item-value">Comunidad</span>
                            </div>
                            <div class="info-item">
                                <span class="info-item-label">Versión:</span>
                                <span class="info-item-value">1.0.0</span>
                            </div>
                            <div class="info-item">
                                <span class="info-item-label">Institución:</span>
                                <span class="info-item-value">Secretaría de Desarrollo Humano / Municipalidad de San Nicolás</span>
                            </div>
                        </div>

                        <!-- SECCIÓN STACK -->
                        <div class="info-section">
                            <div class="info-section-title">
                                <i class="bi bi-code-square"></i>Stack Tecnológico
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
                                <span class="info-item-label">Base de Datos:</span>
                                <span class="info-item-value">MySQL / PostgreSQL</span>
                            </div>
                            <div class="info-item">
                                <span class="info-item-label">Interactividad:</span>
                                <span class="info-item-value">Alpine.js</span>
                            </div>
                        </div>

                        <!-- SECCIÓN DESCRIPCIÓN -->
                        <div class="info-section full-width">
                            <div class="info-section-title">
                                <i class="bi bi-bookmark"></i>Propósito de la Plataforma
                            </div>
                            <p class="info-text-block">
                                Plataforma de gestión social diseñada para fortalecer el seguimiento y la coordinación de programas y beneficiarios del área de <strong>Comunidad</strong>, a cargo de la Directora de Comunidad (Cordisco, María Laura) bajo la gestion de la <strong>Secretaría de Desarrollo Humano</strong> a cargo de la Sec. Mendez, María en San Nicolás de los Arroyos. Facilita la administración de asistencia, estadísticas y grupos familiares con un enfoque colaborativo e innovador, dirigido a gestores, coordinadores y profesionales del área de intervención social.
                            </p>
                        </div>

                        <!-- SECCIÓN DESARROLLADORES -->
                        <div class="info-section full-width">
                            <div class="info-section-title">
                                <i class="bi bi-building"></i>Equipo de Desarrollo y Diseño
                            </div>
                            <div class="dev-cards-container">
                                <div class="dev-card studio-card">
                                    <div class="dev-icon-box icon-purple"><i class="bi bi-rocket-takeoff-fill"></i></div>
                                    <div class="dev-info">
                                        <div class="dev-name">Cian & Vílchez - Studio de Desarrollo</div>
                                        <div class="dev-role">Análisis, diseño e implementación integral</div>
                                    </div>
                                </div>
                                <div class="dev-card">
                                    <div class="dev-icon-box icon-teal"><i class="bi bi-person-badge-fill"></i></div>
                                    <div class="dev-info">
                                        <div class="dev-name">Juan Segundo Cian</div>
                                        <div class="dev-role">Analista en Sistemas · Full-Stack Developer</div>
                                    </div>
                                </div>
                                <div class="dev-card">
                                    <div class="dev-icon-box icon-sky"><i class="bi bi-person-badge-fill"></i></div>
                                    <div class="dev-info">
                                        <div class="dev-name">Hernán Vílchez</div>
                                        <div class="dev-role">Analista en Sistemas · Full-Stack Developer</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- SECCIÓN SOPORTE -->
                        <div class="info-section full-width">
                            <div class="info-section-title">
                                <i class="bi bi-chat-dots"></i>Soporte Técnico y Contacto
                            </div>
                            <div class="info-item">
                                <span class="info-item-label">Email Oficial:</span>
                                <span class="info-item-value">
                                    <a href="mailto:sndesarrollohumano@gmail.com" class="text-decoration-none fw-bold" style="color: var(--teal-600);">sndesarrollohumano@gmail.com</a>
                                </span>
                            </div>
                            <div class="info-item">
                                <span class="info-item-label">Ubicación:</span>
                                <span class="info-item-value">Secretaría de Desarrollo Humano &bull; San Nicolás de los Arroyos, Argentina</span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    {{-- LÓGICA DE INTERFAZ (Sidebar + Modal Trigger) --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const menuBtn = document.getElementById('menuToggleBtn');
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            const btnSysInfo = document.getElementById('btnSysInfo');
            const sysInfoModal = new bootstrap.Modal(document.getElementById('sysInfoModal'));

            function toggleMenu(forceState) {
                const show = forceState !== undefined ? forceState : !sidebar.classList.contains('show');
                sidebar.classList.toggle('show', show);
                overlay.classList.toggle('show', show);
            }

            menuBtn.addEventListener('click', () => toggleMenu());
            overlay.addEventListener('click', () => toggleMenu(false));

            btnSysInfo.addEventListener('click', () => {
                toggleMenu(false);
                setTimeout(() => {
                    sysInfoModal.show();
                }, 300);
            });
        });
    </script>

    @stack('scripts')

<div class="toast-container position-fixed top-0 end-0 p-4" style="z-index: 1090;">
    
    @if(session('success') || session('status'))
        <div id="liveToast" class="custom-toast toast-success" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-glow-bg"></div>
            <div class="toast-body-content">
                <div class="toast-icon-wrapper">
                    <i class="bi bi-check-circle-fill"></i>
                </div>
                <div class="toast-text">
                    <h6>¡Operación Exitosa!</h6>
                    <p>{{ session('success') ?? session('status') }}</p>
                </div>
                <button type="button" class="btn-close-toast" data-bs-dismiss="toast" aria-label="Close">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
        </div>
    @endif

    @if(session('error') || session('danger'))
        <div id="liveToast" class="custom-toast toast-danger" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-glow-bg"></div>
            <div class="toast-body-content">
                <div class="toast-icon-wrapper">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                </div>
                <div class="toast-text">
                    <h6>Ha ocurrido un error</h6>
                    <p>{{ session('error') ?? session('danger') }}</p>
                </div>
                <button type="button" class="btn-close-toast" data-bs-dismiss="toast" aria-label="Close">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
        </div>
    @endif

    @if(session('warning'))
        <div id="liveToast" class="custom-toast toast-warning" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-glow-bg"></div>
            <div class="toast-body-content">
                <div class="toast-icon-wrapper">
                    <i class="bi bi-exclamation-circle-fill"></i>
                </div>
                <div class="toast-text">
                    <h6>Atención Requerida</h6>
                    <p>{{ session('warning') }}</p>
                </div>
                <button type="button" class="btn-close-toast" data-bs-dismiss="toast" aria-label="Close">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
        </div>
    @endif

</div>

{{-- ESTILOS ULTRA-ILUMINADOS Y MODERNOS --}}
<style>
    @keyframes toastBounceIn {
        0% { transform: translateX(120%) scale(0.9); opacity: 0; }
        65% { transform: translateX(-10px) scale(1.02); opacity: 1; }
        85% { transform: translateX(4px) scale(0.99); }
        100% { transform: translateX(0) scale(1); }
    }

    @keyframes pulseGlow {
        0% { transform: scale(1); box-shadow: 0 0 0 0 var(--toast-pulse-color); }
        70% { transform: scale(1.05); box-shadow: 0 0 0 10px rgba(255, 255, 255, 0); }
        100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(255, 255, 255, 0); }
    }

    .custom-toast {
        background: rgba(255, 255, 255, 0.92) !important;
        backdrop-filter: blur(20px) !important;
        -webkit-backdrop-filter: blur(20px) !important;
        border-radius: 16px !important;
        width: 380px;
        position: relative;
        overflow: hidden;
        border: 1px solid var(--toast-border-color) !important;
        box-shadow: var(--toast-glow-shadow) !important;
        transition: all 0.3s ease;
    }

    .custom-toast.showing, .custom-toast.show {
        animation: toastBounceIn 0.6s cubic-bezier(0.25, 1, 0.5, 1) forwards;
    }

    .toast-glow-bg {
        position: absolute;
        top: -50px;
        left: -50px;
        width: 150px;
        height: 150px;
        background: var(--toast-pulse-color);
        filter: blur(60px);
        opacity: 0.15;
        pointer-events: none;
        z-index: 0;
    }

    .toast-body-content {
        padding: 20px;
        display: flex;
        align-items: center;
        gap: 16px;
        position: relative;
        z-index: 1;
    }

    .toast-icon-wrapper {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
        flex-shrink: 0;
        background: var(--toast-icon-bg);
        color: var(--toast-brand-color);
        animation: pulseGlow 2.5s infinite ease-in-out;
    }

    .toast-text {
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        gap: 3px;
    }

    .toast-text h6 {
        margin: 0;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 800;
        font-size: 0.98rem;
        color: #0f172a; 
        letter-spacing: -0.2px;
    }

    .toast-text p {
        margin: 0;
        font-size: 0.85rem;
        color: #475569;
        line-height: 1.4;
        font-weight: 500;
    }

    .btn-close-toast {
        background: transparent;
        border: none;
        color: #94a3b8;
        font-size: 1rem;
        cursor: pointer;
        padding: 6px;
        margin-top: -20px;
        margin-right: -10px;
        border-radius: 8px;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .btn-close-toast:hover {
        background: rgba(0, 0, 0, 0.05);
        color: #334155;
    }

    
    .toast-success {
        --toast-brand-color: #059669;
        --toast-icon-bg: #e6f4ea;
        --toast-border-color: rgba(16, 185, 129, 0.4);
        --toast-pulse-color: rgba(16, 185, 129, 0.4);
        --toast-glow-shadow: 0 15px 35px -5px rgba(16, 185, 129, 0.22), 0 5px 15px -3px rgba(16, 185, 129, 0.1), 0 0 0 1px rgba(16, 185, 129, 0.05);
    }

    .toast-danger {
        --toast-brand-color: #dc2626;
        --toast-icon-bg: #fce8e6;
        --toast-border-color: rgba(239, 68, 68, 0.4);
        --toast-pulse-color: rgba(239, 68, 68, 0.4);
        --toast-glow-shadow: 0 15px 35px -5px rgba(239, 68, 68, 0.22), 0 5px 15px -3px rgba(239, 68, 68, 0.1), 0 0 0 1px rgba(239, 68, 68, 0.05);
    }

    .toast-warning {
        --toast-brand-color: #d97706;
        --toast-icon-bg: #fef3c7;
        --toast-border-color: rgba(245, 158, 11, 0.4);
        --toast-pulse-color: rgba(245, 158, 11, 0.3);
        --toast-glow-shadow: 0 15px 35px -5px rgba(245, 158, 11, 0.22), 0 5px 15px -3px rgba(245, 158, 11, 0.1), 0 0 0 1px rgba(245, 158, 11, 0.05);
    }
</style>

{{-- DISPARADOR JAVASCRIPT AUTOMÁTICO --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toastElement = document.getElementById('liveToast');
        if (toastElement) {
            const toast = new bootstrap.Toast(toastElement, {
                delay: 5500 
            });
            toast.show();
        }
    });
</script>
</body>
</html>