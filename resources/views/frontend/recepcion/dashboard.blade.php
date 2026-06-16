@extends('frontend.recepcion.layout.app')

@section('title', 'Inicio')

@section('content')

<style>
    /* HEADER PREMIUM */
    .dashboard-header {
        background: var(--grad-main);
        border-radius: var(--radius-xl);
        padding: 28px 32px;
        color: white;
        margin-bottom: 30px;
        box-shadow: var(--shadow-md);
        position: relative;
        overflow: hidden;
    }

    .dashboard-header::after {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 350px;
        height: 350px;
        background: radial-gradient(circle, rgba(255,255,255,0.15) 0%, transparent 70%);
        border-radius: 50%;
    }

    .dashboard-header h2 {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 800;
        margin-bottom: 6px;
        letter-spacing: -0.5px;
    }

    .dashboard-header p {
        margin: 0;
        color: rgba(255, 255, 255, 0.85);
        font-size: 0.98rem;
        font-weight: 500;
    }

    /* SECCIONES / CONTENEDORES MAESTROS */
    .section-card {
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.8);
        border-radius: var(--radius-xl);
        padding: 24px;
        box-shadow: var(--shadow-sm);
        height: 100%;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .section-card:hover {
        box-shadow: var(--shadow-md);
        transform: translateY(-2px);
    }

    .section-title {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 20px;
        padding-bottom: 12px;
        border-bottom: 2px solid var(--neutral-100);
    }

    .section-title i {
        font-size: 1.4rem;
    }

    .section-title h4 {
        margin: 0;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 700;
        font-size: 1.15rem;
        color: var(--neutral-900);
    }

    /* BOTONES DE ACCIÓN COMPACTOS */
    .action-row {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .action-btn {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 16px 20px;
        border-radius: var(--radius-md);
        background: white;
        border: 1px solid var(--neutral-200);
        text-decoration: none;
        transition: all 0.2s ease;
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
        font-size: 1.1rem;
        transition: all 0.2s ease;
    }

    .action-text h5 {
        margin: 0;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 700;
        font-size: 0.95rem;
        color: var(--neutral-800);
        transition: color 0.2s;
    }

    .action-text p {
        margin: 2px 0 0;
        font-size: 0.82rem;
        color: var(--neutral-600);
    }

    .action-arrow {
        color: var(--neutral-400);
        transform: translateX(0);
        transition: all 0.2s ease;
        font-size: 0.9rem;
    }

    /* VARIACIONES TEMÁTICAS */
    
    /* Variación Sky (Ingresos) */
    .theme-sky .section-title i { color: var(--sky-500); }
    .theme-sky .action-icon { background: var(--sky-50); color: var(--sky-600); }
    .theme-sky .action-btn:hover {
        border-color: var(--sky-300);
        background: linear-gradient(95deg, white 0%, var(--sky-50) 100%);
    }
    .theme-sky .action-btn:hover .action-icon { background: var(--sky-500); color: white; }
    .theme-sky .action-btn:hover .action-text h5 { color: var(--sky-700); }
    .theme-sky .action-btn:hover .action-arrow { color: var(--sky-600); transform: translateX(4px); }

    /* Variación Teal (Mercadería) */
    .theme-teal .section-title i { color: var(--teal-500); }
    .theme-teal .action-icon { background: var(--teal-50); color: var(--teal-600); }
    .theme-teal .action-btn:hover {
        border-color: var(--teal-300);
        background: linear-gradient(95deg, white 0%, var(--teal-50) 100%);
    }
    .theme-teal .action-btn:hover .action-icon { background: var(--teal-500); color: white; }
    .theme-teal .action-btn:hover .action-text h5 { color: var(--teal-700); }
    .theme-teal .action-btn:hover .action-arrow { color: var(--teal-600); transform: translateX(4px); }

    /* Variación Indigo/Purple (Sepelios) */
    .theme-purple .section-title i { color: #6f42c1; }
    .theme-purple .action-icon { background: #f3f0fa; color: #6f42c1; }
    .theme-purple .action-btn:hover {
        border-color: #b8a2e3;
        background: linear-gradient(95deg, white 0%, #f3f0fa 100%);
    }
    .theme-purple .action-btn:hover .action-icon { background: #6f42c1; color: white; }
    .theme-purple .action-btn:hover .action-text h5 { color: #492790; }
    .theme-purple .action-btn:hover .action-arrow { color: #6f42c1; transform: translateX(4px); }

    /* Variación Warning (Bajo Peso) */
    .theme-warning .section-title i { color: #ffc107; }
    .theme-warning .action-icon { background: #fff9e6; color: #d39e00; }
    .theme-warning .action-btn:hover {
        border-color: #ffe082;
        background: linear-gradient(95deg, white 0%, #fff9e6 100%);
    }
    .theme-warning .action-btn:hover .action-icon { background: #ffc107; color: #212529; }
    .theme-warning .action-btn:hover .action-text h5 { color: #856404; }
    .theme-warning .action-btn:hover .action-arrow { color: #d39e00; transform: translateX(4px); }
</style>

{{-- HEADER UNIFICADO --}}
<div class="dashboard-header">
    <h2>Mesa de Entrada</h2>
    <p>Módulo de Recepción y Articulación — Gestión de solicitudes y distribución de insumos.</p>
</div>

{{-- DISTRIBUCIÓN SEGMENTADA --}}
<div class="row g-4">

    {{-- BLOQUE 1: ATENCIÓN SOCIAL E INGRESOS --}}
    <div class="col-lg-4">
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
                            <p>Consultar, filtrar y hacer seguimiento de los ingresos previos.</p>
                        </div>
                    </div>
                    <i class="bi bi-chevron-right action-arrow"></i>
                </a>
            </div>
        </div>
    </div>

    {{-- BLOQUE 2: GESTIÓN DE MERCADERÍA --}}
    <div class="col-lg-4">
        <div class="section-card theme-teal">
            <div class="section-title">
                <i class="bi bi-box-seam-fill"></i>
                <h4>Control de Insumos y Mercadería</h4>
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
                            <p>Historial de retiros.</p>
                        </div>
                    </div>
                    <i class="bi bi-chevron-right action-arrow"></i>
                </a>
            </div>
        </div>
    </div>

    {{-- BLOQUE 3: SERVICIOS DE SEPELIO --}}
    <div class="col-lg-4">
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
                            <p>Registrar una nueva asistencia o cobertura de sepelio.</p>
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
    <div class="col-lg-4">
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
                            <p>Registrar un niño dentro del programa.</p>
                        </div>
                    </div>
                    <i class="bi bi-chevron-right action-arrow"></i>
                </a>

                {{-- HISTORIAL Y ENTREGAS --}}
                <a href="{{ route('bajo-peso.index') }}" class="action-btn">
                    <div class="action-btn-content">
                        <div class="action-icon">
                            <i class="bi bi-archive-fill"></i>
                        </div>
                        <div class="action-text">
                            <h5>Historial y Entregas</h5>
                            <p>Consultar beneficiarios y bolsones entregados.</p>
                        </div>
                    </div>
                    <i class="bi bi-chevron-right action-arrow"></i>
                </a>
            </div>
        </div>
    </div>

</div>

@endsection