@extends('frontend.layout.front')

@section('title', 'Grupos Familiares')

@section('content')

{{-- HERO --}}
<section style="background: linear-gradient(135deg, #f5f3ff 0%, #ede9fe 100%); border-bottom: 1px solid #ddd6fe; padding: 2rem 0 1.6rem;">
    <div class="container">
        <div class="d-flex align-items-center gap-3 mb-2">
            <div style="width:44px; height:44px; background:linear-gradient(135deg,#7c3aed,#8b5cf6); border-radius:13px; display:flex; align-items:center; justify-content:center; color:white; font-size:20px; box-shadow:0 4px 10px rgba(124,58,237,0.25);">
                <i class="bi bi-diagram-3-fill"></i>
            </div>
            <div>
                <h1 style="font-family:'Plus Jakarta Sans',sans-serif; font-weight:800; font-size:1.5rem; color:#0f172a; margin:0; line-height:1.2;">Grupos Familiares</h1>
                <p style="color:#536070; font-size:13px; font-weight:500; margin:0;">Administración y visualización de grupos registrados</p>
            </div>
        </div>
    </div>
</section>

<div class="container py-4">

    {{-- BUSCADOR --}}
    <div style="background:white; border-radius:16px; padding:20px; border:1px solid #e2e8f0; box-shadow:0 2px 10px rgba(0,0,0,0.04); margin-bottom:1.5rem;">
        <form method="GET">
            <div class="row g-3 align-items-end">
                <div class="col-md-5">
                    <label style="font-family:'Plus Jakarta Sans',sans-serif; font-size:11.5px; font-weight:700; color:#0f172a; display:block; margin-bottom:6px; text-transform:uppercase; letter-spacing:0.5px;">Buscar</label>
                    <div style="position:relative;">
                        <i class="bi bi-search" style="position:absolute; left:12px; top:50%; transform:translateY(-50%); color:#94a3b8; font-size:14px;"></i>
                        <input type="text" name="q" class="form-control" placeholder="Código, apellido o DNI..." value="{{ request('q') }}" style="padding-left:36px; border-radius:10px; border-color:#e2e8f0; font-size:13.5px;">
                    </div>
                </div>
                <div class="col-md-4">
                    <label style="font-family:'Plus Jakarta Sans',sans-serif; font-size:11.5px; font-weight:700; color:#0f172a; display:block; margin-bottom:6px; text-transform:uppercase; letter-spacing:0.5px;">Estado mercadería</label>
                    <select name="mercaderia" class="form-select" style="border-radius:10px; border-color:#e2e8f0; font-size:13.5px;">
                        <option value="">Todos</option>
                        <option value="si" {{ request('mercaderia')=='si'?'selected':'' }}>Retiró este mes</option>
                        <option value="no" {{ request('mercaderia')=='no'?'selected':'' }}>No retiró</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" style="width:100%; background:linear-gradient(135deg,#7c3aed,#8b5cf6); color:white; border:none; border-radius:10px; padding:9px 16px; font-family:'Plus Jakarta Sans',sans-serif; font-weight:700; font-size:13.5px; display:flex; align-items:center; justify-content:center; gap:7px; cursor:pointer;">
                        <i class="bi bi-search"></i> Buscar
                    </button>
                </div>
            </div>
        </form>
    </div>

    {{-- LISTADO --}}
    <div class="row g-3">
        @forelse($familias as $familia)
            @php
                $ultimaEntrega = $familia->mercaderias->sortByDesc('fecha_entrega')->first();
                $retiroEsteMes = $ultimaEntrega &&
                    \Carbon\Carbon::parse($ultimaEntrega->fecha_entrega)->month == now()->month &&
                    \Carbon\Carbon::parse($ultimaEntrega->fecha_entrega)->year == now()->year;
            @endphp

            <div class="col-xl-4 col-md-6">
                <div style="background:white; border-radius:18px; border:1px solid #e2e8f0; border-top:3px solid #7c3aed; box-shadow:0 2px 12px rgba(0,0,0,0.04); height:100%; display:flex; flex-direction:column;">

                    {{-- HEADER de la card --}}
                    <div style="padding:18px 18px 14px; border-bottom:1px solid #f1f5f9;">
                        <div style="display:flex; justify-content:space-between; align-items:flex-start; gap:10px;">
                            <div>
                                <div style="display:flex; align-items:center; gap:8px; margin-bottom:4px;">
                                    <div style="width:32px; height:32px; background:linear-gradient(135deg,#7c3aed,#8b5cf6); border-radius:9px; display:flex; align-items:center; justify-content:center; color:white; font-size:14px; flex-shrink:0;">
                                        <i class="bi bi-house-fill"></i>
                                    </div>
                                    <h5 style="font-family:'Plus Jakarta Sans',sans-serif; font-weight:800; font-size:1rem; color:#0f172a; margin:0;">{{ $familia->codigo }}</h5>
                                </div>
                                <p style="font-size:12px; color:#536070; font-weight:500; margin:0;">{{ $familia->personas_count }} {{ $familia->personas_count == 1 ? 'integrante' : 'integrantes' }}</p>
                            </div>
                            <div>
                                @if($retiroEsteMes)
                                    <span style="background:#fef2f2; color:#b91c1c; border:1px solid #fecaca; border-radius:40px; padding:4px 11px; font-size:11px; font-weight:700; white-space:nowrap;">
                                        <i class="bi bi-x-circle-fill" style="font-size:10px;"></i> Ya retiró
                                    </span>
                                @else
                                    <span style="background:#f0fdf4; color:#166534; border:1px solid #bbf7d0; border-radius:40px; padding:4px 11px; font-size:11px; font-weight:700; white-space:nowrap;">
                                        <i class="bi bi-check-circle-fill" style="font-size:10px;"></i> Habilitado
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- INTEGRANTES --}}
                    <div style="padding:14px 18px; flex:1; display:flex; flex-direction:column; gap:7px;">
                        @foreach($familia->personas as $persona)
                        <div style="background:#f8fafc; border-radius:10px; padding:9px 12px; border:1px solid #f1f5f9;">
                            <div style="display:flex; align-items:center; justify-content:space-between; gap:8px;">
                                <div style="font-family:'Plus Jakarta Sans',sans-serif; font-weight:700; font-size:13px; color:#0f172a;">
                                    {{ $persona->apellido }}, {{ $persona->nombre }}
                                </div>

                                <button type="button"
                                        onclick="abrirModalPrograma({{ $persona->id }}, @js($persona->nombre . ' ' . $persona->apellido), {{ $persona->fecha_nacimiento ? \Carbon\Carbon::parse($persona->fecha_nacimiento)->age : 'null' }})"
                                        style="border:1px solid #b3e0f5; background:#e6f5fb; color:#0879a8; border-radius:8px; padding:5px 9px; font-size:11px; font-weight:700; cursor:pointer; display:inline-flex; align-items:center; gap:4px; white-space:nowrap;"
                                        title="Asignar programa">
                                    <i class="bi bi-plus-circle"></i>
                                    Asignar
                                </button>
                            </div>
                            

                            <div style="font-size:11.5px; color:#536070; font-weight:500; margin-top:1px;">
                                DNI: {{ $persona->dni ?? 'No cargado' }}
                            </div>
                        </div>
                        @endforeach
                    </div>

                    {{-- FOOTER --}}
                    <div style="padding:12px 18px; border-top:1px solid #f1f5f9; display:flex; justify-content:space-between; align-items:center;">
                        @if($ultimaEntrega)
                            <span style="font-size:11.5px; color:#536070; font-weight:500;">
                                <i class="bi bi-clock-history" style="color:#94a3b8; font-size:12px;"></i>
                                Última entrega: <strong style="color:#0f172a;">{{ \Carbon\Carbon::parse($ultimaEntrega->fecha_entrega)->format('d/m/Y') }}</strong>
                            </span>
                        @else
                            <span style="font-size:11.5px; color:#94a3b8; font-weight:500;">Sin entregas registradas</span>
                        @endif
                        <a href="{{ route('familias.show', $familia->id) }}" style="background:#f3e8ff; color:#6d28d9; border:1px solid #d8b4fe; border-radius:8px; padding:5px 12px; font-size:12px; font-weight:700; text-decoration:none; white-space:nowrap;">
                            Ver grupo
                        </a>
                    </div>

                </div>
            </div>

        @empty
            <div class="col-12">
                <div style="background:white; border-radius:18px; padding:3rem; text-align:center; border:1px solid #e2e8f0;">
                    <div style="width:56px; height:56px; background:#f3e8ff; border-radius:16px; display:flex; align-items:center; justify-content:center; margin:0 auto 1rem; font-size:24px; color:#7c3aed;">
                        <i class="bi bi-people"></i>
                    </div>
                    <h5 style="font-family:'Plus Jakarta Sans',sans-serif; font-weight:800; color:#0f172a; margin-bottom:6px;">Sin resultados</h5>
                    <p style="color:#536070; font-size:13.5px; margin:0;">No hay grupos familiares que coincidan con la búsqueda.</p>
                </div>
            </div>
        @endforelse
    </div>

    {{-- PAGINACIÓN --}}
    <div class="mt-4">
        {{ $familias->links() }}
    </div>

