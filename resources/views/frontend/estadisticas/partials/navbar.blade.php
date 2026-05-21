<header class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div class="d-flex align-items-center gap-3">
        <button class="btn btn-white shadow-sm border rounded-3 d-lg-none px-3" type="button" onclick="toggleSidebar()">
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

    <div class="stats-filters mt-3">

        <form method="GET"
            class="row g-3 align-items-end">

            {{-- Año --}}
            <div class="col-md-2">

                <label class="form-label small fw-bold">
                    Año
                </label>

                <select name="year"
                        class="form-select">

                    @for($y = now()->year; $y >= 2020; $y--)

                        <option value="{{ $y }}"
                            {{ request('year', now()->year) == $y ? 'selected' : '' }}>

                            {{ $y }}

                        </option>

                    @endfor

                </select>

            </div>

            {{-- Tipo gráfico --}}
            <div class="col-md-2">

                <label class="form-label small fw-bold">
                    Visualización
                </label>

                <select name="chart"
                        id="chartType"
                        class="form-select">

                    <option value="line">Línea</option>

                    <option value="bar">Histograma</option>

                    <option value="doughnut">Donut</option>

                    <option value="pie">Pie</option>

                </select>

            </div>

            {{-- Agrupación --}}
            <div class="col-md-3">

                <label class="form-label small fw-bold">
                    Agrupar por
                </label>

                <select name="group_by"
                        id="groupBy"
                        class="form-select">

                    <option value="mes">
                        Mes
                    </option>

                    <option value="derivacion_id">
                        Derivación
                    </option>

                    <option value="usuario_id">
                        Usuario
                    </option>

                    <option value="barrio_id">
                        Barrio
                    </option>

                    <option value="programa_id">
                        Programa
                    </option>

                </select>

            </div>

            {{-- Botón --}}
            <div class="col-md-2">

                <button class="btn btn-primary w-100">

                    <i class="bi bi-funnel"></i>

                    Aplicar

                </button>

            </div>

        </form>

    </div>

    <div class="d-flex align-items-center gap-3 justify-content-between justify-content-md-end">
        <div class="bg-white rounded-4 px-3 py-2 shadow-sm d-flex align-items-center gap-2 border border-light">
            <div class="text-primary bg-primary-subtle rounded-3 p-2 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                <i class="bi bi-calendar3 small"></i>
            </div>
            <span class="fw-semibold text-secondary small">
                {{ now()->format('d/m/Y') }}
            </span>
        </div>

        <a href="#" class="bg-white rounded-circle d-flex justify-content-center align-items-center shadow-sm border border-light text-secondary stats-avatar"
           style="width: 48px; height: 48px; transition: all 0.2s ease;" title="Mi Perfil">
            <i class="bi bi-person-circle fs-4 text-dark text-opacity-75"></i>
        </a>
    </div>
</header>