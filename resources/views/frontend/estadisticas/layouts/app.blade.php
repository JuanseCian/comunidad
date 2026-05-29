<!DOCTYPE html>
<html lang="es" data-bs-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comunidad | Estadísticas</title>
    
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
            
            /* Variables dinámicas dependientes del tema */
            --bi-body-bg: #f8fafc;
            --bi-sidebar-bg: #ffffff;
            --bi-sidebar-border: #eaeef3;
            --bi-icon-bg: #f1f5f9;
            --bi-icon-color: #64748b;
            --bi-icon-hover-bg: #e2e8f0;
        }

        /* Sobreescritura adaptativa cuando Bootstrap pasa a Modo Oscuro */
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

        /* --- SIDEBAR POWER BI ADAPTATIVO --- */
        .stats-sidebar {
            width: var(--sidebar-width);
            min-height: 100vh;
            background: var(--bi-sidebar-bg);
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1040;
            border-right: 1px solid var(--bi-sidebar-border);
            transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1), transform 0.3s cubic-bezier(0.4, 0, 0.2, 1), background 0.25s ease, border-color 0.25s ease;
            overflow: hidden;
        }

        .stats-sidebar .nav-link {
            color: var(--bi-icon-color);
            padding: 10px 14px;
            margin: 2px 0 2px 12px;
            border-radius: 20px 0 0 20px;
            display: flex;
            align-items: center;
            font-weight: 500;
            font-size: 0.92rem;
            transition: all 0.2s ease;
            white-space: nowrap;
            text-decoration: none;
            position: relative;
        }

        .stats-sidebar .nav-link i {
            min-width: 38px;
            height: 38px;
            font-size: 1.15rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: var(--bi-icon-bg);
            color: var(--bi-icon-color);
            transition: all 0.25s ease;
        }

        .stats-sidebar .nav-link:hover i {
            background: var(--bi-icon-hover-bg);
            color: var(--bs-heading-color);
        }

        /* ACTIVO (Mantiene el indicador curvo azul en ambos modos) */
        .stats-sidebar .nav-link.active {
            color: var(--bi-blue) !important;
            background: transparent;
            margin-left: 0;
            padding-left: 12px;
            font-weight: 600;
        }

        .stats-sidebar .nav-link.active i {
            background: var(--bi-blue);
            color: #ffffff;
            box-shadow: 0 4px 10px rgba(30, 112, 228, 0.25);
        }

        .stats-sidebar .nav-link.active::before {
            content: "";
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 5px;
            background: var(--bi-blue);
            border-radius: 0 4px 4px 0;
        }

        /* Control de desvanecimiento de textos al colapsar */
        .stats-sidebar .nav-link span,
        .stats-sidebar .sidebar-brand-text,
        .stats-sidebar .sidebar-footer-text {
            opacity: 1;
            transition: opacity 0.2s ease;
        }

        body.sidebar-collapsed .stats-sidebar .nav-link span,
        body.sidebar-collapsed .stats-sidebar .sidebar-brand-text,
        body.sidebar-collapsed .stats-sidebar .sidebar-footer-text {
            opacity: 0;
            pointer-events: none;
            width: 0;
            overflow: hidden;
            margin: 0 !important;
        }

        /* --- NUEVOS ESTILOS EXCLUSIVOS PARA ELEMENTOS ACORDEÓN / COLLAPSE --- */
        .stats-sidebar .nav-link .bi-chevron-down {
            min-width: auto;
            height: auto;
            background: transparent !important;
            color: var(--bi-icon-color);
            margin-left: auto;
            margin-right: 15px;
            transition: transform 0.3s ease;
            font-size: 0.8rem;
        }

        .stats-sidebar .nav-link:hover .bi-chevron-down {
            color: var(--bs-heading-color);
        }

        /* Rotar flecha indicadora cuando esté desplegado */
        .stats-sidebar .nav-link[aria-expanded="true"] .bi-chevron-down {
            transform: rotate(180deg);
        }

        /* Estilización interna del menú colapsable */
        .stats-sidebar .collapse {
            background: rgba(0, 0, 0, 0.02);
            margin-left: 12px;
            border-radius: 12px 0 0 12px;
        }
        
        [data-bs-theme="dark"] .stats-sidebar .collapse {
            background: rgba(255, 255, 255, 0.01);
        }

        .stats-sidebar .collapse .nav-link {
            padding-left: 1rem;
            font-size: 0.88rem;
            margin-top: 1px;
            margin-bottom: 1px;
        }

        .stats-sidebar .collapse .nav-link i {
            min-width: 32px;
            height: 32px;
            font-size: 1rem;
            background: transparent !important;
        }

        /* Evitar saltos visuales o desbordamientos de la flecha al estar colapsado en PC */
        body.sidebar-collapsed .stats-sidebar .nav-link .bi-chevron-down {
            opacity: 0 !important;
            width: 0 !important;
            margin: 0 !important;
            display: none !important;
        }

        /* --- WRAPPER Y NAVBAR SUPERIOR --- */
        .stats-wrapper {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
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

        /* Botón Switch de Modo */
        .theme-toggle-btn {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: var(--bi-icon-color);
            background: var(--bi-icon-bg);
            border: 1px solid var(--bi-sidebar-border);
            transition: all 0.2s ease;
        }
        
        .theme-toggle-btn:hover {
            background: var(--bi-icon-hover-bg);
            color: var(--bs-heading-color);
        }

        /* --- RESPONSIVE MOBILE --- */
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
    </style>
</head>

<body>

    @include('frontend.estadisticas.partials.sidebar')

    <div class="stats-wrapper">
        
        <header class="bi-top-header">
            <div class="d-flex align-items-center gap-2">
                <button class="btn btn-sm rounded-3 border-0 text-secondary d-flex align-items-center justify-content-center" 
                        type="button" onclick="toggleSidebar()" style="width: 36px; height: 36px; background: var(--bi-icon-bg); color: var(--bi-icon-color) !important;">
                    <i class="bi bi-list fs-5"></i>
                </button>
                <span class="text-muted small d-none d-md-inline ms-1">
                    Módulos Analíticos / <strong class="text-body">Reporte Ejecutivo</strong>
                </span>
            </div>
            
            <div class="d-flex align-items-center gap-3">
                <button class="btn theme-toggle-btn" type="button" onclick="toggleTheme()" id="themeToggle" title="Cambiar tema visual">
                    <i class="bi bi-moon-stars-fill" id="themeIcon"></i>
                </button>

                <div class="vr opacity-25" style="height: 24px; color: var(--bi-icon-color)"></div>

                <div class="text-end" style="line-height: 1.2;">
                    <span class="text-muted d-block" style="font-size: 0.72rem; font-weight: 500;">Última actualización</span>
                    <span class="text-body fw-bold" style="font-size: 0.8rem;">26/5/2026 22:07</span>
                </div>
            </div>
        </header>

        <main class="stats-content">
            @yield('content')
        </main>
        
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // 1. Manejo del Sidebar
        function toggleSidebar() {
            if (window.innerWidth >= 992) {
                document.body.classList.toggle('sidebar-collapsed');
                localStorage.setItem('bi_sidebar_state', document.body.classList.contains('sidebar-collapsed') ? 'collapsed' : 'expanded');
            } else {
                const sidebar = document.getElementById('sidebar');
                if (sidebar) sidebar.classList.toggle('show');
            }
        }

        // 2. Lógica del Switch de Modo Claro / Oscuro
        function toggleTheme() {
            const htmlEl = document.documentElement;
            const currentTheme = htmlEl.getAttribute('data-bs-theme');
            const newTheme = currentTheme === 'light' ? 'dark' : 'light';
            
            htmlEl.setAttribute('data-bs-theme', newTheme);
            localStorage.setItem('bi_theme', newTheme);
            updateThemeIcon(newTheme);
        }

        // Sincronizar icono del tema
        function updateThemeIcon(theme) {
            const icon = document.getElementById('themeIcon');
            if (theme === 'dark') {
                icon.className = 'bi bi-sun-fill';
            } else {
                icon.className = 'bi bi-moon-stars-fill';
            }
        }

        // Al cargar la página, sincronizar estados
        document.addEventListener('DOMContentLoaded', () => {
            if (window.innerWidth >= 992) {
                if (localStorage.getItem('bi_sidebar_state') === 'collapsed') {
                    document.body.classList.add('sidebar-collapsed');
                }
            }
            const activeTheme = document.documentElement.getAttribute('data-bs-theme') || 'light';
            updateThemeIcon(activeTheme);
        });
        
        // Cerrar al clickear fuera (Mobile)
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