</div>


{{-- ============================================================
     MODAL: ASIGNAR PROGRAMA A INTEGRANTE
     Requiere que el controlador de esta vista envíe:
     $programas y $sedes.
============================================================ --}}
<div id="modalProgramaGrupo"
     style="display:none; position:fixed; inset:0; background:rgba(15,23,42,0.45); z-index:2050; align-items:center; justify-content:center; backdrop-filter:blur(3px); padding:16px;">

    <div style="background:white; border-radius:20px; width:90%; max-width:460px; max-height:90vh; overflow:visible; box-shadow:0 20px 60px rgba(0,0,0,0.18); animation:fadeUpGrupo .28s ease;">

        <div style="padding:18px 24px 16px; border-bottom:1px solid #e2e8f0; display:flex; justify-content:space-between; align-items:center; background:linear-gradient(135deg,#e6f5fb 0%,#e8f9f5 100%); border-radius:20px 20px 0 0;">
            <div style="display:flex; align-items:center; gap:10px;">
                <div style="width:36px; height:36px; border-radius:10px; background:linear-gradient(135deg,#0d92c2,#17a385); display:flex; align-items:center; justify-content:center; color:white; font-size:16px;">
                    <i class="bi bi-grid-3x3-gap-fill"></i>
                </div>
                <div>
                    <h3 style="margin:0; font-size:15px; font-weight:800; color:#0f172a; font-family:'Plus Jakarta Sans',sans-serif;">Asignar Programa</h3>
                    <div id="nombrePersonaPrograma" style="font-size:11.5px; color:#536070; margin-top:2px;"></div>
                </div>
            </div>

            <button type="button"
                    onclick="cerrarModalProgramaGrupo()"
                    style="background:white; border:1px solid #e2e8f0; border-radius:8px; width:32px; height:32px; display:flex; align-items:center; justify-content:center; color:#94a3b8; cursor:pointer; font-size:18px; line-height:1;">
                &times;
            </button>
        </div>

        <div style="padding:24px; position:relative;">

            <div id="alertaProgramaGrupo"
                 style="display:none; background:#fef2f2; border:1px solid #fecaca; border-radius:12px; padding:12px; margin-bottom:18px; color:#991b1b; font-size:12.5px; line-height:1.5;">
                <i class="bi bi-exclamation-triangle-fill me-1"></i>
                <span id="mensajeProgramaGrupo"></span>
            </div>

            <form action="{{ route('persona-programa.store') }}" method="POST">
                @csrf

                <input type="hidden" name="persona_id" id="personaProgramaId">

                <div style="margin-bottom:20px;">
                    <label style="display:block; font-size:12px; font-weight:800; color:#536070; margin-bottom:8px; text-transform:uppercase; letter-spacing:.06em;">
                        Programa disponible
                    </label>

                    <select name="programa_id" id="programaSelectGrupo" required
                            style="width:100%; padding:11px 14px; border-radius:12px; border:1.5px solid #e0ddd6; font-size:13.5px; color:#0f172a; font-family:'Plus Jakarta Sans',sans-serif; background:white; outline:none;">
                        <option value="" disabled selected>Seleccionar programa...</option>

                        @isset($programas)
                            @foreach($programas as $programa)
                                <option value="{{ $programa->id }}"
                                        data-programa="{{ $programa->nombre }}">
                                    {{ $programa->nombre }}
                                </option>
                            @endforeach
                        @endisset
                    </select>

                    <div id="mensajeProgramaDuplicadoGrupo"
                         style="display:none; margin-top:8px; font-size:12.5px; color:#b91c1c;"></div>
                </div>

                <div id="wrapperSedeGrupo" style="margin-bottom:20px;">
                    <label style="display:block; font-size:12px; font-weight:800; color:#536070; margin-bottom:8px; text-transform:uppercase; letter-spacing:.06em;">
                        Sede
                    </label>

                    <select name="sede_id" id="selectSedeGrupo"
                            style="width:100%; padding:11px 14px; border-radius:12px; border:1.5px solid #e0ddd6; font-size:13.5px; color:#0f172a; background:white;">
                        <option value="" selected disabled>Seleccionar sede...</option>

                        @isset($sedes)
                            @foreach($sedes as $sede)
                                <option value="{{ $sede->id }}"
                                        data-programa-id="{{ $sede->programa_id ?? '' }}">
                                    {{ $sede->nombre }}
                                </option>
                            @endforeach
                        @endisset
                    </select>
                </div>

                <div style="margin-bottom:20px;">
                    <label style="display:block; font-size:12px; font-weight:800; color:#536070; margin-bottom:8px; text-transform:uppercase;">
                        Rol en el programa
                    </label>

                    <select name="rol" id="rolProgramaGrupo" required
                            style="width:100%; padding:11px 14px; border-radius:12px; border:1.5px solid #e0ddd6;">
                        <option value="destinatario">Destinatario</option>
                        <option value="tutor">Tutor</option>
                    </select>
                </div>

                <div style="margin-bottom:12px;">
                    <label style="display:block; font-size:12px; font-weight:800; color:#536070; margin-bottom:6px;">
                        Fecha inicio
                    </label>
                    <input type="date" name="fecha_inicio" value="{{ now()->format('Y-m-d') }}"
                           style="width:100%; padding:10px; border-radius:10px; border:1px solid #e0ddd6;">
                </div>

                <div style="margin-bottom:20px;">
                    <label style="display:block; font-size:12px; font-weight:800; color:#536070; margin-bottom:6px;">
                        Fecha fin
                    </label>
                    <input type="date" name="fecha_fin"
                           style="width:100%; padding:10px; border-radius:10px; border:1px solid #e0ddd6;">
                </div>

                <button type="button"
                        id="btnAdaptacionGrupo"
                        style="width:100%; justify-content:center; display:inline-flex; align-items:center; gap:7px; height:40px; padding:0 18px; border-radius:12px; background:white; color:#536070; font-family:'Plus Jakarta Sans',sans-serif; font-size:13px; font-weight:600; text-decoration:none; border:1px solid #e0ddd6; cursor:pointer;">
                    <i class="bi bi-clock-history"></i>
                    Período de adaptación
                </button>

                <div id="panelAdaptacionGrupo"
                     style="display:none; margin-top:12px; background:#f8fafe; border:1px solid #b3e0f5; border-radius:14px; padding:14px;">

                    <div style="font-weight:800; font-size:13px; color:#0f172a; margin-bottom:6px;">
                        Período de adaptación
                    </div>

                    <p style="font-size:12px; color:#536070; margin-bottom:10px;">
                        ¿Desea ingresar a la persona en período de adaptación?
                    </p>

                    <input type="hidden" name="en_adaptacion" id="enAdaptacionGrupo" value="0">

                    <label style="font-size:12px; color:#536070; font-weight:600;">Fecha límite</label>
                    <input type="date" name="fecha_limite_adaptacion" id="fechaAdaptacionGrupo"
                           class="form-control" style="margin-top:5px;">

                    <div style="display:flex; gap:8px; margin-top:12px;">
                        <button type="button" onclick="aceptarAdaptacionGrupo()"
                                style="display:inline-flex; align-items:center; gap:7px; height:38px; padding:0 14px; border-radius:10px; border:none; background:linear-gradient(135deg,#0d92c2,#17a385); color:white; font-weight:700; cursor:pointer;">
                            Aceptar
                        </button>

                        <button type="button" onclick="cancelarAdaptacionGrupo()"
                                style="display:inline-flex; align-items:center; gap:7px; height:38px; padding:0 14px; border-radius:10px; background:white; color:#536070; border:1px solid #e0ddd6; font-weight:600; cursor:pointer;">
                            Cancelar
                        </button>
                    </div>
                </div>

                <div style="display:flex; justify-content:flex-end; gap:10px; margin-top:20px;">
                    <button type="button" onclick="cerrarModalProgramaGrupo()"
                            style="display:inline-flex; align-items:center; gap:7px; height:40px; padding:0 18px; border-radius:12px; background:white; color:#536070; border:1px solid #e0ddd6; font-family:'Plus Jakarta Sans',sans-serif; font-size:13px; font-weight:600; cursor:pointer;">
                        Cancelar
                    </button>

                    <button type="submit" id="btnAsignarProgramaGrupo"
                            style="display:inline-flex; align-items:center; gap:7px; height:40px; padding:0 18px; border-radius:12px; background:linear-gradient(135deg,#0d92c2,#17a385); color:white; border:none; font-family:'Plus Jakarta Sans',sans-serif; font-size:13px; font-weight:700; cursor:pointer; transition:opacity .2s;">
                        <i class="bi bi-check-lg"></i>
                        Asignar programa
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
@keyframes fadeUpGrupo {
    from { opacity:0; transform:translateY(10px); }
    to { opacity:1; transform:translateY(0); }
}
</style>

