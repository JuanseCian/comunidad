<!DOCTYPE html>
<html lang="es" x-data="{ sidebarOpen: true, openUbicaciones: false }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Gestión - @yield('title')</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://unpkg.com/lucide@latest"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: {
                        panel: '#09090b', // Zinc 950
                        sidebar: '#121216',
                        accent: '#4f46e5' // Indigo 600
                    }
                }
            }
        }
    </script>

    <style>
        [x-cloak] { display: none !important; }
        .sidebar-transition { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .nav-item-active { 
            background: rgba(79, 70, 229, 0.1); 
            color: #818cf8;
            border-right: 2px solid #4f46e5;
        }
        /* Scrollbar personalizada */
        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #27272a; border-radius: 10px; }
    </style>
</head>
<body class="bg-[#f8fafc] text-slate-900 font-sans antialiased">

    <div class="flex h-screen overflow-hidden">
        
        <aside 
            :class="sidebarOpen ? 'w-72' : 'w-20'" 
            class="sidebar-transition bg-sidebar border-r border-zinc-800 text-zinc-400 flex-shrink-0 flex flex-col z-30 shadow-2xl">
            
            <div class="h-20 flex items-center px-6 mb-4">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-accent rounded-lg flex items-center justify-center text-white">
                        <i data-lucide="shield-check" class="w-5 h-5"></i>
                    </div>
                    <span x-show="sidebarOpen" x-transition.opacity class="font-bold text-lg text-zinc-100 tracking-tight">
                        Comunidad<span class="text-accent"></span>
                    </span>
                </div>
            </div>

            <nav class="flex-1 overflow-y-auto px-4 space-y-8">
                
                <div>
                    <p x-show="sidebarOpen" class="px-2 text-[10px] font-bold uppercase tracking-[0.2em] text-zinc-500 mb-4">Principal</p>
                    <div class="space-y-1">
                        <a href="{{ route('admin.home') }}" class="flex items-center p-3 hover:bg-zinc-800/50 hover:text-zinc-100 rounded-xl transition-all group">
                            <i data-lucide="layout-dashboard" class="w-5 h-5 transition-transform group-hover:scale-110"></i>
                            <span x-show="sidebarOpen" class="ml-3 font-medium text-sm">Dashboard</span>
                        </a>
                        <a href="#" class="flex items-center p-3 hover:bg-zinc-800/50 hover:text-zinc-100 rounded-xl transition-all group">
                            <i data-lucide="users-2" class="w-5 h-5"></i>
                            <span x-show="sidebarOpen" class="ml-3 font-medium text-sm">Usuarios</span>
                        </a>
                    </div>
                </div>

                <div>
                    <p x-show="sidebarOpen" class="px-2 text-[10px] font-bold uppercase tracking-[0.2em] text-zinc-500 mb-4">Configuración de Red</p>
                    <div class="space-y-1">
                        <div>
                            <button @click="openUbicaciones = !openUbicaciones" 
                                class="w-full flex items-center justify-between p-3 hover:bg-zinc-800/50 hover:text-zinc-100 rounded-xl transition-all group">
                                <div class="flex items-center">
                                    <i data-lucide="map" class="w-5 h-5"></i>
                                    <span x-show="sidebarOpen" class="ml-3 font-medium text-sm">Ubicaciones</span>
                                </div>
                                <i x-show="sidebarOpen" data-lucide="chevron-right" 
                                    :class="openUbicaciones ? 'rotate-90' : ''" class="w-3 h-3 transition-transform text-zinc-600"></i>
                            </button>
                            
                            <div x-show="openUbicaciones && sidebarOpen" x-collapse class="mt-1 ml-4 pl-4 border-l border-zinc-800 space-y-1">
                                <a href="{{ route('provincias.index') }}" class="block p-2 text-sm hover:text-accent transition-colors">Provincias</a>
                                <a href="{{ route('localidades.index') }}" class="block p-2 text-sm hover:text-accent transition-colors">Localidades</a>
                                <a href="{{ route('zonas-barrios.index') }}" class="block p-2 text-sm hover:text-accent transition-colors">Zonas</a>
                                <a href="{{ route('barrios.index') }}" class="block p-2 text-sm hover:text-accent transition-colors">Barrios</a>
                            </div>
                        </div>

                        <a href="{{ route('enfermedades.index') }}" class="flex items-center p-3 hover:bg-zinc-800/50 hover:text-zinc-100 rounded-xl transition-all">
                            <i data-lucide="stethoscope" class="w-5 h-5 text-emerald-500/70"></i>
                            <span x-show="sidebarOpen" class="ml-3 font-medium text-sm">Enfermedades</span>
                        </a>

                        <a href="{{ route('niveles-estudio.index') }}" class="flex items-center p-3 hover:bg-zinc-800/50 hover:text-zinc-100 rounded-xl transition-all">
                            <i data-lucide="book-open" class="w-5 h-5 text-amber-500/70"></i>
                            <span x-show="sidebarOpen" class="ml-3 font-medium text-sm">Niveles de Estudio</span>
                        </a>
                        <a href="{{ route('estados-civiles.index') }}" class="flex items-center p-3 hover:bg-slate-800 rounded-lg group transition-colors">
                            <i data-lucide="heart" class="w-6 h-6"></i>
                            <span x-show="sidebarOpen" x-cloak class="ml-3 font-medium text-sm">Estado Civil</span>
                        </a>
                        <a href="{{ route('programas-asistencia.index') }}" class="flex items-center p-3 hover:bg-slate-800 rounded-lg group transition-colors">
                            <i data-lucide="briefcase" class="w-6 h-6"></i>
                            <span x-show="sidebarOpen" x-cloak class="ml-3 font-medium text-sm">Prog. Asistencia</span>
                        </a>
                        <a href="{{ route('beneficios.index') }}" class="flex items-center p-3 hover:bg-slate-800 rounded-lg group transition-colors">
                            <i data-lucide="user-check" class="w-6 h-6"></i>                    
                            <span x-show="sidebarOpen" x-cloak class="ml-3 font-medium text-sm">Beneficios</span>
                        </a>
                        <a href="{{ route('home') }}" class="flex items-center p-3 hover:bg-slate-800 rounded-lg group transition-colors">
                            <i data-arrow="briefcase" class="w-6 h-6"></i>
                            <span x-show="sidebarOpen" x-cloak class="ml-3 font-medium text-sm">Volver al Inicio</span>
                        </a>
                    </div>
                </div>
            </nav>

            <div class="p-4 border-t border-zinc-800 bg-sidebar/50">
                <a href="{{ route('home') }}" class="flex items-center p-3 text-zinc-500 hover:text-white transition-colors group">
                    <i data-lucide="log-out" class="w-5 h-5"></i>
                    <span x-show="sidebarOpen" class="ml-3 text-sm font-medium tracking-tight">Salir del Sistema</span>
                </a>
            </div>
        </aside>

        <div class="flex-1 flex flex-col overflow-hidden">
            
            <header class="h-20 bg-gradient-to-r from-sky-50 via-white to-emerald-50 border-b border-sky-100 flex items-center justify-between px-8 sticky top-0 z-20 shadow-sm">
                <div class="flex items-center gap-6">
                    <button @click="sidebarOpen = !sidebarOpen" class="text-slate-500 hover:text-accent transition-colors">
                        <i data-lucide="align-left" class="w-6 h-6"></i>
                    </button>
                    
                    <nav class="hidden md:flex items-center gap-3 text-sm">
                        <span class="text-slate-400 font-medium tracking-tight">Panel Administrativo</span>
                        <i data-lucide="chevron-right" class="w-3 h-3 text-slate-300"></i>
                        <span class="font-semibold text-slate-800 px-3 py-1 bg-white/50 border border-sky-100 rounded-full shadow-sm">@yield('header')</span>
                    </nav>
                </div>

                <div class="flex items-center gap-4">
                    <button class="relative p-2 text-slate-400 hover:text-slate-600 transition-colors">
                        <i data-lucide="bell" class="w-5 h-5"></i>
                        <span class="absolute top-2 right-2 w-2 h-2 bg-emerald-500 rounded-full border-2 border-white"></span>
                    </button>
                    <div class="h-8 w-[1px] bg-sky-200/50 mx-2"></div>
                    <div class="flex items-center gap-3 cursor-pointer group">
                        <div class="text-right hidden sm:block">
                            <p class="text-xs font-bold text-slate-900 group-hover:text-accent transition-colors">Administrador</p>
                            <p class="text-[10px] text-slate-400 font-medium tracking-tight">admin@sistema.com</p>
                        </div>
                        <div class="w-10 h-10 rounded-full bg-white border border-sky-200 flex items-center justify-center text-sky-600 font-bold shadow-sm group-hover:border-emerald-300 transition-all">
                            AD
                        </div>
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto bg-[#f8fafc] p-6 lg:p-10">
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