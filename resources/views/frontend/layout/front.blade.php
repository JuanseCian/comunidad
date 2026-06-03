<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comunidad | @yield('title')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Nunito:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --teal-50:  #e8f9f5;
            --teal-100: #c2eee3;
            --teal-300: #5dc9a8;
            --teal-400: #2db896;
            --teal-500: #17a385;
            --teal-600: #0e8a70;
            --teal-700: #086f59;

            --sky-50:   #e6f5fb;
            --sky-100:  #b3e0f5;
            --sky-300:  #4dbde8;
            --sky-400:  #1aaad8;
            --sky-500:  #0d92c2;
            --sky-600:  #0879a8;
            --sky-700:  #045f87;

            --mint-50:  #f0fdf9;
            --mint-100: #d0f4ec;

            --neutral-50:  #f8fafb;
            --neutral-100: #eef2f5;
            --neutral-200: #dde3ea;
            --neutral-400: #94a3b4;
            --neutral-600: #536070;
            --neutral-800: #1e293b;
            --neutral-900: #0f172a;

            --grad-main: linear-gradient(135deg, #0d92c2 0%, #17a385 100%);
            --grad-soft: linear-gradient(135deg, #e6f5fb 0%, #e8f9f5 100%);
            --grad-nav:  linear-gradient(90deg, #0879a8 0%, #0e8a70 100%);

            --shadow-sm: 0 1px 3px rgba(13,146,194,.08), 0 1px 2px rgba(0,0,0,.04);
            --shadow-md: 0 4px 16px rgba(13,146,194,.12), 0 2px 6px rgba(0,0,0,.05);
            --shadow-lg: 0 10px 32px rgba(13,146,194,.16), 0 4px 10px rgba(0,0,0,.06);

            --radius-sm: 8px;
            --radius-md: 12px;
            --radius-lg: 18px;
            --radius-xl: 24px;
        }

        *, *::before, *::after { box-sizing: border-box; }

        body {
            background: var(--neutral-50);
            font-family: 'Nunito', sans-serif;
            color: var(--neutral-800);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
        }

        /* ─────────────────────────────────────────
           TOPBAR
        ───────────────────────────────────────── */
        .topbar {
            background: var(--grad-nav);
            height: 58px;
            display: flex;
            align-items: stretch;
            position: sticky;
            top: 0;
            z-index: 1050;
            box-shadow: 0 2px 20px rgba(8,121,168,.28);
        }

        /* Brand */
        .nav-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 0 20px 0 14px;
            text-decoration: none;
            border-right: 1px solid rgba(255,255,255,.13);
            flex-shrink: 0;
        }

        .nav-brand-icon {
            width: 34px;
            height: 34px;
            background: rgba(255,255,255,.18);
            border-radius: 9px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 17px;
            color: white;
        }

        .nav-brand-text span:first-child {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 800;
            font-size: 14px;
            color: white;
            letter-spacing: .4px;
            display: block;
            line-height: 1.1;
        }

        .nav-brand-text span:last-child {
            font-size: 9.5px;
            color: rgba(255,255,255,.6);
            font-weight: 600;
            letter-spacing: 1.2px;
            text-transform: uppercase;
            display: block;
        }

        /* Nav links */
        .nav-links {
            display: flex;
            align-items: stretch;
            list-style: none;
            flex: 1;
            margin: 0;
            padding: 0 4px;
        }

        .nav-links > li {
            display: flex;
            align-items: stretch;
            position: relative;
        }

        .nav-links > li > a {
            display: flex;
            align-items: center;
            gap: 5px;
            padding: 0 14px;
            color: rgba(255,255,255,.8);
            font-weight: 600;
            font-size: 13px;
            text-decoration: none;
            transition: background .18s, color .18s;
            white-space: nowrap;
            border-bottom: 2px solid transparent;
        }

        .nav-links > li > a:hover,
        .nav-links > li > a.active {
            color: white;
            background: rgba(255,255,255,.1);
        }

        .nav-links > li > a.active {
            border-bottom-color: rgba(255,255,255,.7);
        }

        .nav-links > li > a i { font-size: 14px; }

        /* Dropdown */
        .nav-dropdown { position: relative; }

        .nav-dropdown:hover .dd-menu { display: block; }

        .dd-toggle {
            display: flex;
            align-items: center;
            gap: 5px;
            padding: 0 14px;
            color: rgba(255,255,255,.8);
            font-weight: 600;
            font-size: 13px;
            cursor: pointer;
            border-bottom: 2px solid transparent;
            white-space: nowrap;
            transition: background .18s;
            height: 100%;
        }

        .nav-dropdown:hover .dd-toggle {
            color: white;
            background: rgba(255,255,255,.1);
        }

        .dd-menu {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            min-width: 190px;
            background: white;
            border-radius: 0 0 12px 12px;
            box-shadow: var(--shadow-lg);
            border: 1px solid var(--neutral-200);
            border-top: 3px solid var(--teal-400);
            padding: 5px;
            z-index: 200;
        }

        .dd-menu a {
            display: flex;
            align-items: center;
            gap: 7px;
            padding: 8px 12px;
            border-radius: 7px;
            color: var(--neutral-800);
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            transition: background .14s;
        }

        .dd-menu a:hover { background: var(--mint-100); color: var(--teal-600); }
        .dd-menu a i { color: var(--teal-500); font-size: 13.5px; }

        /* Right zone */
        .nav-right {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 0 14px;
            border-left: 1px solid rgba(255,255,255,.13);
        }

        /* Notificaciones */
        .btn-notif {
            width: 34px;
            height: 34px;
            border-radius: 9px;
            background: rgba(255,255,255,.12);
            border: 1px solid rgba(255,255,255,.2);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 15px;
            cursor: pointer;
            transition: background .18s;
            position: relative;
            flex-shrink: 0;
        }

        .btn-notif:hover { background: rgba(255,255,255,.22); }

        .notif-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: #f87171;
            position: absolute;
            top: 6px;
            right: 6px;
            border: 1.5px solid transparent;
        }

        /* Badge admin */
        .badge-admin {
            background: rgba(255,255,255,.15);
            border: 1px solid rgba(255,255,255,.28);
            color: white;
            border-radius: 7px;
            padding: 5px 11px;
            font-size: 11.5px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 5px;
            text-decoration: none;
            transition: background .18s;
            white-space: nowrap;
        }

        .badge-admin:hover { background: rgba(255,255,255,.26); color: white; }

                /* Estadísticas */
        .btn-estadisticas{
            background: linear-gradient(
                135deg,
                #ffffff 0%,
                #f0fdf9 100%
            );

            color: var(--teal-700);

            border: 1px solid rgba(255,255,255,.35);

            border-radius: 10px;

            padding: 7px 14px;

            font-size: 12.5px;

            font-weight: 800;

            display: flex;

            align-items: center;

            gap: 7px;

            text-decoration: none;

            transition:
                transform .18s,
                box-shadow .18s,
                background .18s;

            box-shadow:
                0 4px 12px rgba(0,0,0,.12),
                0 0 0 1px rgba(255,255,255,.25);

            white-space: nowrap;

            position: relative;

            overflow: hidden;
        }

        .btn-estadisticas::before{
            content:'';

            position:absolute;

            inset:0;

            background: linear-gradient(
                120deg,
                transparent,
                rgba(255,255,255,.35),
                transparent
            );

            transform: translateX(-100%);

            transition: transform .6s;
        }

        .btn-estadisticas:hover::before{
            transform: translateX(100%);
        }

        .btn-estadisticas:hover{
            transform: translateY(-2px);

            box-shadow:
                0 8px 22px rgba(0,0,0,.18),
                0 0 20px rgba(23,163,133,.22);

            color: var(--teal-700);
        }

        .btn-estadisticas i{
            font-size: 14px;
        }

        /* Botón login (visitantes) */
        .btn-nav-login {
            background: white;
            color: var(--teal-600);
            border: none;
            border-radius: 8px;
            padding: 7px 18px;
            font-size: 13px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 6px;
            text-decoration: none;
            transition: transform .15s, box-shadow .15s;
            box-shadow: 0 2px 8px rgba(0,0,0,.15);
        }

        .btn-nav-login:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 14px rgba(0,0,0,.2);
            color: var(--teal-700);
        }

        /* Avatar / botón de perfil */
        .btn-perfil {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: rgba(255,255,255,.9);
            border: 2px solid rgba(255,255,255,.5);
            color: var(--teal-600);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 800;
            font-size: 12px;
            cursor: pointer;
            transition: transform .18s, box-shadow .18s;
            flex-shrink: 0;
        }

        .btn-perfil:hover {
            transform: scale(1.07);
            box-shadow: 0 0 0 3px rgba(255,255,255,.35);
        }

        /* Mobile toggler */
        .nav-toggler {
            display: none;
            background: rgba(255,255,255,.12);
            border: 1px solid rgba(255,255,255,.2);
            border-radius: 8px;
            color: white;
            padding: 6px 10px;
            font-size: 18px;
            cursor: pointer;
            margin: auto 12px auto 8px;
            align-items: center;
        }

        /* ─────────────────────────────────────────
           DRAWER OVERLAY
        ───────────────────────────────────────── */
        .drawer-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0);
            z-index: 1060;
            pointer-events: none;
            transition: background .3s;
        }

        .drawer-overlay.open {
            background: rgba(0,0,0,.38);
            pointer-events: all;
        }

        /* ─────────────────────────────────────────
           DRAWER PANEL
        ───────────────────────────────────────── */
        .drawer {
            position: fixed;
            top: 0;
            right: 0;
            bottom: 0;
            width: 300px;
            background: white;
            z-index: 1070;
            transform: translateX(100%);
            transition: transform .32s cubic-bezier(.4,0,.2,1);
            display: flex;
            flex-direction: column;
            overflow: hidden;
            box-shadow: -4px 0 28px rgba(0,0,0,.14);
        }

        .drawer.open { transform: translateX(0); }

        /* Drawer: cabecera */
        .drawer-head {
            padding: 20px 20px 18px;
            background: var(--grad-nav);
            position: relative;
            flex-shrink: 0;
        }

        .drawer-close {
            position: absolute;
            top: 14px;
            right: 14px;
            width: 28px;
            height: 28px;
            border-radius: 7px;
            background: rgba(255,255,255,.18);
            border: none;
            color: white;
            font-size: 15px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background .18s;
        }

        .drawer-close:hover { background: rgba(255,255,255,.3); }

        .drawer-avatar-big {
            width: 58px;
            height: 58px;
            border-radius: 50%;
            background: rgba(255,255,255,.9);
            border: 3px solid rgba(255,255,255,.45);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 800;
            font-size: 20px;
            color: var(--teal-600);
            margin-bottom: 10px;
        }

        .drawer-name {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 700;
            font-size: 15px;
            color: white;
        }

        .drawer-role {
            font-size: 11.5px;
            color: rgba(255,255,255,.62);
            margin-top: 2px;
        }

        /* Drawer: cuerpo */
        .drawer-body {
            flex: 1;
            overflow-y: auto;
            padding: 10px;
        }

        .drawer-section-label {
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 1.4px;
            text-transform: uppercase;
            color: var(--neutral-400);
            padding: 10px 8px 4px;
        }

        .drawer-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 10px;
            border-radius: 9px;
            color: var(--neutral-800);
            font-size: 13.5px;
            font-weight: 600;
            text-decoration: none;
            transition: background .14s;
            border: none;
            background: none;
            width: 100%;
            text-align: left;
            cursor: pointer;
        }

        .drawer-item:hover { background: var(--neutral-100); color: var(--neutral-800); }

        .drawer-item-icon {
            width: 30px;
            height: 30px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            flex-shrink: 0;
        }

        .icon-teal   { background: var(--teal-50);  color: var(--teal-500);  }
        .icon-sky    { background: var(--sky-50);   color: var(--sky-500);   }
        .icon-amber  { background: #fef3e2;          color: #d97706;          }
        .icon-purple { background: #f3f0ff;          color: #7c3aed;          }
        .icon-red    { background: #fef2f2;          color: #ef4444;          }

        .drawer-item-badge {
            margin-left: auto;
            background: var(--teal-50);
            color: var(--teal-600);
            font-size: 10.5px;
            font-weight: 700;
            border-radius: 20px;
            padding: 2px 8px;
        }

        .drawer-divider {
            height: 1px;
            background: var(--neutral-100);
            margin: 6px 0;
        }

        /* Drawer: pie */
        .drawer-foot {
            padding: 12px 14px;
            border-top: 1px solid var(--neutral-100);
            flex-shrink: 0;
        }

        .btn-logout-drawer {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            width: 100%;
            padding: 10px;
            border-radius: 10px;
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #ef4444;
            font-size: 13.5px;
            font-weight: 700;
            cursor: pointer;
            transition: background .15s;
        }

        .btn-logout-drawer:hover { background: #fee2e2; }

        /* ─────────────────────────────────────────
           MAIN / FOOTER
        ───────────────────────────────────────── */
        main { flex: 1; }

        footer {
            background: white;
            border-top: 1px solid var(--neutral-200);
            padding: 20px 0;
        }

        footer .footer-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 8px;
        }

        footer .footer-brand {
            display: flex;
            align-items: center;
            gap: 8px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 700;
            font-size: 14px;
            background: var(--grad-main);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        footer p {
            color: var(--neutral-400);
            font-size: 12.5px;
            margin: 0;
        }

        /* ─────────────────────────────────────────
           RESPONSIVE
        ───────────────────────────────────────── */
        @media (max-width: 991px) {
            .nav-links { display: none; }
            .nav-toggler { display: flex; }
            .nav-right { border-left: none; }

            /* Mobile: nav abierto */
            .topbar.nav-mobile-open { position: relative; flex-wrap: wrap; height: auto; }

            .topbar.nav-mobile-open .nav-links {
                display: flex;
                flex-direction: column;
                width: 100%;
                background: var(--sky-700);
                padding: 8px;
                order: 10;
            }

            .topbar.nav-mobile-open .nav-links > li > a,
            .topbar.nav-mobile-open .dd-toggle {
                padding: 11px 14px;
                border-radius: 8px;
                border-bottom: none;
            }

            .dd-menu {
                position: static;
                box-shadow: none;
                border: none;
                border-radius: var(--radius-sm);
                background: rgba(255,255,255,.08);
                margin: 4px 0;
                display: block;
            }

            .dd-menu a { color: rgba(255,255,255,.82); }
            .dd-menu a:hover { background: rgba(255,255,255,.1); color: white; }
            .dd-menu a i { color: rgba(255,255,255,.7); }

            .drawer { width: 100%; max-width: 320px; }
        }
    </style>
</head>
<body>

{{-- ─── OVERLAY DEL DRAWER ─── --}}
<div class="drawer-overlay" id="drawerOverlay"></div>

{{-- ─── DRAWER DE PERFIL ─── --}}
<aside class="drawer" id="sideDrawer" role="dialog" aria-modal="true" aria-label="Panel de perfil">

    @auth
    {{-- Cabecera --}}
    <div class="drawer-head">
        <button class="drawer-close" id="drawerClose" aria-label="Cerrar panel">
            <i class="bi bi-x-lg"></i>
        </button>
        <div class="drawer-avatar-big">
            {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
        </div>
        <div class="drawer-name">{{ auth()->user()->name }}</div>
        <div class="drawer-role">
            @if(auth()->user()->rol_id == 3)
                Administrador
            @else
                Usuario
            @endif
        </div>
    </div>

    {{-- Cuerpo --}}
    <div class="drawer-body">

        {{-- Mi cuenta --}}
        <div class="drawer-section-label">Mi cuenta</div>

        <a class="drawer-item" href="{{ route('profile.edit') ?? '#' }}">
            <span class="drawer-item-icon icon-teal"><i class="bi bi-person-circle"></i></span>
            Gestionar perfil
        </a>

        <div class="drawer-divider"></div>

        {{-- Navegación principal --}}
        <div class="drawer-section-label">Navegación</div>

        <a class="drawer-item" href="{{ route('home') }}">
            <span class="drawer-item-icon icon-teal"><i class="bi bi-house-door"></i></span>
            Inicio
        </a>

        <a class="drawer-item" href="#">
            <span class="drawer-item-icon icon-sky"><i class="bi bi-person-badge"></i></span>
            Recepción
        </a>

        <div class="drawer-divider"></div>

        {{-- Programas --}}
        
        <div class="drawer-section-label">
            Programas
        </div>

        @foreach($programas as $p)

            <a class="drawer-item"
            href="{{ route('frontend.programas.show', $p->id) }}">

                <span class="drawer-item-icon icon-teal">

                    <i class="bi bi-folder-fill"></i>

                </span>

                {{ $p->nombre }}

            </a>

        @endforeach

        @if(auth()->user()->rol_id == 3)
            <a class="drawer-item" href="{{ route('admin.home') }}">
                <span class="drawer-item-icon icon-purple"><i class="bi bi-gear-fill"></i></span>
                Administración
            </a>
        @endif

    </div>

    {{-- Pie: cerrar sesión --}}
    <div class="drawer-foot">
        <form action="{{ route('logout') }}" method="POST" style="margin:0;">
            @csrf
            <button type="submit" class="btn-logout-drawer">
                <i class="bi bi-box-arrow-right"></i> Cerrar sesión
            </button>
        </form>
    </div>
    @endauth

</aside>

{{-- ─── TOPBAR ─── --}}
<nav class="topbar" id="mainNav">

    {{-- Brand --}}
    <a class="nav-brand" href="{{ route('home') }}">
        <div class="nav-brand-icon">
            <i class="bi bi-heart-pulse-fill"></i>
        </div>
        <div class="nav-brand-text">
            <span>Comunidad</span>
            <span>Gestión Social</span>
        </div>
    </a>

    {{-- Nav links --}}
   <ul class="nav-links ms-1" id="navLinks">
    <li>
        <a href="{{ route('home') }}" @class(['active' => request()->routeIs('home')])>
            <i class="bi bi-house-door"></i> Inicio
        </a>
    </li>
    <li>
        <a href="#" style="display: none;" @class(['active' => request()->routeIs('recepcion.*')])>
            <i class="bi bi-person-badge"></i> Recepción
        </a>
    </li>
    <li class="nav-dropdown" style="display: none;">
        <span class="dd-toggle">
            <i class="bi bi-collection"></i> Programas
            <i class="bi bi-chevron-down" style="font-size:9px;margin-left:2px;"></i>
        </span>
        <div class="dd-menu">
            <a href="#"><i class="bi bi-mortarboard"></i> Envión</a>
            <a href="#"><i class="bi bi-egg-fried"></i> UDI / Más Vida</a>
            <a href="#"><i class="bi bi-heart-pulse"></i> Bajo Peso</a>
            <a href="#"><i class="bi bi-building-up"></i> Multiespacio</a>
        </div>
    </li>
    <li>
        <a href="#" style="display: none;"@class(['active' => request()->routeIs('mercaderia.*')])>
            <i class="bi bi-box-seam"></i> Mercadería
        </a>
    </li>
 
    {{-- ★ NUEVO ÍTEM: Asistencia ★ --}}
    <li>
        <a href="{{ route('asistencia.index') }}"
           @class(['active' => request()->routeIs('asistencia.*')])>
            <i class="bi bi-calendar-check"></i> Asistencia
        </a>
    </li>
</ul>

    {{-- Right zone --}}
    <div class="nav-right">
        @auth   
            {{-- Estadísticas --}}
            <a href="{{ route('estadisticas.dashboard') }}"
               class="btn-estadisticas">

                <i class="bi bi-graph-up-arrow"></i>

                Estadísticas

            </a>

            {{-- Admin (solo rol 3) --}}
            @if(auth()->user()->rol_id == 3)
                <a href="{{ route('admin.home') }}" class="badge-admin">
                    <i class="bi bi-gear-fill"></i> Admin
                </a>
            @endif

            {{-- Avatar → abre drawer --}}
            <button class="btn-perfil" id="openDrawer" aria-label="Abrir panel de perfil" title="{{ auth()->user()->name }}">
                {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
            </button>
        @else
            <a href="{{ route('login') }}" class="btn-nav-login">
                <i class="bi bi-box-arrow-in-right"></i> Ingresar
            </a>
        @endauth
    </div>

    {{-- Mobile toggler --}}
    <button class="nav-toggler" id="navToggler" aria-label="Menú">
        <i class="bi bi-list"></i>
    </button>

</nav>

{{-- ─── CONTENIDO ─── --}}
<main>
    @yield('content')
</main>

{{-- ─── FOOTER ─── --}}
<footer>
    <div class="container">
        <div class="footer-inner">
            <div class="footer-brand">
                <i class="bi bi-heart-pulse-fill"></i>
                Secretaría de Desarrollo Humano · Comunidad
            </div>
            <p>&copy; {{ date('Y') }} &nbsp;·&nbsp; Innovación para la Comunidad</p>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    /* ─── DRAWER ─── */
    const drawer  = document.getElementById('sideDrawer');
    const overlay = document.getElementById('drawerOverlay');
    const openBtn = document.getElementById('openDrawer');
    const closeBtn = document.getElementById('drawerClose');

    function openDrawer() {
        drawer.classList.add('open');
        overlay.classList.add('open');
        document.body.style.overflow = 'hidden';
        if (closeBtn) closeBtn.focus();
    }

    function closeDrawer() {
        drawer.classList.remove('open');
        overlay.classList.remove('open');
        document.body.style.overflow = '';
        if (openBtn) openBtn.focus();
    }

    if (openBtn)  openBtn.addEventListener('click', openDrawer);
    if (closeBtn) closeBtn.addEventListener('click', closeDrawer);
    overlay.addEventListener('click', closeDrawer);

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && drawer.classList.contains('open')) closeDrawer();
    });

    /* ─── MOBILE NAV TOGGLER ─── */
    const navToggler = document.getElementById('navToggler');
    const mainNav    = document.getElementById('mainNav');

    if (navToggler) {
        navToggler.addEventListener('click', function () {
            mainNav.classList.toggle('nav-mobile-open');
        });
    }
</script>

@stack('scripts')

</body>
</html>