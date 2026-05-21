<aside class="stats-sidebar d-flex flex-column p-3" id="sidebar">
    <div class="d-flex align-items-center justify-content-between px-2 mb-4 mt-2">
        <h3 class="text-white fw-bold mb-0 flex-grow-1 fs-4">
            <i class="bi bi-shield-shaded text-primary me-2"></i>Comunidad
        </h3>
        <button class="btn text-white-50 d-lg-none p-1 border-0" onclick="toggleSidebar()" aria-label="Cerrar menú">
            <i class="bi bi-x-lg fs-5"></i>
        </button>
    </div>

    <nav class="nav flex-column gap-1 flex-grow-1">
        @php
            $menuItems = [
                ['route' => 'estadisticas.dashboard', 'icon' => 'bi-grid', 'label' => 'Dashboard'],
                ['route' => 'estadisticas.ingresos', 'icon' => 'bi-box-arrow-in-right', 'label' => 'Ingresos'],
                ['route' => 'estadisticas.destinatarios', 'icon' => 'bi-people', 'label' => 'Destinatarios'],
                ['route' => 'estadisticas.beneficios', 'icon' => 'bi-award', 'label' => 'Beneficios'],
                ['route' => 'estadisticas.atenciones', 'icon' => 'bi-heart-pulse', 'label' => 'Atenciones'],
                ['route' => 'estadisticas.familias', 'icon' => 'bi-houses', 'label' => 'Familias'],
                ['route' => 'estadisticas.territorial', 'icon' => 'bi-geo-alt', 'label' => 'Territorial'],
                ['route' => 'estadisticas.mercaderias', 'icon' => 'bi-box-seam', 'label' => 'Mercaderías'],
            ];
        @endphp

        @foreach($menuItems as $item)
            <a href="{{ route($item['route']) }}" 
               class="nav-link {{ request()->routeIs($item['route']) ? 'active' : '' }}">
                <i class="bi {{ $item['icon'] }} fs-5"></i>
                <span>{{ $item['label'] }}</span>
            </a>
        @endforeach

        
    </nav>

    <div class="pt-3 border-top border-secondary border-opacity-25 px-2">
         <a href="{{ route('home') }}"
                class="flex items-center p-3 text-zinc-400 hover:bg-zinc-800/50 hover:text-white rounded-xl transition-all group">

                    <i data-lucide="house" class="w-5 h-5"></i>

                    <span x-show="sidebarOpen"
                        class="ml-3 text-sm font-medium">
                        Volver al Home
                    </span>
                </a>
        <span class="text-muted small">Desarrollo Humano</span>
    </div>
</aside>