<aside class="stats-sidebar d-flex flex-column py-3 pe-0 text-start" id="sidebar">
    
    <div class="d-flex align-items-center px-3 mb-4 mt-1 gap-2 border-bottom pb-3" style="height: 50px; border-color: var(--bi-sidebar-border) !important;">
        <div class="d-flex align-items-center justify-content-center rounded-circle fw-bold flex-shrink-0 border" 
             style="width: 40px; height: 40px; font-size: 0.85rem; background: linear-gradient(135deg, #e0f2fe, #bae6fd); color: #0369a1; border-color: #bae6fd !important;">
            SN
        </div>
        <div class="sidebar-brand-text overflow-hidden">
            <h5 class="fw-bold text-gradient mb-0" style="font-size: 1rem; letter-spacing: -0.01em; background: linear-gradient(135deg, var(--bi-blue), #3b82f6); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Comunidad</h5>
            <span class="text-muted d-block" style="font-size: 0.68rem; font-weight: 500;">Estadísticas Generales</span>
        </div>
        <button class="btn text-muted d-lg-none p-1 border-0 ms-auto" onclick="toggleSidebar()" aria-label="Cerrar menú">
            <i class="bi bi-x-lg fs-5"></i>
        </button>
    </div>

    <nav class="nav flex-column gap-1 flex-grow-1">
        @php
            $menuItems = [
                ['route' => 'estadisticas.dashboard', 'icon' => 'bi-grid', 'label' => 'Dashboard'],
                ['route' => 'estadisticas.destinatarios', 'icon' => 'bi-people', 'label' => 'Destinatarios'],
                ['route' => 'estadisticas.beneficios', 'icon' => 'bi-award', 'label' => 'Beneficios'],
                ['route' => 'estadisticas.atenciones', 'icon' => 'bi-heart-pulse', 'label' => 'Intervenciones'],
                //Ruta de Familias oculta
                //['route' => 'estadisticas.familias', 'icon' => 'bi-houses', 'label' => 'Familias'],
                //Ruta de Barrios oculta
                //['route' => 'estadisticas.territorial', 'icon' => 'bi-geo-alt', 'label' => 'Territorial'],

                // SOLO RECEPCIÓN
                ['route' => 'estadisticas.ingresos', 'icon' => 'bi-box-arrow-in-right', 'label' => 'Ingresos'],
                ['route' => 'estadisticas.mercaderias', 'icon' => 'bi-box-seam', 'label' => 'Mercaderías'],
                ['route' => 'estadisticas.sepelios', 'icon' => 'bi-heartbreak', 'label' => 'Sepelios'],
            ];

            $rolUsuario = auth()->user()->rol_id;

            $modulosRecepcion = [
                'Ingresos',
                'Mercaderías',
                'Sepelios'
            ];
        @endphp

        @foreach($menuItems as $item)

            @php
                $esModuloRecepcion = in_array($item['label'], $modulosRecepcion);
            @endphp

            {{-- MÓDULOS DE RECEPCIÓN --}}
            @if($esModuloRecepcion && $rolUsuario == 6)

                <a href="{{ route($item['route']) }}"
                class="nav-link {{ request()->routeIs($item['route']) ? 'active' : '' }}"
                title="{{ $item['label'] }}">
                    <i class="bi {{ $item['icon'] }} me-2"></i>
                    <span>{{ $item['label'] }}</span>
                </a>

            {{-- RESTO DE ESTADÍSTICAS --}}
            @elseif(!$esModuloRecepcion && $rolUsuario != 4 && $rolUsuario != 6)

                <a href="{{ route($item['route']) }}"
                class="nav-link {{ request()->routeIs($item['route']) ? 'active' : '' }}"
                title="{{ $item['label'] }}">
                    <i class="bi {{ $item['icon'] }} me-2"></i>
                    <span>{{ $item['label'] }}</span>
                </a>

            @endif

        @endforeach
    </nav>

    <div class="pt-3 border-top px-3 d-flex flex-column gap-1" style="border-color: var(--bi-sidebar-border) !important;">
        <a href="{{ route('home') }}" 
           class="nav-link p-2 rounded-3 border-0 m-0 d-flex align-items-center btn-logout-custom"
           style="background: rgba(239, 68, 68, 0.08); color: #f43f5e;"
           title="Volver al Home">
            <i class="bi bi-box-arrow-left m-0 d-flex align-items-center justify-content-center" style="background: transparent; width:24px; height:24px; font-size:1rem;"></i>
            <span class="ms-2 small fw-semibold">Volver al Home</span>
        </a>
        <div class="sidebar-footer-text mt-2 ps-1">
            <span class="text-secondary fw-medium" style="font-size: 0.7rem; letter-spacing: 0.02em;">Desarrollo Humano</span>
        </div>
    </div>
</aside>