<!DOCTYPE html>
<html lang="es" x-data="{ sidebarOpen: false, openMenu: null }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Gestión - @yield('title')</title>
    
    <link rel="icon" href="{{ asset('assets/img/sn.png') }}" type="image/png">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght=400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://unpkg.com/lucide@latest"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { 
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                        display: ['Plus Jakarta Sans', 'sans-serif']
                    },
                    colors: {
                        'sky-primary': '#0891b2',
                        'sky-light': '#0ea5e9',
                        'teal-primary': '#14b8a6',
                        'teal-light': '#2dd4bf',
                    }
                }
            }
        }
    </script>

    <style>
        :root {
            --color-sky-50: #f4f9fd;
            --color-sky-100: #e0f2fe;
            --color-sky-400: #0ea5e9;
            --color-sky-600: #0369a1;
            --color-teal-50: #f0fdf4;
            --color-teal-400: #2dd4bf;
            --color-teal-600: #0d9488;
            --color-slate-900: #0f172a;
        }

        [x-cloak] { display: none !important; }
        
        * {
            transition-property: background-color, border-color, color, box-shadow, transform;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 200ms;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: linear-gradient(135deg, var(--color-sky-50) 0%, var(--color-teal-50) 100%);
            letter-spacing: -0.2px;
        }

        .sidebar-transition { 
            transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1), transform 0.3s cubic-bezier(0.4, 0, 0.2, 1); 
        }

        aside {
            background-color: #0f172a;
            box-shadow: 1px 0 10px rgba(15, 23, 42, 0.04);
        }

        .nav-section {
            padding-top: 1rem;
            margin-top: 1rem;
        }

        .nav-item {
            display: flex;
            align-items: center;
            padding: 0.7rem 0.85rem;
            border-radius: 0.5rem;
            color: #94a3b8;
            transition: all 0.2s ease;
            font-weight: 500;
            font-size: 0.9rem;
        }

        .nav-item:hover {
            background: rgba(255, 255, 255, 0.04);
            color: #f8fafc;
        }

        .nav-submenu {
            margin-left: 1rem;
            padding-left: 0.75rem;
            border-left: 1px solid rgba(148, 163, 184, 0.15);
            margin-top: 0.25rem;
            margin-bottom: 0.25rem;
        }

        .nav-submenu a {
            font-size: 0.85rem;
            color: #64748b;
            padding: 0.4rem 0.5rem;
            border-radius: 0.375rem;
        }

        .nav-submenu a:hover {
            color: #38bdf8;
            background: rgba(14, 165, 233, 0.03);
        }

        header {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(224, 242, 254, 0.7);
        }

        .btn-toggle {
            color: #64748b;
            transition: all 0.2s ease;
        }

        .btn-toggle:hover {
            background: #f0f9ff;
            color: #0ea5e9;
        }

        ::-webkit-scrollbar {
            width: 4px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: rgba(148, 163, 184, 0.2);
            border-radius: 2px;
        }

        /* --- ANIMACIONES ADICIONALES PARA TOASTS --- */
        @keyframes toastBounceIn {
            0% { transform: translateX(120%) scale(0.9); opacity: 0; }
            65% { transform: translateX(-10px) scale(1.02); opacity: 1; }
            85% { transform: translateX(4px) scale(0.99); }
            100% { transform: translateX(0) scale(1); }
        }

        @keyframes pulseGlow {
            0% { transform: scale(1); box-shadow: 0 0 0 0 var(--pulse-color); }
            70% { transform: scale(1.05); box-shadow: 0 0 0 10px rgba(255, 255, 255, 0); }
            100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(255, 255, 255, 0); }
        }

        .premium-toast {
            animation: toastBounceIn 0.55s cubic-bezier(0.25, 1, 0.5, 1) forwards;
        }

        .toast-icon-pulse {
            animation: pulseGlow 2.5s infinite ease-in-out;
        }
    </style>
