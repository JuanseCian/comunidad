<!DOCTYPE html>
<html lang="es" x-data="{ sidebarOpen: true, openUbicaciones: false }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Backend - @yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        [x-cloak] { display: none !important; }
        .sidebar-transition { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
    </style>
</head>
<body class="bg-slate-50">

    <div class="flex h-screen overflow-hidden">
        <aside 
            :class="sidebarOpen ? 'w-64' : 'w-20'" 
            class="sidebar-transition bg-slate-900 text-slate-300 flex-shrink-0 flex flex-col z-20">
            
            <div class="h-16 flex items-center justify-between px-4 bg-slate-950">
                <span x-show="sidebarOpen" x-cloak class="font-bold text-xl text-white tracking-wider">GESTIÓN</span>
                <button @click="sidebarOpen = !sidebarOpen" class="p-2 hover:bg-slate-800 rounded-lg text-blue-400">
                    <i data-lucide="menu"></i>
                </button>
            </div>

            <nav class="flex-1 overflow-y-auto py-4 px-3 space-y-1">
                <a href="{{ route('admin.home') }}" class="flex items-center p-3 hover:bg-slate-800 rounded-lg group transition-colors">
                    <i data-lucide="layout-grid" class="w-6 h-6 text-blue-400"></i>
                    <span x-show="sidebarOpen" x-cloak class="ml-3 font-medium">Dashboard</span>
                </a>

                <div class="my-4 border-t border-slate-800"></div>

                <a href="#" class="flex items-center p-3 hover:bg-slate-800 rounded-lg group transition-colors">
                    <i data-lucide="users" class="w-6 h-6"></i>
                    <span x-show="sidebarOpen" x-cloak class="ml-3 font-medium text-sm">Usuarios</span>
                </a>

                <div>
                    <button @click="openUbicaciones = !openUbicaciones" 
                        class="w-full flex items-center justify-between p-3 hover:bg-slate-800 rounded-lg transition-colors">
                        <div class="flex items-center">
                            <i data-lucide="map-pin" class="w-6 h-6"></i>
                            <span x-show="sidebarOpen" x-cloak class="ml-3 font-medium text-sm">Ubicaciones</span>
                        </div>
                        <i x-show="sidebarOpen" x-cloak data-lucide="chevron-down" 
                            :class="openUbicaciones ? 'rotate-180' : ''" class="w-4 h-4 transition-transform"></i>
                    </button>
                    
                    <div x-show="openUbicaciones && sidebarOpen" x-cloak class="pl-12 pr-4 py-2 space-y-1 bg-slate-800/30 rounded-lg mt-1">
                        <a href="{{ route('provincias.index') }}" class="block py-2 text-xs hover:text-blue-400 transition-colors italic uppercase tracking-wider">Provincias</a>
                        <a href="{{ route('localidades.index') }}" class="block py-2 text-xs hover:text-blue-400 transition-colors italic uppercase tracking-wider">Localidades</a>
                        <a href="#" class="block py-2 text-xs hover:text-blue-400 transition-colors italic uppercase tracking-wider">Barrios</a>
                        <a href="{{ route('zonas-barrios.index') }}" class="block py-2 text-xs hover:text-blue-400 transition-colors italic uppercase tracking-wider">Zonas</a>
                    </div>
                </div>

                <a href="#" class="flex items-center p-3 hover:bg-slate-800 rounded-lg group transition-colors">
                    <i data-lucide="activity" class="w-6 h-6"></i>
                    <span x-show="sidebarOpen" x-cloak class="ml-3 font-medium text-sm">Enfermedades</span>
                </a>

                <a href="#" class="flex items-center p-3 hover:bg-slate-800 rounded-lg group transition-colors">
                    <i data-lucide="heart" class="w-6 h-6"></i>
                    <span x-show="sidebarOpen" x-cloak class="ml-3 font-medium text-sm">Estado Civil</span>
                </a>

                <a href="#" class="flex items-center p-3 hover:bg-slate-800 rounded-lg group transition-colors">
                    <i data-lucide="graduation-cap" class="w-6 h-6"></i>
                    <span x-show="sidebarOpen" x-cloak class="ml-3 font-medium text-sm">Niveles de Estudio</span>
                </a>

                <a href="#" class="flex items-center p-3 hover:bg-slate-800 rounded-lg group transition-colors">
                    <i data-lucide="briefcase" class="w-6 h-6"></i>
                    <span x-show="sidebarOpen" x-cloak class="ml-3 font-medium text-sm">Prog. Asistencia</span>
                </a>
                <a href="{{ route('home') }}" class="flex items-center p-3 hover:bg-slate-800 rounded-lg group transition-colors">
                    <i data-arrow="briefcase" class="w-6 h-6"></i>
                    <span x-show="sidebarOpen" x-cloak class="ml-3 font-medium text-sm">Volver al Inicio</span>
                </a>
            </nav>
        </aside>

        <div class="flex-1 flex flex-col overflow-hidden">
            <header class="h-16 bg-white border-b flex items-center justify-between px-8 z-10 shadow-sm">
                <div class="flex items-center gap-4 text-slate-400">
                    <span class="text-sm font-medium">Panel Administrativo</span>
                    <i data-lucide="chevron-right" class="w-4 h-4"></i>
                    <span class="text-sm font-bold text-slate-800 uppercase italic">@yield('header')</span>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto p-8">
                @yield('content')
            </main>
        </div>
    </div>

    <script>lucide.createIcons();</script>
</body>
</html>