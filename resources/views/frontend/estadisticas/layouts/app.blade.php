<!DOCTYPE html>
<html lang="es" data-bs-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comunidad | Estadísticas</title>
    <link rel="icon" href="{{ asset('assets/img/SN.png') }}" type="image/png">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        (function () {
            const savedTheme = localStorage.getItem('bi_theme') || 'light';
            document.documentElement.setAttribute('data-bs-theme', savedTheme);
        })();
    </script>

    <style>
        :root {
            --sidebar-width-expanded: 260px;
            --sidebar-width-collapsed: 78px;
            --sidebar-width: var(--sidebar-width-expanded);
            --bi-blue: #1e70e4;
            --bi-blue-hover: #1661cd;
            
            --bi-body-bg: #f8fafc;
            --bi-sidebar-bg: #ffffff;
            --bi-sidebar-border: #eaeef3;
            --bi-icon-bg: #f1f5f9;
            --bi-icon-color: #64748b;
            --bi-icon-hover-bg: #e2e8f0;
        }

        [data-bs-theme="dark"] {
            --bi-body-bg: #0b0f19;
            --bi-sidebar-bg: #111827;
            --bi-sidebar-border: #1f2937;
            --bi-icon-bg: #1f2937;
            --bi-icon-color: #9ca3af;
            --bi-icon-hover-bg: #374151;
        }

        body {
            background: var(--bi-body-bg);
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            transition: background 0.25s ease;
            overflow-x: hidden;
        }

        body.sidebar-collapsed {
            --sidebar-width: var(--sidebar-width-collapsed);
        }

        .stats-sidebar {
            width: var(--sidebar-width);
            min-height: 100vh;
            background: var(--bi-sidebar-bg);
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1040;
            border-right: 1px solid var(--bi-sidebar-border);
            transition: width 0.35s cubic-bezier(0.4, 0, 0.2, 1), transform 0.35s cubic-bezier(0.4, 0, 0.2, 1), background 0.25s ease, border-color 0.25s ease;
            overflow: hidden;
        }

        .stats-sidebar .nav-link {
            color: var(--bi-icon-color);
            padding: 10px 14px;
            margin: 4px 0 4px 12px;
            border-radius: 24px 0 0 24px;
            display: flex;
            align-items: center;
            font-weight: 500;
            font-size: 0.92rem;
            text-decoration: none;
            position: relative;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            white-space: nowrap;
        }

        .stats-sidebar .nav-link:not(.active):hover {
            color: var(--bi-blue);
            background: rgba(30, 112, 228, 0.04);
            transform: translateX(2px);
        }

        [data-bs-theme="dark"] .stats-sidebar .nav-link:not(.active):hover {
            background: rgba(30, 112, 228, 0.08);
        }

        .stats-sidebar .nav-link i.bi {
            min-width: 38px;
            height: 38px;
            font-size: 1.15rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: var(--bi-icon-bg);
            color: var(--bi-icon-color);
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .stats-sidebar .nav-link:hover i.bi {
            background: var(--bi-icon-hover-bg);
            color: var(--bi-blue);
            transform: scale(1.05);
        }

        .stats-sidebar .nav-link.active {
            color: var(--bi-blue) !important;
            background: rgba(30, 112, 228, 0.06);
            margin-left: 0;
            padding-left: 16px;
            font-weight: 600;
        }

        [data-bs-theme="dark"] .stats-sidebar .nav-link.active {
            background: rgba(30, 112, 228, 0.12);
        }

        .stats-sidebar .nav-link.active i.bi {
            background: var(--bi-blue);
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(30, 112, 228, 0.3);
            transform: scale(1);
        }

        .stats-sidebar .nav-link.active::before {
            content: "";
            position: absolute;
            left: 0;
            top: 6px;
            bottom: 6px;
            width: 4px;
            background: var(--bi-blue);
            border-radius: 0 4px 4px 0;
            animation: sidebarIndicatorIn 0.2s ease forwards;
        }

        @keyframes sidebarIndicatorIn {
            from { transform: scaleY(0); opacity: 0; }
            to { transform: scaleY(1); opacity: 1; }
        }

        .stats-sidebar .nav-link span,
        .stats-sidebar .sidebar-brand-text,
        .stats-sidebar .sidebar-footer-text {
            opacity: 1;
            visibility: visible;
            transition: opacity 0.2s ease, visibility 0.2s ease, width 0.3s ease, margin 0.3s ease;
        }

        body.sidebar-collapsed .stats-sidebar .nav-link span,
        body.sidebar-collapsed .stats-sidebar .sidebar-brand-text,
        body.sidebar-collapsed .stats-sidebar .sidebar-footer-text {
            opacity: 0;
            visibility: hidden;
            width: 0;
            overflow: hidden;
            margin: 0 !important;
            pointer-events: none;
        }

        .stats-sidebar .btn-logout-custom {
            transition: all 0.2s ease;
        }
        .stats-sidebar .btn-logout-custom:hover {
            background: rgba(239, 68, 68, 0.15) !important;
            transform: translateY(-1px);
        }

        .stats-wrapper {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            transition: margin-left 0.35s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            flex-direction: column;
        }

        .bi-top-header {
            background: var(--bi-sidebar-bg);
            border-bottom: 1px solid var(--bi-sidebar-border);
            padding: 10px 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: background 0.25s ease, border-color 0.25s ease;
        }

        .stats-content {
            padding: 2rem;
            flex-grow: 1;
        }

        @media (max-width: 991.98px) {
            .stats-sidebar {
                transform: translateX(-100%);
                width: var(--sidebar-width-expanded) !important;
            }
            body.sidebar-collapsed .stats-sidebar {
                transform: translateX(-100%);
            }
            .stats-sidebar.show {
                transform: translateX(0);
                box-shadow: 10px 0 30px rgba(0,0,0,0.15);
            }
            .stats-wrapper, body.sidebar-collapsed .stats-wrapper {
                margin-left: 0;
            }
        }

        /* ==========================================
           7. PRELOADER OPTIMIZADO (MÓDULO ESTADÍSTICAS)
        ========================================== */
        .page-preloader {
            position: fixed;
            inset: 0;
            background: var(--bi-sidebar-bg); /* Cambia dinámicamente según Light/Dark Mode */
            z-index: 99999;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 15px;
            opacity: 1;
            visibility: visible;
            transition: opacity 0.25s ease, visibility 0.25s ease;
        }

        .page-preloader.hidden {
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
        }

        .balls-container {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
        }

        .balls-container .ball {
            width: 14px;
            height: 14px;
            border-radius: 50%;
            animation: ball-bounce 1.4s infinite ease-in-out both;
        }

        /* Tonos coordinados con la identidad visual del panel analítico */
        .balls-container .ball:nth-child(1) {
            background: var(--bi-blue);
            animation-delay: -0.32s;
        }
        .balls-container .ball:nth-child(2) {
            background: #60a5fa; /* Azul complementario brillante */
            animation-delay: -0.16s;
        }
        .balls-container .ball:nth-child(3) {
            background: var(--bi-icon-color);
            animation-delay: 0s;
        }

        @keyframes ball-bounce {
            0%, 80%, 100% { 
                transform: scale(0);
                opacity: 0.3;
            } 
            40% { 
                transform: scale(1.1);
                opacity: 1;
            }
        }

        .preloader-text {
            font-family: 'Inter', sans-serif;
            font-weight: 600;
            font-size: 13px;
            color: var(--bi-icon-color);
            letter-spacing: 0.8px;
            text-transform: uppercase;
        }
    </style>
</head>

<body>

    <div class="page-preloader" id="pagePreloader">
        <div class="balls-container">
            <div class="ball"></div>
            <div class="ball"></div>
            <div class="ball"></div>
        </div>
        <div class="preloader-text">Procesando Métricas...</div>
    </div>

    @auth
        @if(auth()->user()->rol_id == 4)
            {{-- PANTALLA EXCLUSIVA DE BLOQUEO PARA ROL INACTIVO (4) --}}
            <div class="d-flex align-items-center justify-content-center vh-100" style="background: var(--bi-body-bg);">
                <div class="text-center p-5 border rounded-4 shadow-sm" style="max-width: 440px; background: var(--bi-sidebar-bg); border-color: var(--bi-sidebar-border) !important;">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-danger bg-opacity-10 text-danger mb-4" style="width: 65px; height: 65px;">
                        <i class="bi bi-shield-slash fs-2"></i>
                    </div>
                    <h4 class="fw-bold text-body mb-2">Acceso Denegado</h4>
                    <p class="text-muted small mb-4">Tu cuenta de usuario se encuentra en estado <strong>Inactivo (Rol 4)</strong>. No poseés los permisos requeridos para auditar los módulos analíticos.</p>
                    <a href="{{ url('/') }}" class="btn btn-sm px-4 rounded-pill text-white fw-medium shadow-sm" style="background: var(--bi-blue);">
                        <i class="bi bi-house-door me-1"></i> Volver al Inicio
                    </a>
                </div>
            </div>
        @else
            {{-- CONTENEDOR GENERAL PARA USUARIOS VÁLIDOS (DIFERENTES DE 4) --}}
            @include('frontend.estadisticas.partials.sidebar')

            <div class="stats-wrapper">
                
                <header class="bi-top-header">
                    <div class="d-flex align-items-center gap-2">
                        <button class="btn btn-sm rounded-3 border-0 text-secondary d-flex align-items-center justify-content-center" 
                                type="button" onclick="toggleSidebar()" style="width: 36px; height: 36px; background: var(--bi-icon-bg); color: var(--bi-icon-color) !important;">
                            <i class="bi bi-list fs-5"></i>
                        </button>
                        <span class="text-muted small d-none d-md-inline ms-1">
                            Módulos Analíticos / <strong class="text-body">Panel de Control</strong>
                        </span>
                    </div>
                    
                    <div class="d-flex align-items-center gap-3">
                        <button class="btn theme-toggle-btn" type="button" onclick="toggleTheme()" id="themeToggle" title="Cambiar tema visual">
                            <i class="bi bi-moon-stars-fill" id="themeIcon"></i>
                        </button>

                        <div class="vr opacity-25" style="height: 24px; color: var(--bi-icon-color)"></div>

                        <div class="text-end" style="line-height: 1.2;">
                            <span class="text-muted d-block" style="font-size: 0.72rem; font-weight: 600;">Usuario Conectado</span>
                            <span class="text-body fw-bold" style="font-size: 0.82rem;">{{ auth()->user()->name }}</span>
                        </div>
                    </div>
                </header>

                <main class="stats-content">
                    {{-- Seguridad preventiva secundaria por si se intenta forzar la URL directa --}}
                    @hasSection('is_ingresos_mercaderia')
                        @if(auth()->user()->rol_id == 6)
                            @yield('content')
                        @else
                            <div class="alert alert-warning rounded-4 border-0 shadow-sm p-4 text-center mt-3">
                                <i class="bi bi-exclamation-triangle fs-2 text-warning d-block mb-2"></i>
                                <h5 class="fw-bold text-dark">Área Restringida</h5>
                                <p class="text-muted small mb-0">Las métricas de ingresos y mercadería están reservadas exclusivamente para el personal de Recepción autorizado (Rol 6).</p>
                            </div>
                        @endif
                    @else
                        @yield('content')
                    @endif
                </main>
                
            </div>
        @endif
    @else
        {{-- REDIRECCIÓN SI INTENTAN VER EL LAYOUT SIN ESTAR LOGUEADOS --}}
        <script>window.location.href = "{{ route('login') }}";</script>
    @endauth

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // ==========================================
        // CAPA ULTRA-SEGURA ANTI-TRABA PRELOADER
        // ==========================================
        const hidePreloader = () => {
            const preloader = document.getElementById('pagePreloader');
            if (preloader && !preloader.classList.contains('hidden')) {
                preloader.classList.add('hidden');
                setTimeout(() => {
                    preloader.style.display = 'none';
                }, 250);
            }
        };

        // 1. SEGURO ANTI-CONGELAMIENTO EN LOCAL: Máximo 700ms de espera e interrumpe de raíz
        setTimeout(hidePreloader, 700);

        // 2. Apagado inmediato si el HTML ya se procesó
        if (document.readyState === 'interactive' || document.readyState === 'complete') {
            hidePreloader();
        } else {
            document.addEventListener('DOMContentLoaded', hidePreloader);
        }

        // 3. Respaldo clásico de carga de recursos
        window.addEventListener('load', hidePreloader);


        // ==========================================
        // LÓGICA ORIGINAL DE COMPONENTE PANEL
        // ==========================================
        function toggleSidebar() {
            if (window.innerWidth >= 992) {
                document.body.classList.toggle('sidebar-collapsed');
                localStorage.setItem('bi_sidebar_state', document.body.classList.contains('sidebar-collapsed') ? 'collapsed' : 'expanded');
            } else {
                const sidebar = document.getElementById('sidebar');
                if (sidebar) sidebar.classList.toggle('show');
            }
        }

        function toggleTheme() {
            const htmlEl = document.documentElement;
            const currentTheme = htmlEl.getAttribute('data-bs-theme');
            const newTheme = currentTheme === 'light' ? 'dark' : 'light';
            
            htmlEl.setAttribute('data-bs-theme', newTheme);
            localStorage.setItem('bi_theme', newTheme);
            updateThemeIcon(newTheme);
        }

        function updateThemeIcon(theme) {
            const icon = document.getElementById('themeIcon');
            if (theme === 'dark') {
                icon.className = 'bi bi-sun-fill';
            } else {
                icon.className = 'bi bi-moon-stars-fill';
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            if (window.innerWidth >= 992) {
                if (localStorage.getItem('bi_sidebar_state') === 'collapsed') {
                    document.body.classList.add('sidebar-collapsed');
                }
            }
            const activeTheme = document.documentElement.getAttribute('data-bs-theme') || 'light';
            updateThemeIcon(activeTheme);
        });
        
        document.addEventListener('click', function(e) {
            const sidebar = document.getElementById('sidebar');
            const menuBtn = document.querySelector('.bi-top-header button');
            if (window.innerWidth < 992 && sidebar && sidebar.classList.contains('show')) {
                if (!sidebar.contains(e.target) && !menuBtn.contains(e.target)) {
                    sidebar.classList.remove('show');
                }
            }
        });
    </script>
</body>

</html>