@extends('frontend.recepcion.layout.app')

@section('title', 'Inicio')

@section('content')

<style>
    /* VARIABLES LOCALES COMPLEMENTARIAS */
    :root {
        --purple-50:  #f3f0ff;
        --purple-100: #e0e7ff;
        --purple-500: #7c3aed;
        --purple-600: #6d28d9;
        --purple-700: #5b21b6;

        --gold-50:    #fffbeb;
        --gold-100:   #fef3c7;
        --gold-500:   #d97706;
        --gold-600:   #b45309;
        --gold-700:   #78350f;
    }

    /* HEADER PREMIUM */
    .dashboard-header {
        background: var(--grad-main);
        border-radius: var(--radius-xl);
        padding: 35px 40px;
        color: white;
        margin-bottom: 35px;
        box-shadow: var(--shadow-md);
        position: relative;
        overflow: hidden;
    }

    .dashboard-header::after {
        content: '';
        position: absolute;
        top: -40%;
        right: -5%;
        width: 380px;
        height: 380px;
        background: radial-gradient(circle, rgba(255,255,255,0.18) 0%, transparent 75%);
        border-radius: 50%;
        pointer-events: none;
    }

    .dashboard-header::before {
        content: '';
        position: absolute;
        bottom: -20%;
        left: 30%;
        width: 180px;
        height: 180px;
        background: radial-gradient(circle, rgba(255,255,255,0.08) 0%, transparent 70%);
        border-radius: 50%;
        pointer-events: none;
    }

    .dashboard-header h2 {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 800;
        font-size: 1.8rem;
        margin-bottom: 8px;
        letter-spacing: -0.5px;
        text-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }

    .dashboard-header p {
        margin: 0;
        color: rgba(255, 255, 255, 0.9);
        font-size: 1rem;
        font-weight: 500;
        max-width: 700px;
        line-height: 1.5;
    }

    /* TARJETAS MAESTRAS (CONTENEDORES) */
    .section-card {
        background: rgba(255, 255, 255, 0.65);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border: 1px solid rgba(255, 255, 255, 0.7);
        border-radius: var(--radius-xl);
        padding: 26px;
        box-shadow: var(--shadow-sm);
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
        position: relative;
        overflow: hidden;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .section-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
    }

    .section-card:hover {
        box-shadow: var(--shadow-lg);
        transform: translateY(-4px);
        background: rgba(255, 255, 255, 0.85);
    }

    .section-title {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 22px;
        padding-bottom: 14px;
        border-bottom: 1px solid var(--neutral-200);
    }

    .section-title i {
        font-size: 1.35rem;
    }

    .section-title h4 {
        margin: 0;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 700;
        font-size: 1.15rem;
        color: var(--neutral-900);
        letter-spacing: -0.2px;
    }

    /* FILAS DE ACCIÓN MODERNA */
    .action-row {
        display: flex;
        flex-direction: column;
        gap: 14px;
        flex-grow: 1;
    }

    .action-btn {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 18px 20px;
        border-radius: var(--radius-md);
        background: white;
        border: 1px solid var(--neutral-200);
        text-decoration: none;
        box-shadow: 0 2px 4px rgba(0,0,0,0.01);
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .action-btn-content {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .action-icon {
        width: 44px;
        height: 44px;
        border-radius: var(--radius-sm);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.15rem;
        flex-shrink: 0;
        transition: all 0.25s ease;
    }

    .action-text {
        display: flex;
        flex-direction: column;
    }

    .action-text h5 {
        margin: 0;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 700;
        font-size: 0.95rem;
        color: var(--neutral-800);
        line-height: 1.3;
        transition: color 0.2s;
    }

    .action-text p {
        margin: 4px 0 0;
        font-size: 0.82rem;
        color: var(--neutral-600);
        line-height: 1.4;
    }

    .action-arrow {
        color: var(--neutral-400);
        transition: all 0.25s ease;
        font-size: 0.85rem;
        padding-left: 8px;
    }

    /* VARIACIONES TEMÁTICAS COMPLETA */
    
    /* 1. Sky Theme (Ingresos) */
    .theme-sky::before { background: var(--sky-500); }
    .theme-sky .section-title i { color: var(--sky-500); }
    .theme-sky .action-icon { background: var(--sky-50); color: var(--sky-600); }
    .theme-sky .action-btn:hover {
        border-color: var(--sky-200);
        background: linear-gradient(95deg, white 0%, var(--sky-50) 100%);
        box-shadow: 0 4px 12px rgba(13,146,194,0.06);
    }
    .theme-sky .action-btn:hover .action-icon { background: var(--sky-500); color: white; }
    .theme-sky .action-btn:hover .action-text h5 { color: var(--sky-700); }
    .theme-sky .action-btn:hover .action-arrow { color: var(--sky-600); transform: translateX(3px); }

    /* 2. Teal Theme (Mercadería) */
    .theme-teal::before { background: var(--teal-500); }
    .theme-teal .section-title i { color: var(--teal-500); }
    .theme-teal .action-icon { background: var(--teal-50); color: var(--teal-600); }
    .theme-teal .action-btn:hover {
        border-color: var(--teal-200);
        background: linear-gradient(95deg, white 0%, var(--teal-50) 100%);
        box-shadow: 0 4px 12px rgba(23,163,133,0.06);
    }
    .theme-teal .action-btn:hover .action-icon { background: var(--teal-500); color: white; }
    .theme-teal .action-btn:hover .action-text h5 { color: var(--teal-700); }
    .theme-teal .action-btn:hover .action-arrow { color: var(--teal-600); transform: translateX(3px); }

    /* 3. Purple Theme (Sepelios) */
    .theme-purple::before { background: var(--purple-500); }
    .theme-purple .section-title i { color: var(--purple-500); }
    .theme-purple .action-icon { background: var(--purple-50); color: var(--purple-600); }
    .theme-purple .action-btn:hover {
        border-color: var(--purple-100);
        background: linear-gradient(95deg, white 0%, var(--purple-50) 100%);
        box-shadow: 0 4px 12px rgba(124,58,237,0.06);
    }
    .theme-purple .action-btn:hover .action-icon { background: var(--purple-500); color: white; }
    .theme-purple .action-btn:hover .action-text h5 { color: var(--purple-700); }
    .theme-purple .action-btn:hover .action-arrow { color: var(--purple-600); transform: translateX(3px); }

    /* 4. Warning/Gold Theme (Bajo Peso) */
    .theme-warning::before { background: var(--gold-500); }
    .theme-warning .section-title i { color: var(--gold-500); }
    .theme-warning .action-icon { background: var(--gold-50); color: var(--gold-600); }
    .theme-warning .action-btn:hover {
        border-color: var(--gold-100);
        background: linear-gradient(95deg, white 0%, var(--gold-50) 100%);
        box-shadow: 0 4px 12px rgba(217,119,6,0.06);
    }
    .theme-warning .action-btn:hover .action-icon { background: var(--gold-500); color: white; }
    .theme-warning .action-btn:hover .action-text h5 { color: var(--gold-700); }
    .theme-warning .action-btn:hover .action-arrow { color: var(--gold-600); transform: translateX(3px); }

    /* RESPONSIVE OPTIMIZATIONS */
    @media (max-width: 576px) {
        .dashboard-header { padding: 24px 20px; margin-bottom: 20px; }
        .dashboard-header h2 { font-size: 1.5rem; }
        .dashboard-header p { font-size: 0.9rem; }
        .section-card { padding: 18px; }
    }
</style>

{{-- HEADER UNIFICADO --}}
<div class="dashboard-header">
    <h2>Mesa de Entrada</h2>
    <p>Módulo Unificado de Recepción y Articulación. Registro ágil de solicitudes ciudadanas y control eficiente de la distribución de insumos sociales.</p>
</div>

{{-- DISTRIBUCIÓN EN CUADRANTE (2 ARRIBA, 2 ABAJO) --}}
<div class="row g-4">

    {{-- BLOQUE 1: ATENCIÓN SOCIAL E INGRESOS --}}
    <div class="col-md-6">
        <div class="section-card theme-sky">
            <div class="section-title">
                <i class="bi bi-person-bounding-box"></i>
                <h4>Atención e Ingresos</h4>
            </div>
            
            <div class="action-row">
                {{-- NUEVO INGRESO --}}
                <a href="{{ route('recepcion.ingresos.create') }}" class="action-btn">
                    <div class="action-btn-content">
                        <div class="action-icon">
                            <i class="bi bi-person-plus-fill"></i>
                        </div>
                        <div class="action-text">
                            <h5>Registrar Nuevo Ingreso</h5>
                            <p>Iniciar una nueva planilla de atención a ciudadanos.</p>
                        </div>
                    </div>
                    <i class="bi bi-chevron-right action-arrow"></i>
                </a>

                {{-- HISTORIAL DE INGRESOS --}}
                <a href="{{ route('recepcion.ingresos.index') }}" class="action-btn">
                    <div class="action-btn-content">
                        <div class="action-icon">
                            <i class="bi bi-journal-text"></i>
                        </div>
                        <div class="action-text">
                            <h5>Historial de Atenciones</h5>
                            <p>Consultar, filtrar y hacer seguimiento de ingresos previos.</p>
                        </div>
                    </div>
                    <i class="bi bi-chevron-right action-arrow"></i>
                </a>
            </div>
        </div>
    </div>

    {{-- BLOQUE 2: GESTIÓN DE MERCADERÍA --}}
    <div class="col-md-6">
        <div class="section-card theme-teal">
            <div class="section-title">
                <i class="bi bi-box-seam-fill"></i>
                <h4>Insumos y Mercadería</h4>
            </div>

            <div class="action-row">
                {{-- NUEVA ENTREGA --}}
                <a href="{{ route('recepcion.mercaderias.create') }}" class="action-btn">
                    <div class="action-btn-content">
                        <div class="action-icon">
                            <i class="bi bi-cart-plus-fill"></i>
                        </div>
                        <div class="action-text">
                            <h5>Registrar Entrega</h5>
                            <p>Cargar la salida física de mercaderías o kits sociales.</p>
                        </div>
                    </div>
                    <i class="bi bi-chevron-right action-arrow"></i>
                </a>

                {{-- CONTROL MENSUAL / HISTORIAL --}}
                <a href="{{ route('recepcion.mercaderias.index') }}" class="action-btn">
                    <div class="action-btn-content">
                        <div class="action-icon">
                            <i class="bi bi-clipboard-data-fill"></i>
                        </div>
                        <div class="action-text">
                            <h5>Registro de Entregas</h5>
                            <p>Auditoría integral y control de retiros del depósito.</p>
                        </div>
                    </div>
                    <i class="bi bi-chevron-right action-arrow"></i>
                </a>
            </div>
        </div>
    </div>

    {{-- BLOQUE 3: SERVICIOS DE SEPELIO --}}
    <div class="col-md-6">
        <div class="section-card theme-purple">
            <div class="section-title">
                <i class="bi bi-heart-pulse-fill"></i>
                <h4>Gestión de Sepelios</h4>
            </div>

            <div class="action-row">
                {{-- NUEVA SOLICITUD DE SEPELIO --}}
                <a href="{{ route('recepcion.sepelios.create') }}" class="action-btn">
                    <div class="action-btn-content">
                        <div class="action-icon">
                            <i class="bi bi-file-earmark-medical-fill"></i>
                        </div>
                        <div class="action-text">
                            <h5>Nueva Solicitud</h5>
                            <p>Registrar asistencia o cobertura económica de sepelio.</p>
                        </div>
                    </div>
                    <i class="bi bi-chevron-right action-arrow"></i>
                </a>

                {{-- HISTORIAL / SEGUIMIENTO DE SEPELIOS --}}
                <a href="{{ route('recepcion.sepelios.index') }}" class="action-btn">
                    <div class="action-btn-content">
                        <div class="action-icon">
                            <i class="bi bi-archive-fill"></i>
                        </div>
                        <div class="action-text">
                            <h5>Historial y Trámites</h5>
                            <p>Consultar estados, órdenes emitidas y expedientes.</p>
                        </div>
                    </div>
                    <i class="bi bi-chevron-right action-arrow"></i>
                </a>
            </div>
        </div>
    </div>

    {{-- BLOQUE 4: PROGRAMA BAJO PESO --}}
    <div class="col-md-6">
        <div class="section-card theme-warning">
            <div class="section-title">
                <i class="bi bi-heart-fill"></i>
                <h4>Programa Bajo Peso</h4>
            </div>

            <div class="action-row">
                {{-- NUEVO BENEFICIARIO --}}
                <a href="{{ route('bajo-peso.create') }}" class="action-btn">
                    <div class="action-btn-content">
                        <div class="action-icon">
                            <i class="bi bi-person-plus-fill"></i>
                        </div>
                        <div class="action-text">
                            <h5>Nuevo Beneficiario</h5>
                            <p>Inscribir y empadronar un niño dentro del programa nutricional.</p>
                        </div>
                    </div>
                    <i class="bi bi-chevron-right action-arrow"></i>
                </a>

                {{-- HISTORIAL Y ENTREGAS --}}
                <a href="{{ route('bajo-peso.index') }}" class="action-btn">
                    <div class="action-btn-content">
                        <div class="action-icon">
                            <i class="bi bi-clipboard2-pulse-fill"></i>
                        </div>
                        <div class="action-text">
                            <h5>Historial y Entregas</h5>
                            <p>Monitorear evolución de beneficiarios y bolsones entregados.</p>
                        </div>
                    </div>
                    <i class="bi bi-chevron-right action-arrow"></i>
                </a>
            </div>
        </div>
    </div>

</div>

@endsection     