<header class="d-flex flex-column flex-lg-row justify-content-between align-items-start align-items-lg-center gap-3 mb-4 p-1">
    
    {{-- Bloque Izquierdo: Título y Menú Mobile --}}
    <div class="d-flex align-items-center gap-3">
        <button class="btn btn-light shadow-sm rounded-3 d-lg-none px-3" type="button" onclick="toggleSidebar()" aria-label="Abrir menú">
            <i class="bi bi-list fs-4"></i>
        </button>
        
        <div>
            <h1 class="fw-bold h3 mb-1 text-dark text-opacity-90">
                @yield('titulo')
            </h1>
            <p class="text-muted small mb-0">
                @yield('subtitulo')
            </p>
        </div>
    </div>

    {{-- Bloque Central: Filtros (Se expande fluidamente) --}}
    <div class="stats-filters flex-fill w-100 my-2 my-lg-0 px-lg-3">
        <form method="GET" class="row g-2 align-items-end justify-content-lg-end">

            {{-- Año --}}
            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                <label class="form-label small fw-semibold text-secondary mb-1">Año</label>
                <select name="year" class="form-select form-select-sm rounded-3 shadow-sm">
                    @for($y = now()->year; $y >= 2020; $y--)
                        <option value="{{ $y }}" {{ request('year', now()->year) == $y ? 'selected' : '' }}>
                            {{ $y }}
                        </option>
                    @endfor
                </select>
            </div>

            {{-- Tipo gráfico --}}
            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                <label class="form-label small fw-semibold text-secondary mb-1">Visualización</label>
                <select name="chart" id="chartType" class="form-select form-select-sm rounded-3 shadow-sm">
                    <option value="line" {{ request('chart') == 'line' ? 'selected' : '' }}>Línea</option>
                    <option value="bar" {{ request('chart') == 'bar' ? 'selected' : '' }}>Histograma</option>
                    <option value="doughnut" {{ request('chart') == 'doughnut' ? 'selected' : '' }}>Donut</option>
                    <option value="pie" {{ request('chart') == 'pie' ? 'selected' : '' }}>Pie</option>
                </select>
            </div>

            {{-- Agrupación --}}
            <div class="col-12 col-sm-4 col-md-4 col-lg-3">
                <label class="form-label small fw-semibold text-secondary mb-1">Agrupar por</label>
                <select name="group_by" id="groupBy" class="form-select form-select-sm rounded-3 shadow-sm">
                    <option value="mes" {{ request('group_by') == 'mes' ? 'selected' : '' }}>Mes</option>
                    <option value="derivacion_id" {{ request('group_by') == 'derivacion_id' ? 'selected' : '' }}>Derivación</option>
                    <option value="usuario_id" {{ request('group_by') == 'usuario_id' ? 'selected' : '' }}>Usuario</option>
                    <option value="barrio_id" {{ request('group_by') == 'barrio_id' ? 'selected' : '' }}>Barrio</option>
                    <option value="programa_id" {{ request('group_by') == 'programa_id' ? 'selected' : '' }}>Programa</option>
                </select>
            </div>

            {{-- Botón Aplicar --}}
            <div class="col-12 col-md-2 col-lg-auto">
                <button type="submit" class="btn btn-primary btn-sm rounded-3 shadow-sm w-100 px-3" style="height: 31px;">
                    <i class="bi bi-funnel-fill me-1 small"></i> Aplicar
                </button>
            </div>

        </form>
    </div>

    {{-- Bloque Derecho: Fecha y Perfil --}}
    <div class="d-flex align-items-center gap-2 ms-auto ms-lg-0 justify-content-end w-100 w-lg-auto">
        <div class="bg-white rounded-3 px-3 py-1 shadow-sm d-flex align-items-center gap-2 border border-light" style="height: 38px;">
            <div class="text-primary bg-primary-subtle rounded-2 p-1 d-flex align-items-center justify-content-center" style="width: 24px; height: 24px;">
                <i class="bi bi-calendar3 x-small"></i>
            </div>
            <span class="fw-semibold text-secondary small">
                {{ now()->format('d/m/Y') }}
            </span>
        </div>

        <a href="#" class="bg-white rounded-circle d-flex justify-content-center align-items-center shadow-sm border border-light text-secondary stats-avatar"
           style="width: 38px; height: 38px; transition: all 0.2s ease;" title="Mi Perfil">
            <i class="bi bi-person-circle fs-5 text-dark text-opacity-75"></i>
        </a>
    </div>

</header>