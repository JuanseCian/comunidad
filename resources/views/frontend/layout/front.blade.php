<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Comunidad | @yield('title')</title>

    <link rel="icon" href="{{ asset('assets/img/SN.png') }}" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('assets/css/front.css') }}?v=2">
</head>
<body>
    <div class="page-preloader" id="pagePreloader">
        <div class="balls-container">
            <div class="ball"></div>
            <div class="ball"></div>
            <div class="ball"></div>
        </div>
        <div class="preloader-text">Cargando...</div>
    </div>

    <div class="drawer-overlay" id="drawerOverlay"></div>

    <aside class="drawer" id="sideDrawer" role="dialog" aria-modal="true">
        @auth
            <div class="drawer-head">
                <button class="drawer-close" id="drawerClose"><i class="bi bi-x-lg"></i></button>
                <div class="drawer-avatar-big">
                    {{ strtoupper(substr(auth()->user()->nombre, 0, 2)) }}
                </div>
                <div class="drawer-name">{{ auth()->user()->nombre }}</div>
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
                        @php
                            // Forzamos minúsculas y limpiamos espacios para evitar fallos de coincidencia
                            $nombreLower = trim(mb_strtolower($p->nombre));
                            
                            // Asignación de íconos específicos según palabras clave
                            if (str_contains($nombreLower, 'envion') || str_contains($nombreLower, 'envión')) {
                                $iconClass = 'bi-people-fill'; 
                                $colorClass = 'icon-sky';
                            } elseif (str_contains($nombreLower, 'udi')) {
                                $iconClass = 'bi-backpack-fill'; 
                                $colorClass = 'icon-teal';
                            } elseif (str_contains($nombreLower, 'guarderia') || str_contains($nombreLower, 'guardería') || str_contains($nombreLower, 'infantil') || str_contains($nombreLower, 'niñ')) {
                                $iconClass = 'bi-sun-fill';       // Un sol (Básico, súper representativo de jardín/maternal y 100% compatible)
                                $colorClass = 'icon-teal';
                            } elseif (str_contains($nombreLower, 'multiespacio') || str_contains($nombreLower, 'discapacidad')) {
                                $iconClass = 'bi-heart-pulse-fill';
                                $colorClass = 'icon-purple';
                            } else {
                                $iconClass = 'bi-folder2-open'; 
                                $colorClass = 'icon-teal';
                            }
                        @endphp

                        <a class="drawer-item" href="{{ route('frontend.programas.show', $p->id) }}">
                            <span class="drawer-item-icon {{ $colorClass }}"><i class="bi {{ $iconClass }}"></i></span> 
                            {{ $p->nombre }}
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
                <form id="logoutForm" action="{{ route('logout') }}" method="POST" class="m-0">
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
                    <i class="bi bi-layout-sidebar"></i>
                </button>
            @else
                <a href="{{ route('login') }}" class="btn-nav-login" style="background:white; color:var(--teal-600); padding:8px 18px; border-radius:10px; text-decoration:none; font-weight:700;">
                    <i class="bi bi-box-arrow-in-right"></i> Ingresar
                </a>
            @endauth
            
            <button class="nav-toggler" id="navToggler"><i class="bi bi-layout-sidebar"></i></button>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

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
                        <a href="https://www.google.com/maps?q=-33.355467,-60.206702"
                        target="_blank"
                        class="text-decoration-none">
                            Lazarte y Brown, San Nicolás de los Arroyos
                        </a>
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

                        <div class="info-section full-width">
                            <div class="info-section-title">
                                <i class="bi bi-bookmark"></i>Propósito de la Plataforma
                            </div>
                            <p class="info-text-block">
                                Plataforma de gestión social diseñada para fortalecer el seguimiento y la coordinación de programas y beneficiarios del área de <strong>Comunidad</strong>, a cargo de la Directora de Comunidad (Cordisco, María Laura) bajo la gestion de la <strong>Secretaría de Desarrollo Humano</strong> a cargo de la Sec. Mendez, María en San Nicolás de los Arroyos. Facilita la administración de asistencia, estadísticas y grupos familiares con un enfoque colaborativo e innovador, dirigido a gestores, coordinadores y profesionales del área de intervención social.
                            </p>
                        </div>

                        <div class="info-section full-width">
                            <div class="info-section-title">
                                <i class="bi bi-building"></i>Equipo de Desarrollo 
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

                        <div class="info-section full-width">
                            <div class="info-section-title">
                                <i class="bi bi-chat-dots"></i>Soporte Técnico y Contacto
                            </div>
                            <div class="info-item">
                                <span class="info-item-label">Email Oficial:</span>
                                <span class="info-item-value">
                                    <a href="mailto:sndesarrollohumano@gmail.com" class="text-decoration-none fw-bold text-teal-600" style="color: var(--teal-600);">sndesarrollohumano@gmail.com</a>
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
    <script>
        const hidePreloader = () => {
            const preloader = document.getElementById('pagePreloader');
            if (preloader && !preloader.classList.contains('hidden')) {
                preloader.classList.add('hidden');
                setTimeout(() => {
                    preloader.style.display = 'none';
                }, 300);
            }
        };

        setTimeout(hidePreloader, 700);

        if (document.readyState === 'interactive' || document.readyState === 'complete') {
            hidePreloader();
        } else {
            document.addEventListener('DOMContentLoaded', hidePreloader);
        }

        window.addEventListener('load', hidePreloader);

        document.addEventListener('DOMContentLoaded', () => {
            const drawer = document.getElementById('sideDrawer');
            const overlay = document.getElementById('drawerOverlay');
            const openBtn = document.getElementById('openDrawer');
            const navToggler = document.getElementById('navToggler');
            const closeBtn = document.getElementById('drawerClose');
            const btnSysInfo = document.getElementById('btnSysInfo');
            const sysInfoModal = new bootstrap.Modal(document.getElementById('sysInfoModal'));
            
            // 1. Capturamos el formulario de logout
            const logoutForm = document.getElementById('logoutForm');

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
                    toggleDrawer(false); 
                    setTimeout(() => {
                        sysInfoModal.show();
                    }, 350);
                });
            }

            // 2. Interceptamos el Submit para mostrar la animación de salida
            if (logoutForm) {
                logoutForm.addEventListener('submit', () => {
                    const preloader = document.getElementById('pagePreloader');
                    if (preloader) {
                        const preloaderText = preloader.querySelector('.preloader-text');
                        if (preloaderText) {
                            preloaderText.textContent = 'Cerrando sesión...';
                        }
                        // Forzamos el display original y removemos la clase que lo oculta
                        preloader.style.display = 'flex';
                        preloader.classList.remove('hidden');
                    }
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