<script>
(function () {
    const modal = document.getElementById('modalProgramaGrupo');
    const programaSelect = document.getElementById('programaSelectGrupo');
    const sedeWrapper = document.getElementById('wrapperSedeGrupo');
    const sedeSelect = document.getElementById('selectSedeGrupo');
    const rolSelect = document.getElementById('rolProgramaGrupo');
    const btnAsignar = document.getElementById('btnAsignarProgramaGrupo');
    const alerta = document.getElementById('alertaProgramaGrupo');
    const mensajeAlerta = document.getElementById('mensajeProgramaGrupo');
    const mensajeDuplicado = document.getElementById('mensajeProgramaDuplicadoGrupo');

    let edadActual = null;
    let programasActivosActuales = [];

    window.abrirModalPrograma = function (personaId, nombre, edad) {
        edadActual = edad;
        document.getElementById('personaProgramaId').value = personaId;
        document.getElementById('nombrePersonaPrograma').textContent = nombre;

        const activos = window.programasActivosPorPersona?.[String(personaId)] || [];
        programasActivosActuales = activos.map(p => String(p).trim());

        programaSelect.value = '';
        sedeSelect.value = '';
        rolSelect.value = 'destinatario';

        document.getElementById('enAdaptacionGrupo').value = '0';
        document.getElementById('fechaAdaptacionGrupo').value = '';
        document.getElementById('panelAdaptacionGrupo').style.display = 'none';

        filtrarProgramasPorEdad();
        actualizarSedes();
        validarPrograma();

        modal.style.display = 'flex';
    };

    window.cerrarModalProgramaGrupo = function () {
        modal.style.display = 'none';
    };

    function filtrarProgramasPorEdad() {
        [...programaSelect.options].forEach(option => {
            if (!option.value) return;

            const nombre = option.dataset.programa;
            let visible = true;

            if (nombre === 'Guarderia') visible = edadActual !== null && edadActual <= 5;
            if (nombre === 'UDI') visible = edadActual !== null && edadActual >= 6 && edadActual <= 11;
            if (nombre === 'Envion') visible = edadActual !== null && edadActual >= 12;
            if (nombre === 'Multiespacio') visible = edadActual !== null && edadActual >= 12;

            option.hidden = !visible;
        });

        [...rolSelect.options].forEach(option => {
            if (option.value === 'tutor') {
                option.hidden = !(edadActual !== null && edadActual >= 18 && edadActual <= 25);
            }
        });

        if (rolSelect.value === 'tutor' &&
            !(edadActual !== null && edadActual >= 18 && edadActual <= 25)) {
            rolSelect.value = 'destinatario';
        }
    }

    function actualizarSedes() {
        const option = programaSelect.options[programaSelect.selectedIndex];
        const nombre = option?.dataset?.programa || '';
        const programaId = option?.value || '';

        if (!programaId) {
            sedeWrapper.style.display = 'block';
            [...sedeSelect.options].forEach(o => {
                if (o.value) o.hidden = false;
            });
            return;
        }

        if (nombre === 'Multiespacio') {
            sedeWrapper.style.display = 'none';
            sedeSelect.value = '';
            return;
        }

        sedeWrapper.style.display = 'block';

        [...sedeSelect.options].forEach(function (o) {
            if (!o.value) return;

            const sedeProgramaId = o.dataset.programaId || '';

            if (nombre === 'UDI') {
                o.hidden = sedeProgramaId !== programaId;
            } else {
                o.hidden = sedeProgramaId !== '';
            }
        });

        const seleccion = sedeSelect.options[sedeSelect.selectedIndex];
        if (seleccion && seleccion.hidden) {
            sedeSelect.value = '';
        }
    }

    function validarPrograma() {
        const option = programaSelect.options[programaSelect.selectedIndex];
        const nombre = option?.dataset?.programa?.trim() || '';

        if (nombre && programasActivosActuales.includes(nombre)) {
            alerta.style.display = 'block';
            mensajeAlerta.textContent = `El programa "${nombre}" ya está activo para esta persona.`;
            mensajeDuplicado.style.display = 'block';
            mensajeDuplicado.textContent = `El programa "${nombre}" ya está asignado a esta persona.`;
            btnAsignar.disabled = true;
            btnAsignar.style.opacity = '.5';
            btnAsignar.style.cursor = 'not-allowed';
        } else {
            alerta.style.display = 'none';
            mensajeAlerta.textContent = '';
            mensajeDuplicado.style.display = 'none';
            mensajeDuplicado.textContent = '';
            btnAsignar.disabled = false;
            btnAsignar.style.opacity = '1';
            btnAsignar.style.cursor = 'pointer';
        }
    }

    programaSelect?.addEventListener('change', function () {
        actualizarSedes();
        validarPrograma();
    });

    document.getElementById('btnAdaptacionGrupo')?.addEventListener('click', function () {
        const panel = document.getElementById('panelAdaptacionGrupo');
        panel.style.display = panel.style.display === 'block' ? 'none' : 'block';
    });

    window.aceptarAdaptacionGrupo = function () {
        const fecha = document.getElementById('fechaAdaptacionGrupo').value;

        if (!fecha) {
            alert('Debe indicar la fecha límite del período de adaptación.');
            return;
        }

        document.getElementById('enAdaptacionGrupo').value = '1';
        document.getElementById('panelAdaptacionGrupo').style.display = 'none';
    };

    window.cancelarAdaptacionGrupo = function () {
        document.getElementById('enAdaptacionGrupo').value = '0';
        document.getElementById('fechaAdaptacionGrupo').value = '';
        document.getElementById('panelAdaptacionGrupo').style.display = 'none';
    };

    modal?.addEventListener('click', function (e) {
        if (e.target === modal) cerrarModalProgramaGrupo();
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') cerrarModalProgramaGrupo();
    });

    // Programas actualmente activos de cada integrante.
    window.programasActivosPorPersona = {
        @foreach($familias as $familiaJS)
            @foreach($familiaJS->personas as $personaJS)
                "{{ $personaJS->id }}": @json(
                    $personaJS->personaPrograma
                        ->filter(fn($pp) => is_null($pp->fecha_fin))
                        ->map(fn($pp) => $pp->programa?->nombre)
                        ->filter()
                        ->values()
                ),
            @endforeach
        @endforeach
    };
})();
</script>

@endsection