</head>
<body class="text-slate-900 antialiased">

    <div class="flex h-screen overflow-hidden relative">
        
        {{-- CAPA OSCURA PARA MÓVILES (BACKDROP) --}}
        <div 
            x-show="sidebarOpen" 
            @click="sidebarOpen = false" 
            x-transition:enter="transition opacity ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition opacity ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-slate-950/60 z-40 md:hidden"
            x-cloak>
        </div>
        
        {{-- BARRA LATERAL (SIDEBAR RESPONSIVA) --}}
        <aside 
            :class="sidebarOpen ? 'translate-x-0 w-72' : '-translate-x-full w-72 md:translate-x-0 md:w-20'" 
            class="sidebar-transition fixed inset-y-0 left-0 md:relative flex-shrink-0 flex flex-col z-50 border-r border-slate-800/40"
            aria-label="Sidebar Navegación">
            
            {{-- BRANDING & LOGO --}}
            <div class="h-20 flex items-center px-5 flex-shrink-0 border-b border-slate-800/40">
                <div class="flex items-center gap-3" :class="sidebarOpen ? 'justify-start' : 'md:mx-auto md:justify-center'">
                    <img src="{{ asset('assets/img/sn.png') }}" alt="Muni SN" class="h-9 w-auto object-contain flex-shrink-0">
                    <span x-show="sidebarOpen" class="text-slate-200 font-bold tracking-tight text-base whitespace-nowrap md:block">
                        Comunidad
                    </span>
                </div>
            </div>

            {{-- NAVEGACIÓN --}}
            <nav class="flex-1 overflow-y-auto px-3 py-4 space-y-1">
                
                <div class="nav-section">
                    <p x-show="sidebarOpen" class="px-3 text-[10px] font-semibold uppercase tracking-widest text-slate-500 mb-2">Principal</p>
                    <div class="space-y-0.5">
                        <a href="{{ route('admin.home') }}" class="nav-item group" :class="sidebarOpen ? '' : 'md:justify-center'" title="Dashboard">
                            <i data-lucide="layout-dashboard" class="w-5 h-5 flex-shrink-0 opacity-80 group-hover:opacity-100"></i>
                            <span x-show="sidebarOpen" class="ml-3">Dashboard</span>
                        </a>
                        <a href="{{ route('usuarios.index') }}" class="nav-item group" :class="sidebarOpen ? '' : 'md:justify-center'" title="Usuarios">
                            <i data-lucide="users" class="w-5 h-5 flex-shrink-0 opacity-80 group-hover:opacity-100"></i>
                            <span x-show="sidebarOpen" class="ml-3">Usuarios</span>
                        </a>
                    </div>
                </div>

                <div class="nav-section">
                    <p x-show="sidebarOpen" class="px-3 text-[10px] font-semibold uppercase tracking-widest text-slate-500 mb-2">Parámetros</p>
                    <div class="space-y-0.5">
                        
                        {{-- GEOGRAFÍA --}}
                        <div x-data="{ open: false }">
                            <button @click="open = !open" 
                                    :class="open && sidebarOpen ? 'bg-slate-800/40 text-sky-400' : ''"
                                    class="w-full nav-item justify-between group"
                                    :class="sidebarOpen ? '' : 'md:justify-center'"
                                    title="Geografía">
                                <div class="flex items-center">
                                    <i data-lucide="map-pin" class="w-5 h-5 flex-shrink-0 opacity-80 group-hover:opacity-100"></i>
                                    <span x-show="sidebarOpen" class="ml-3">Geografía</span>
                                </div>
                                <i x-show="sidebarOpen" data-lucide="chevron-down" :class="open ? 'rotate-180' : ''" class="w-3.5 h-3.5 transition-transform text-slate-500"></i>
                            </button>
                            <div x-show="open && sidebarOpen" x-collapse class="nav-submenu">
                                <a href="{{ route('provincias.index') }}" class="nav-item py-1.5">Provincias</a>
                                <a href="{{ route('localidades.index') }}" class="nav-item py-1.5">Localidades</a>
                                <a href="{{ route('zonas-barrios.index') }}" class="nav-item py-1.5">Zonas</a>
                                <a href="{{ route('barrios.index') }}" class="nav-item py-1.5">Barrios</a>
                            </div>
                        </div>

                        {{-- SALUD Y COBERTURA --}}
                        <div x-data="{ open: false }">
                            <button @click="open = !open" 
                                    :class="open && sidebarOpen ? 'bg-slate-800/40 text-sky-400' : ''"
                                    class="w-full nav-item justify-between group"
                                    :class="sidebarOpen ? '' : 'md:justify-center'"
                                    title="Salud y Cobertura">
                                <div class="flex items-center">
                                    <i data-lucide="heart-pulse" class="w-5 h-5 flex-shrink-0 opacity-80 group-hover:opacity-100"></i>
                                    <span x-show="sidebarOpen" class="ml-3">Salud y Cobertura</span>
                                </div>
                                <i x-show="sidebarOpen" data-lucide="chevron-down" :class="open ? 'rotate-180' : ''" class="w-3.5 h-3.5 transition-transform text-slate-500"></i>
                            </button>
                            <div x-show="open && sidebarOpen" x-collapse class="nav-submenu">
                                <a href="{{ route('enfermedades.index') }}" class="nav-item py-1.5">Enfermedades</a>
                                <a href="{{ route('discapacidades.index') }}" class="nav-item py-1.5">Discapacidades</a>
                                <a href="{{ route('coberturas.index') }}" class="nav-item py-1.5">Cobertura Médica</a>
                            </div>
                        </div>

                        {{-- SOCIAL Y EDUCACIÓN --}}
                        <div x-data="{ open: false }">
                            <button @click="open = !open" 
                                    :class="open && sidebarOpen ? 'bg-slate-800/40 text-sky-400' : ''"
                                    class="w-full nav-item justify-between group"
                                    :class="sidebarOpen ? '' : 'md:justify-center'"
                                    title="Social y Educación">
                                <div class="flex items-center">
                                    <i data-lucide="graduation-cap" class="w-5 h-5 flex-shrink-0 opacity-80 group-hover:opacity-100"></i>
                                    <span x-show="sidebarOpen" class="ml-3">Social y Educación</span>
                                </div>
                                <i x-show="sidebarOpen" data-lucide="chevron-down" :class="open ? 'rotate-180' : ''" class="w-3.5 h-3.5 transition-transform text-slate-500"></i>
                            </button>
                            <div x-show="open && sidebarOpen" x-collapse class="nav-submenu">
                                <a href="{{ route('niveles-estudio.index') }}" class="nav-item py-1.5">Niveles de Estudio</a>
                                <a href="{{ route('estados-civiles.index') }}" class="nav-item py-1.5">Estado Civil</a>
                            </div>
                        </div>

                        {{-- LABORAL Y AYUDA --}}
                        <div x-data="{ open: false }">
                            <button @click="open = !open" 
                                    :class="open && sidebarOpen ? 'bg-slate-800/40 text-sky-400' : ''"
                                    class="w-full nav-item justify-between group"
                                    :class="sidebarOpen ? '' : 'md:justify-center'"
                                    title="Laboral y Ayuda">
                                <div class="flex items-center">
                                    <i data-lucide="briefcase" class="w-5 h-5 flex-shrink-0 opacity-80 group-hover:opacity-100"></i>
                                    <span x-show="sidebarOpen" class="ml-3">Laboral y Ayuda</span>
                                </div>
                                <i x-show="sidebarOpen" data-lucide="chevron-down" :class="open ? 'rotate-180' : ''" class="w-3.5 h-3.5 transition-transform text-slate-500"></i>
                            </button>
                            <div x-show="open && sidebarOpen" x-collapse class="nav-submenu">
                                <a href="{{ route('categorias.index') }}" class="nav-item py-1.5">Categoría Ocupacional</a>
                                <a href="{{ route('condiciones-inactividad.index') }}" class="nav-item py-1.5">Condiciones Inactividad</a>
                                <a href="{{ route('programas-asistencia.index') }}" class="nav-item py-1.5">Prog. Asistencia</a>
                                <a href="{{ route('beneficios.index') }}" class="nav-item py-1.5">Beneficios</a>
                            </div>
                        </div>

                    </div>
                </div>
            </nav>

            {{-- FOOTER SIDEBAR --}}
            <div class="p-3 border-t border-slate-800/50 space-y-1 flex-shrink-0">
                <a href="{{ route('home') }}"
                    class="nav-item text-slate-400 hover:text-teal-400" :class="sidebarOpen ? '' : 'md:justify-center'" title="Volver al Home">
                    <i data-lucide="house" class="w-5 h-5 flex-shrink-0"></i>
                    <span x-show="sidebarOpen" class="ml-3">Volver al Home</span>
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full nav-item text-red-400 hover:text-red-300 hover:bg-red-500/5" :class="sidebarOpen ? '' : 'md:justify-center'" title="Cerrar Sesión">
                        <i data-lucide="log-out" class="w-5 h-5 flex-shrink-0"></i>
                        <span x-show="sidebarOpen" class="ml-3">Cerrar Sesión</span>
                    </button>
                </form>
            </div>
        </aside>

        {{-- CONTENIDO PRINCIPAL --}}
        <div class="flex-1 flex flex-col overflow-hidden w-full">
            
            {{-- HEADER --}}
            <header class="h-20 flex items-center justify-between px-4 sm:px-6 lg:px-8 sticky top-0 z-20 w-full">
                <div class="flex items-center gap-2 sm:gap-4">
                    <button @click="sidebarOpen = !sidebarOpen" class="btn-toggle p-2 hover:bg-slate-100 rounded-lg" aria-label="Toggle Sidebar">
                        <i data-lucide="menu" class="w-5 h-5"></i>
                    </button>
                    
                    <nav class="hidden md:flex items-center gap-2.5 text-sm">
                        <span class="text-slate-400 font-medium">Panel Administrativo</span>
                        <i data-lucide="chevron-right" class="w-3 h-3 text-slate-300"></i>
                        <span class="font-semibold text-slate-700 px-3 py-1 bg-white border border-sky-100/80 rounded-full shadow-sm">
                            @yield('header')
                        </span>
                    </nav>
                </div>
            </header>

            {{-- ÁREA DE CONTENIDO --}}
            <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-10 w-full">
                <div class="max-w-7xl mx-auto">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    {{-- INTERFAZ PREMIUM DE NOTIFICACIONES GLOW --}}
    <div class="fixed top-6 right-6 z-[9999] space-y-4 pointer-events-none">

        {{-- SUCCESS TOAST --}}
        @if(session('success'))
            <div
                x-data="{ show: true }"
                x-show="show"
                x-init="setTimeout(() => show = false, 5000)"
                x-transition:leave="transition ease-in duration-300 transform opacity-0 translate-x-20"
                class="premium-toast pointer-events-auto relative overflow-hidden bg-white/90 backdrop-blur-xl rounded-2xl w-[370px] border border-emerald-500/30 p-4 flex items-center gap-4"
                style="box-shadow: 0 15px 35px -5px rgba(16, 185, 129, 0.2), 0 5px 15px -3px rgba(16, 185, 129, 0.08);"
            >
                <div class="absolute -top-12 -left-12 w-32 h-32 bg-emerald-500/10 blur-2xl rounded-full pointer-events-none"></div>
                <div class="absolute top-0 left-0 bottom-0 w-1.5 bg-emerald-500"></div>

                <div class="toast-icon-pulse flex-shrink-0 w-11 h-11 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center" style="--pulse-color: rgba(16, 185, 129, 0.35);">
                    <i data-lucide="check-circle" class="w-5 h-5"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <h6 class="text-slate-900 font-extrabold text-sm tracking-tight">¡Operación Exitosa!</h6>
                    <p class="text-slate-600 text-xs font-medium leading-relaxed mt-0.5">{{ session('success') }}</p>
                </div>
                <button @click="show = false" class="text-slate-400 hover:text-slate-600 hover:bg-slate-100 p-1.5 rounded-lg transition self-start -mt-1 -mr-1">
                    <i data-lucide="x" class="w-4 h-4"></i>
                </button>
            </div>
        @endif

        {{-- ERROR TOAST --}}
        @if(session('error'))
            <div
                x-data="{ show: true }"
                x-show="show"
                x-init="setTimeout(() => show = false, 6000)"
                x-transition:leave="transition ease-in duration-300 transform opacity-0 translate-x-20"
                class="premium-toast pointer-events-auto relative overflow-hidden bg-white/90 backdrop-blur-xl rounded-2xl w-[370px] border border-red-500/30 p-4 flex items-center gap-4"
                style="box-shadow: 0 15px 35px -5px rgba(239, 68, 68, 0.2), 0 5px 15px -3px rgba(239, 68, 68, 0.08);"
            >
                <div class="absolute -top-12 -left-12 w-32 h-32 bg-red-500/10 blur-2xl rounded-full pointer-events-none"></div>
                <div class="absolute top-0 left-0 bottom-0 w-1.5 bg-red-500"></div>

                <div class="toast-icon-pulse flex-shrink-0 w-11 h-11 rounded-xl bg-red-50 text-red-600 flex items-center justify-center" style="--pulse-color: rgba(239, 68, 68, 0.35);">
                    <i data-lucide="alert-circle" class="w-5 h-5"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <h6 class="text-slate-900 font-extrabold text-sm tracking-tight">Ha ocurrido un error</h6>
                    <p class="text-slate-600 text-xs font-medium leading-relaxed mt-0.5">{{ session('error') }}</p>
                </div>
                <button @click="show = false" class="text-slate-400 hover:text-slate-600 hover:bg-slate-100 p-1.5 rounded-lg transition self-start -mt-1 -mr-1">
                    <i data-lucide="x" class="w-4 h-4"></i>
                </button>
            </div>
        @endif

        {{-- WARNING TOAST --}}
        @if(session('warning'))
            <div
                x-data="{ show: true }"
                x-show="show"
                x-init="setTimeout(() => show = false, 6000)"
                x-transition:leave="transition ease-in duration-300 transform opacity-0 translate-x-20"
                class="premium-toast pointer-events-auto relative overflow-hidden bg-white/90 backdrop-blur-xl rounded-2xl w-[370px] border border-amber-500/30 p-4 flex items-center gap-4"
                style="box-shadow: 0 15px 35px -5px rgba(245, 158, 11, 0.2), 0 5px 15px -3px rgba(245, 158, 11, 0.08);"
            >
                <div class="absolute -top-12 -left-12 w-32 h-32 bg-amber-500/10 blur-2xl rounded-full pointer-events-none"></div>
                <div class="absolute top-0 left-0 bottom-0 w-1.5 bg-amber-500"></div>

                <div class="toast-icon-pulse flex-shrink-0 w-11 h-11 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center" style="--pulse-color: rgba(245, 158, 11, 0.35);">
                    <i data-lucide="triangle-alert" class="w-5 h-5"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <h6 class="text-slate-900 font-extrabold text-sm tracking-tight">Atención Requerida</h6>
                    <p class="text-slate-600 text-xs font-medium leading-relaxed mt-0.5">{{ session('warning') }}</p>
                </div>
                <button @click="show = false" class="text-slate-400 hover:text-slate-600 hover:bg-slate-100 p-1.5 rounded-lg transition self-start -mt-1 -mr-1">
                    <i data-lucide="x" class="w-4 h-4"></i>
                </button>
            </div>
        @endif

        {{-- INFO TOAST --}}
        @if(session('info'))
            <div
                x-data="{ show: true }"
                x-show="show"
                x-init="setTimeout(() => show = false, 5000)"
                x-transition:leave="transition ease-in duration-300 transform opacity-0 translate-x-20"
                class="premium-toast pointer-events-auto relative overflow-hidden bg-white/90 backdrop-blur-xl rounded-2xl w-[370px] border border-sky-500/30 p-4 flex items-center gap-4"
                style="box-shadow: 0 15px 35px -5px rgba(14, 165, 233, 0.2), 0 5px 15px -3px rgba(14, 165, 233, 0.08);"
            >
                <div class="absolute -top-12 -left-12 w-32 h-32 bg-sky-500/10 blur-2xl rounded-full pointer-events-none"></div>
                <div class="absolute top-0 left-0 bottom-0 w-1.5 bg-sky-500"></div>

                <div class="toast-icon-pulse flex-shrink-0 w-11 h-11 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center" style="--pulse-color: rgba(14, 165, 233, 0.35);">
                    <i data-lucide="info" class="w-5 h-5"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <h6 class="text-slate-900 font-extrabold text-sm tracking-tight">Información del Sistema</h6>
                    <p class="text-slate-600 text-xs font-medium leading-relaxed mt-0.5">{{ session('info') }}</p>
                </div>
                <button @click="show = false" class="text-slate-400 hover:text-slate-600 hover:bg-slate-100 p-1.5 rounded-lg transition self-start -mt-1 -mr-1">
                    <i data-lucide="x" class="w-4 h-4"></i>
                </button>
            </div>
        @endif

    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>