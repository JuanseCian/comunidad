<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comunidad | Estadísticas</title>
    
    <!-- Google Fonts (Inter para una estética de dashboard premium) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        :root {
            --sidebar-width: 260px;
        }

        body {
            background: #f8fafc;
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            color: #1e293b;
            overflow-x: hidden;
        }

        /* --- SIDEBAR --- */
        .stats-sidebar {
            width: var(--sidebar-width);
            min-height: 100vh;
            background: linear-gradient(180deg, #0f172a, #1e293b);
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1030;
            transition: transform 0.3s ease;
        }

        .stats-sidebar a {
            color: #94a3b8;
            text-decoration: none;
            padding: 12px 16px;
            display: flex;
            align-items: center;
            gap: 12px;
            border-radius: 10px;
            transition: all 0.2s ease;
            font-weight: 500;
        }

        .stats-sidebar a:hover, 
        .stats-sidebar a.active {
            background: rgba(255, 255, 255, 0.08);
            color: #ffffff;
        }

        .stats-sidebar a.active {
            background: #2563eb;
            color: #ffffff;
        }

        /* --- MAIN CONTENT CONTAINER --- */
        .stats-wrapper {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            transition: margin 0.3s ease;
        }

        .stats-content {
            padding: 2rem;
            max-width: 1400px;
            margin: 0 auto;
        }

        /* --- COMPONENTES GLOBALES DE ESTADÍSTICAS --- */
        .stats-card {
            border: 1px solid rgba(226, 232, 240, 0.8);
            border-radius: 16px;
            background: #ffffff;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02), 0 2px 4px -1px rgba(0, 0, 0, 0.02);
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .stats-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
        }

        .stats-card-gradient {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            color: #ffffff;
            border: none;
        }

        .stats-title {
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            font-weight: 600;
            color: #64748b;
        }

        .stats-card-gradient .stats-title {
            color: rgba(255, 255, 255, 0.8);
        }

        .stats-value {
            font-size: 2rem;
            font-weight: 700;
            letter-spacing: -0.02em;
            color: #0f172a;
        }

        .stats-card-gradient .stats-value {
            color: #ffffff;
        }

        /* --- RESPONSIVE DESIGN --- */
        @media (max-width: 991.98px) {
            .stats-sidebar {
                transform: translateX(-100%);
            }
            
            .stats-sidebar.show {
                transform: translateX(0);
            }

            .stats-wrapper {
                margin-left: 0;
            }
        }

        /* Estilos base del Sidebar y su animación */
        .stats-sidebar {
            width: 260px;
            min-height: 100vh;
            background: linear-gradient(180deg, #0f172a 0%, #1e293b 100%);
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1040;
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Enlaces internos del Sidebar */
        .stats-sidebar .nav-link {
            color: #94a3b8;
            padding: 12px 16px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .stats-sidebar .nav-link:hover {
            background: rgba(255, 255, 255, 0.06);
            color: #f8fafc;
        }

        .stats-sidebar .nav-link.active {
            background: #2563eb;
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
        }

        /* Contenedor del contenido que respeta el espacio del sidebar */
        .stats-wrapper {
            margin-left: 260px;
            min-height: 100vh;
            background: #f8fafc;
            transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .stats-content {
            padding: 2rem;
        }

        /* Efectos hover sutiles para elementos interactivos */
        .stats-avatar:hover {
            transform: scale(1.05);
            border-color: #cbd5e1 !important;
        }

        .stats-card {
            transition: transform 0.22s ease, box-shadow 0.22s ease;
        }
        .stats-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 20px -5px rgba(0,0,0,0.05), 0 4px 6px -2px rgba(0,0,0,0.02) !important;
        }

        /* --- LÓGICA RESPONSIVE PARA EL SLIDEBAR --- */
        @media (max-width: 991.98px) {
            .stats-sidebar {
                transform: translateX(-100%); /* Oculto por defecto en móviles */
            }
            
            .stats-sidebar.show {
                transform: translateX(0); /* Desliza hacia adentro */
                box-shadow: 5px 0 25px rgba(0, 0, 0, 0.15);
            }

            .stats-wrapper {
                margin-left: 0; /* Ocupa toda la pantalla en móviles */
            }
            
            .stats-content {
                padding: 1.25rem;
            }
        }

        .stats-filters{
            background:white;

            padding:20px;

            border-radius:18px;

            box-shadow:0 8px 24px rgba(0,0,0,.05);
        }

        .stats-filters .form-label{
            color:#64748b;
        }

        .stats-filters .form-select{
            border-radius:12px;
            min-height:46px;
        }

        .stats-filters .btn{
            border-radius:12px;
            min-height:46px;
            font-weight:700;
        }
    </style>
</head>

<body>

    <!-- Sidebar (Asume que hereda la clase .stats-sidebar dentro de su partial) -->
    @include('frontend.estadisticas.partials.sidebar')

    <!-- Contenedor Principal -->
    <div class="stats-wrapper">
        
        <!-- Navbar para Móviles (Solo visible en pantallas chicas) -->
        <header class="navbar navbar-expand-lg navbar-light bg-white border-bottom d-lg-none px-3 py-2 sticky-top">
            <button class="btn btn-outline-secondary btn-sm me-2" type="button" onclick="toggleSidebar()">
                <i class="bi bi-list fs-4"></i>
            </button>
            <span class="navbar-brand fw-bold fs-6 mb-0">Comunidad Estadísticas</span>
        </header>

        <!-- Contenido de la Vista -->
        <main class="stats-content">
            @yield('content')
            
        </main>
        
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Script para controlar el menú en móviles -->
    <script>
        function toggleSidebar() {
            const sidebar = document.querySelector('.stats-sidebar');
            if (sidebar) {
                sidebar.classList.toggle('show');
            }
        }
        
        // Cerrar sidebar si se hace click fuera en móviles
        document.addEventListener('click', function(event) {
            const sidebar = document.querySelector('.stats-sidebar');
            const toggleBtn = document.querySelector('.navbar-expand-lg button');
            
            if (window.innerWidth < 992 && sidebar && sidebar.classList.contains('show')) {
                if (!sidebar.contains(event.target) && !toggleBtn.contains(event.target)) {
                    sidebar.classList.remove('show');
                }
            }
        });
        
    </script>
    <script>
        // Función encargada de deslizar el menú
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            if (sidebar) {
                sidebar.classList.toggle('show');
            }
        }

        // Cierra el sidebar automáticamente si se clickea fuera de él estando en móviles
        document.addEventListener('click', function (event) {
            const sidebar = document.getElementById('sidebar');
            const toggles = document.querySelectorAll('[onclick="toggleSidebar()"]');
            
            if (window.innerWidth < 992 && sidebar && sidebar.classList.contains('show')) {
                let clickedToggle = false;
                toggles.forEach(t => { if(t.contains(event.target)) clickedToggle = true; });
                
                if (!sidebar.contains(event.target) && !clickedToggle) {
                    sidebar.classList.remove('show');
                }
            }
        });
    </script>
</body>

</html>