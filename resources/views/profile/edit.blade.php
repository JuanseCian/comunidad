<x-app-layout>
    <x-slot name="header"></x-slot>

    <div class="neo-wrapper-light" x-data="{ tab: 'info' }" x-cloak>
        
        {{-- BRILLO DE FONDO HOLOGRÁFICO (Efecto de esfera/planeta de luz sutil) --}}
        <div class="neo-glow-light"></div>
        <div class="neo-glow-accent"></div>

        <div class="neo-container">
            
            {{-- ENCABEZADO --}}
            <header class="neo-header">
                @php
                    $words = explode(' ', auth()->user()->nombre);
                    $initials = strtoupper(
                        substr($words[0], 0, 1) .
                        (isset($words[1]) ? substr($words[1], 0, 1) : '')
                    );
                @endphp
                
                <div class="neo-avatar-wrapper">
                    <div class="neo-avatar-ring"></div>
                    <div class="neo-avatar">{{ $initials ?: 'US' }}</div>
                </div>

                <div class="neo-user-info">
                    <h1>{{ auth()->user()->name }}</h1>
                    <p>{{ auth()->user()->email }}</p>
                </div>

                {{-- ACCIONES DEL ENCABEZADO (BOTÓN + ESTADO) --}}
                <div class="neo-header-actions">
                    <a href="{{ url('/') }}" class="neo-back-btn">
                        <i class="bi bi-arrow-left"></i>
                        <span>Volver al inicio</span>
                    </a>
                    
                    <div class="neo-status">
                        <span class="status-dot"></span> En línea
                    </div>
                </div>
            </header>

            {{-- MAQUETACIÓN PRINCIPAL --}}
            <div class="neo-layout">
                
                {{-- NAVEGACIÓN LATERAL --}}
                <aside class="neo-sidebar">
                    <nav class="neo-nav">
                        <button class="neo-tab" :class="{ 'active': tab === 'info' }" @click="tab = 'info'">
                            <i class="bi bi-person"></i>
                            <span>Información</span>
                            <div class="neo-indicator"></div>
                        </button>

                        <button class="neo-tab" :class="{ 'active': tab === 'password' }" @click="tab = 'password'">
                            <i class="bi bi-shield-lock"></i>
                            <span>Seguridad</span>
                            <div class="neo-indicator"></div>
                        </button>

                        <button class="neo-tab danger" :class="{ 'active': tab === 'delete' }" @click="tab = 'delete'">
                            <i class="bi bi-trash3"></i>
                            <span>Eliminar cuenta</span>
                            <div class="neo-indicator"></div>
                        </button>
                    </nav>
                </aside>

                {{-- CONTENEDOR DE VISTAS (PARTIALS) --}}
                <main class="neo-content">
                    <div x-show="tab === 'info'" 
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 translate-y-4"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         class="neo-card">
                        @include('profile.partials.update-profile-information-form')
                    </div>

                    <div x-show="tab === 'password'" 
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 translate-y-4"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         class="neo-card" style="display: none;">
                        @include('profile.partials.update-password-form')
                    </div>

                    <div x-show="tab === 'delete'" 
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 translate-y-4"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         class="neo-card danger-card" style="display: none;">
                        @include('profile.partials.delete-user-form')
                    </div>
                </main>
            </div>
        </div>
    </div>

    <style>
        [x-cloak] { display: none !important; }

        /* VARIABLES DE TEMA CLARO FUTURISTA */
        .neo-wrapper-light {
            --bg-base: #f4f7fb;
            --bg-card: rgba(255, 255, 255, 0.65);
            --border-card: rgba(255, 255, 255, 0.8);
            --border-subtle: rgba(15, 23, 42, 0.06);
            --text-main: #0f172a;
            --text-muted: #64748b;
            --accent: #0ea5e9;
            --danger: #ef4444;

            background-color: var(--bg-base);
            min-height: 100vh;
            font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
            color: var(--text-main);
            position: relative;
            overflow: hidden;
            padding-bottom: 5rem;
        }

        /* EFECTOS DE LUZ DE FONDO */
        .neo-glow-light {
            position: absolute;
            top: -10%;
            left: 50%;
            transform: translateX(-50%);
            width: 70vw;
            height: 500px;
            background: radial-gradient(ellipse at center, rgba(14, 165, 233, 0.1) 0%, transparent 70%);
            pointer-events: none;
            z-index: 0;
        }

        .neo-glow-accent {
            position: absolute;
            top: 20%;
            right: -10%;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(139, 92, 246, 0.08) 0%, transparent 60%);
            pointer-events: none;
            z-index: 0;
        }

        .neo-container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 4rem 1.5rem 2rem;
            position: relative;
            z-index: 10;
        }

        /* ENCABEZADO */
        .neo-header {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            margin-bottom: 3rem;
            padding-bottom: 2rem;
            border-bottom: 1px solid var(--border-subtle);
        }

        .neo-avatar-wrapper {
            position: relative;
            width: 72px;
            height: 72px;
        }

        .neo-avatar-ring {
            position: absolute;
            inset: -4px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--accent), transparent 60%);
            opacity: 0.6;
            animation: spin 8s linear infinite;
        }

        .neo-avatar {
            position: absolute;
            inset: 0;
            background: #ffffff;
            border: 2px solid #ffffff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--accent);
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        }

        @keyframes spin { 100% { transform: rotate(360deg); } }

        .neo-user-info h1 {
            font-size: 1.6rem;
            font-weight: 700;
            margin: 0 0 0.25rem;
            letter-spacing: -0.02em;
            color: var(--text-main);
        }

        .neo-user-info p {
            margin: 0;
            color: var(--text-muted);
            font-size: 0.95rem;
        }

        /* CONTENEDOR DE ACCIONES (DERECHA) */
        .neo-header-actions {
            margin-left: auto;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        /* BOTÓN DE VOLVER FUTURISTA */
        .neo-back-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.85rem;
            font-weight: 500;
            color: var(--text-muted);
            background: rgba(255, 255, 255, 0.5);
            padding: 0.5rem 1rem;
            border-radius: 30px;
            border: 1px solid var(--border-subtle);
            text-decoration: none;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 2px 8px rgba(0,0,0,0.01);
        }

        .neo-back-btn:hover {
            color: var(--text-main);
            background: #ffffff;
            border-color: rgba(14, 165, 233, 0.3);
            transform: translateX(-3px);
            box-shadow: 0 4px 12px rgba(14, 165, 233, 0.08);
        }

        .neo-back-btn i {
            font-size: 1rem;
            transition: transform 0.25s ease;
        }

        .neo-status {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.85rem;
            font-weight: 500;
            color: #334155;
            background: #ffffff;
            padding: 0.5rem 1rem;
            border-radius: 30px;
            border: 1px solid var(--border-card);
            box-shadow: 0 2px 8px rgba(0,0,0,0.02);
        }

        .status-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #10b981;
            box-shadow: 0 0 6px rgba(16, 185, 129, 0.5);
        }

        /* GRID PRINCIPAL */
        .neo-layout {
            display: grid;
            grid-template-columns: 240px 1fr;
            gap: 2.5rem;
            align-items: start;
        }

        /* NAVEGACIÓN */
        .neo-nav {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .neo-tab {
            position: relative;
            display: flex;
            align-items: center;
            gap: 0.85rem;
            width: 100%;
            padding: 0.85rem 1rem;
            background: transparent;
            border: none;
            border-radius: 10px;
            color: var(--text-muted);
            font-size: 0.95rem;
            font-weight: 500;
            text-align: left;
            cursor: pointer;
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .neo-tab:hover {
            color: var(--text-main);
            background: rgba(255, 255, 255, 0.4);
        }

        .neo-tab.active {
            color: var(--text-main);
            background: #ffffff;
            font-weight: 600;
            box-shadow: 0 2px 10px rgba(0,0,0,0.02);
        }

        .neo-tab i { font-size: 1.1rem; opacity: 0.7; }
        .neo-tab.active i { opacity: 1; color: var(--accent); }
        .neo-tab.danger.active i { color: var(--danger); }

        /* Indicador lateral */
        .neo-indicator {
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%) scaleY(0);
            width: 4px;
            height: 60%;
            background: var(--accent);
            border-radius: 0 4px 4px 0;
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .neo-tab.active .neo-indicator { transform: translateY(-50%) scaleY(1); }
        .neo-tab.danger.active .neo-indicator { background: var(--danger); }

        /* TARJETAS */
        .neo-card {
            background: var(--bg-card);
            border: 1px solid var(--border-card);
            border-radius: 16px;
            padding: 2.5rem;
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.03);
        }

        .neo-card.danger-card {
            border-color: rgba(239, 68, 68, 0.2);
            background: linear-gradient(180deg, rgba(255,255,255,0.7) 0%, rgba(254, 242, 242, 0.7) 100%);
        }

        /* RESPONSIVE */
        @media (max-width: 768px) {
            .neo-layout { grid-template-columns: 1fr; gap: 2rem; }
            .neo-nav { flex-direction: row; overflow-x: auto; padding-bottom: 0.5rem; }
            .neo-tab { white-space: nowrap; width: auto; }
            .neo-indicator { bottom: 0; left: 50%; top: auto; width: 60%; height: 3px; transform: translateX(-50%) scaleX(0); border-radius: 4px 4px 0 0; }
            .neo-tab.active .neo-indicator { transform: translateX(-50%) scaleX(1); }
            .neo-header { flex-direction: column; text-align: center; }
            .neo-header-actions { margin: 1rem auto 0; flex-direction: column-reverse; gap: 0.5rem; }
            .neo-card { padding: 1.5rem; }
        }

        /* Clases de utilidad */
        .opacity-0 { opacity: 0; }
        .opacity-100 { opacity: 1; }
        .translate-y-4 { transform: translateY(1rem); }
        .translate-y-0 { transform: translateY(0); }
    </style>
</x-app-layout>