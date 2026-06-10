<!DOCTYPE html>
<html lang="es" x-data="{ sidebarOpen: true, openMenu: null }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Gestión - @yield('title')</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@500;600;700&display=swap" rel="stylesheet">
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
            --color-sky-50: #f0f9ff;
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
            transition-property: background-color, border-color, color, box-shadow;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 200ms;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: linear-gradient(135deg, var(--color-sky-50) 0%, var(--color-teal-50) 100%);
            letter-spacing: -0.3px;
        }

        .sidebar-transition { 
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); 
        }

        aside {
            background: linear-gradient(180deg, #0f172a 0%, #1a202c 100%);
            box-shadow: 4px 0 16px rgba(0, 0, 0, 0.1);
        }

        .nav-section {
            border-top: 1px solid rgba(148, 163, 184, 0.1);
            padding-top: 1.25rem;
            margin-top: 1.5rem;
        }

        .nav-section:first-of-type {
            border-top: none;
            margin-top: 0;
            padding-top: 0;
        }

        .nav-item {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            border-radius: 0.75rem;
            color: #cbd5e1;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            font-weight: 500;
            font-size: 0.95rem;
        }

        .nav-item:hover {
            background: rgba(14, 165, 233, 0.1);
            color: #0ea5e9;
            transform: translateX(4px);
        }

        .nav-item-active {
            background: linear-gradient(90deg, rgba(14, 165, 233, 0.15) 0%, rgba(20, 184, 166, 0.1) 100%);
            color: #2dd4bf;
            border-left: 3px solid #0ea5e9;
            padding-left: calc(1rem - 3px);
            font-weight: 600;
        }

        .nav-submenu {
            margin-left: 1.5rem;
            padding-left: 1rem;
            border-left: 2px solid rgba(14, 165, 233, 0.2);
        }

        .nav-submenu a {
            font-size: 0.875rem;
            padding: 0.5rem 0.75rem;
        }

        .logo-gradient {
            background: linear-gradient(135deg, #0ea5e9 0%, #2dd4bf 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 700;
            letter-spacing: -1px;
        }

        .icon-gradient {
            width: 32px;
            height: 32px;
            border-radius: 0.625rem;
            background: linear-gradient(135deg, #0ea5e9 0%, #2dd4bf 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            flex-shrink: 0;
        }

        header {
            background: white;
            border-bottom: 1px solid #e0f2fe;
            box-shadow: 0 2px 8px rgba(14, 165, 233, 0.06);
        }

        .btn-toggle {
            color: #64748b;
            transition: all 0.25s ease;
        }

        .btn-toggle:hover {
            background: #f0f9ff;
            color: #0ea5e9;
        }

        main {
            background: linear-gradient(135deg, #f0f9ff 0%, #f0fdf4 100%);
        }

        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: rgba(14, 165, 233, 0.3);
            border-radius: 3px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: rgba(14, 165, 233, 0.5);
        }

        @media (max-width: 768px) {
            aside {
                position: fixed;
                left: 0;
                top: 0;
                bottom: 0;
                z-index: 40;
                box-shadow: 8px 0 24px rgba(0, 0, 0, 0.15);
            }

            aside[aria-hidden="true"] {
                transform: translateX(-100%);
            }
        }
    </style>
</head>
<body class="text-slate-900 antialiased">

    <div class="flex h-screen overflow-hidden">
        
        <aside 
            :class="sidebarOpen ? 'w-72' : 'w-20'" 
            class="sidebar-transition bg-gradient-to-b from-slate-900 via-slate-900 to-slate-800 text-slate-300 flex-shrink-0 flex flex-col z-30">
            
            <div class="h-20 flex items-center px-6 mb-2 flex-shrink-0">
                <div class="flex items-center gap-3 w-full">
                    <div class="icon-gradient">
                        <i data-lucide="shield-check" class="w-5 h-5"></i>
                    </div>
                    <span x-show="sidebarOpen" x-transition.opacity class="logo-gradient text-lg">
                        Comunidad
                    </span>
                </div>
            </div>

            <nav class="flex-1 overflow-y-auto px-4 space-y-2">
                
                <div class="nav-section">
                    <p x-show="sidebarOpen" class="px-2 text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-3">Principal</p>
                    <div class="space-y-1">
                        <a href="{{ route('admin.home') }}" class="nav-item">
                            <i data-lucide="layout-dashboard" class="w-5 h-5 flex-shrink-0"></i>
                            <span x-show="sidebarOpen" class="ml-3">Dashboard</span>
                        </a>
                        <a href="{{ route('usuarios.index') }}" class="nav-item">
                            <i data-lucide="users" class="w-5 h-5 flex-shrink-0"></i>
                            <span x-show="sidebarOpen" class="ml-3">Usuarios</span>
                        </a>
                    </div>
                </div>

                <div class="nav-section">
                    <p x-show="sidebarOpen" class="px-2 text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-3">Parámetros</p>
                    <div class="space-y-1">
                        
                        <div x-data="{ open: false }">
                            <button @click="open = !open" :class="open ? 'bg-slate-800/40 text-sky-400' : ''"
                                class="w-full nav-item justify-between group">
                                <div class="flex items-center">
                                    <i data-lucide="map-pin" class="w-5 h-5 flex-shrink-0"></i>
                                    <span x-show="sidebarOpen" class="ml-3">Geografía</span>
                                </div>
                                <i x-show="sidebarOpen" data-lucide="chevron-down" :class="open ? 'rotate-180' : ''" class="w-4 h-4 transition-transform text-slate-500"></i>
                            </button>
                            <div x-show="open && sidebarOpen" x-collapse class="nav-submenu">
                                <a href="{{ route('provincias.index') }}" class="nav-item hover:text-sky-400">Provincias</a>
                                <a href="{{ route('localidades.index') }}" class="nav-item hover:text-sky-400">Localidades</a>
                                <a href="{{ route('zonas-barrios.index') }}" class="nav-item hover:text-sky-400">Zonas</a>
                                <a href="{{ route('barrios.index') }}" class="nav-item hover:text-sky-400">Barrios</a>
                            </div>
                        </div>

                        <div x-data="{ open: false }">
                            <button @click="open = !open" :class="open ? 'bg-slate-800/40 text-sky-400' : ''"
                                class="w-full nav-item justify-between group">
                                <div class="flex items-center">
                                    <i data-lucide="heart-pulse" class="w-5 h-5 flex-shrink-0"></i>
                                    <span x-show="sidebarOpen" class="ml-3">Salud y Cobertura</span>
                                </div>
                                <i x-show="sidebarOpen" data-lucide="chevron-down" :class="open ? 'rotate-180' : ''" class="w-4 h-4 transition-transform text-slate-500"></i>
                            </button>
                            <div x-show="open && sidebarOpen" x-collapse class="nav-submenu">
                                <a href="{{ route('enfermedades.index') }}" class="nav-item hover:text-sky-400">Enfermedades</a>
                                <a href="{{ route('discapacidades.index') }}" class="nav-item hover:text-sky-400">Discapacidades</a>
                                <a href="{{ route('coberturas.index') }}" class="nav-item hover:text-sky-400">Cobertura Médica</a>
                            </div>
                        </div>

                        <div x-data="{ open: false }">
                            <button @click="open = !open" :class="open ? 'bg-slate-800/40 text-sky-400' : ''"
                                class="w-full nav-item justify-between group">
                                <div class="flex items-center">
                                    <i data-lucide="graduation-cap" class="w-5 h-5 flex-shrink-0"></i>
                                    <span x-show="sidebarOpen" class="ml-3">Social y Educación</span>
                                </div>
                                <i x-show="sidebarOpen" data-lucide="chevron-down" :class="open ? 'rotate-180' : ''" class="w-4 h-4 transition-transform text-slate-500"></i>
                            </button>
                            <div x-show="open && sidebarOpen" x-collapse class="nav-submenu">
                                <a href="{{ route('niveles-estudio.index') }}" class="nav-item hover:text-sky-400">Niveles de Estudio</a>
                                <a href="{{ route('estados-civiles.index') }}" class="nav-item hover:text-sky-400">Estado Civil</a>
                            </div>
                        </div>

                        <div x-data="{ open: false }">
                            <button @click="open = !open" :class="open ? 'bg-slate-800/40 text-sky-400' : ''"
                                class="w-full nav-item justify-between group">
                                <div class="flex items-center">
                                    <i data-lucide="briefcase" class="w-5 h-5 flex-shrink-0"></i>
                                    <span x-show="sidebarOpen" class="ml-3">Laboral y Ayuda</span>
                                </div>
                                <i x-show="sidebarOpen" data-lucide="chevron-down" :class="open ? 'rotate-180' : ''" class="w-4 h-4 transition-transform text-slate-500"></i>
                            </button>
                            <div x-show="open && sidebarOpen" x-collapse class="nav-submenu">
                                <a href="{{ route('categorias.index') }}" class="nav-item hover:text-sky-400">Categoría Ocupacional</a>
                                <a href="{{ route('condiciones-inactividad.index') }}" class="nav-item hover:text-sky-400">Condiciones Inactividad</a>
                                <a href="{{ route('programas-asistencia.index') }}" class="nav-item hover:text-sky-400">Prog. Asistencia</a>
                                <a href="{{ route('beneficios.index') }}" class="nav-item hover:text-sky-400">Beneficios</a>
                            </div>
                        </div>

                    </div>
                </div>
            </nav>

            <div class="p-4 border-t border-slate-700/50 space-y-2 flex-shrink-0">
                <a href="{{ route('home') }}"
                    class="nav-item text-slate-400 hover:text-teal-400">
                    <i data-lucide="house" class="w-5 h-5 flex-shrink-0"></i>
                    <span x-show="sidebarOpen" class="ml-3">Volver al Home</span>
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full nav-item text-red-400 hover:text-red-300 hover:bg-red-500/10">
                        <i data-lucide="log-out" class="w-5 h-5 flex-shrink-0"></i>
                        <span x-show="sidebarOpen" class="ml-3">Cerrar Sesión</span>
                    </button>
                </form>
            </div>
        </aside>

        <div class="flex-1 flex flex-col overflow-hidden">
            
            <header class="h-20 bg-white border-b border-sky-100 flex items-center justify-between px-8 sticky top-0 z-20">
                <div class="flex items-center gap-6">
                    <button @click="sidebarOpen = !sidebarOpen" class="btn-toggle p-2 hover:bg-sky-50 rounded-lg">
                        <i data-lucide="menu" class="w-6 h-6"></i>
                    </button>
                    
                    <nav class="hidden md:flex items-center gap-3 text-sm">
                        <span class="text-slate-500 font-medium">Panel Administrativo</span>
                        <i data-lucide="chevron-right" class="w-3 h-3 text-slate-300"></i>
                        <span class="font-semibold text-slate-800 px-3 py-1 bg-gradient-to-r from-sky-50 to-teal-50 border border-sky-100 rounded-full shadow-sm">
                            @yield('header')
                        </span>
                    </nav>
                </div>

                <div class="flex items-center gap-4">
                    <div class="flex items-center gap-3 pl-4 border-l border-sky-100">
                        <div class="text-right hidden sm:block">
                            <p class="text-xs font-bold text-slate-900">Admin Sistema</p>
                            <p class="text-[10px] text-slate-500 font-medium">admin@sistema.com</p>
                        </div>
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-sky-400 to-teal-400 flex items-center justify-center text-white font-bold text-sm shadow-md">
                            AD
                        </div>
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto p-6 lg:p-10">
                <div class="max-w-7xl mx-auto">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>