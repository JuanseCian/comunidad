<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" href="{{ asset('assets/img/SN.png') }}" type="image/png">
    <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <title>Comunidad - Acceso</title>

    <style>
        *, *::before, *::after { box-sizing: border-box; }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #1a3a6e 0%, #2563b8 55%, #06b6d4 100%);
            background-attachment: fixed;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            margin: 0;
        }

        /* ── FLIP CARD ─────────────────────────────────────── */
        .scene {
            perspective: 1200px;
        }
        .flip-card-inner {
            transition: transform 0.75s cubic-bezier(0.4, 0.2, 0.2, 1);
            transform-style: preserve-3d;
            display: grid;
        }
        .is-flipped { transform: rotateY(180deg); }

        .flip-card-front,
        .flip-card-back {
            grid-area: 1 / 1 / 2 / 2;
            backface-visibility: hidden;
        }
        .flip-card-back { transform: rotateY(180deg); }

        /* ── CARD SHELL ─────────────────────────────────────── */
        .auth-card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 24px 60px rgba(0, 0, 30, 0.25);
            background: #fff;
        }

        /* ── LEFT DECORATIVE PANEL ──────────────────────────── */
        .panel-img {
            background:
                linear-gradient(160deg, rgba(15, 35, 80, 0.88), rgba(6, 182, 212, 0.72)),
                url('{{ asset("assets/img/fondo-03.png") }}') center / cover no-repeat;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: #fff;
            padding: 50px 32px;
            gap: 14px;
            text-align: center;
            border-radius: 20px 0 0 20px;
        }
        .panel-img .brand-icon {
            width: 64px;
            height: 64px;
            background: rgba(255, 255, 255, 0.14);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 4px;
        }
        .panel-img h2 {
            font-size: 26px;
            font-weight: 700;
            letter-spacing: -0.4px;
            margin: 0;
        }
        .panel-img p {
            font-size: 14px;
            opacity: 0.78;
            line-height: 1.6;
            margin: 0;
        }
        .dot-row { display: flex; gap: 8px; margin-top: 8px; }
        .dot-row span {
            width: 8px; height: 8px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.35);
            display: inline-block;
        }
        .dot-row span.active { background: #fff; }

        /* ── FORM PANEL ─────────────────────────────────────── */
        .panel-form {
            padding: 44px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            border-radius: 0 20px 20px 0;
        }

        .form-title {
            font-size: 22px;
            font-weight: 700;
            color: #0f1b35;
            margin-bottom: 4px;
        }
        .form-sub {
            font-size: 13px;
            color: #6b7a99;
            margin-bottom: 26px;
        }

        /* ── INPUTS ─────────────────────────────────────────── */
        .field { margin-bottom: 16px; position: relative; }
        .field label {
            display: block;
            font-size: 11.5px;
            font-weight: 600;
            color: #4a5568;
            text-transform: uppercase;
            letter-spacing: 0.4px;
            margin-bottom: 6px;
        }

        .input-wrap { position: relative; display: flex; align-items: center; }
        .input-wrap .ico-left {
            position: absolute;
            left: 12px;
            color: #9baabf;
            display: flex;
            pointer-events: none;
        }
        .input-wrap input {
            width: 100%;
            padding: 10px 40px 10px 38px;
            border: 1.5px solid #dce3f0;
            border-radius: 10px;
            font-size: 14px;
            font-family: 'Poppins', sans-serif;
            color: #1a2540;
            background: #f8faff;
            outline: none;
            transition: border-color 0.2s, background 0.2s, box-shadow 0.2s;
        }
        .input-wrap input:focus {
            border-color: #2563b8;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(37, 99, 184, 0.12);
        }
        .input-wrap input.is-error { border-color: #ef4444; }

        .eye-btn {
            position: absolute;
            right: 10px;
            background: none;
            border: none;
            cursor: pointer;
            color: #9baabf;
            display: flex;
            align-items: center;
            padding: 4px;
            border-radius: 6px;
            transition: color 0.2s;
        }
        .eye-btn:hover { color: #2563b8; }

        /* ── BOTÓN PRINCIPAL ────────────────────────────────── */
        .btn-main {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #1d4ed8, #0ea5e9);
            color: #fff;
            border: none;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 600;
            font-family: 'Poppins', sans-serif;
            cursor: pointer;
            letter-spacing: 0.2px;
            margin-top: 6px;
            transition: opacity 0.2s, transform 0.15s;
        }
        .btn-main:hover { opacity: 0.9; transform: translateY(-1px); }
        .btn-main:active { transform: translateY(0); }

        /* ── ENLACE CAMBIO DE MODO ──────────────────────────── */
        .switch-link {
            text-align: center;
            font-size: 13px;
            color: #6b7a99;
            margin-top: 20px;
        }
        .switch-link a {
            color: #2563b8;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
        }
        .switch-link a:hover { text-decoration: underline; }

        .forgot-link{
            font-size: 12.5px;
            color: #2563b8;
            text-decoration: none;
            font-weight: 500;
            transition: all .2s ease;
        }

        .forgot-link:hover{
            color: #0ea5e9;
            text-decoration: underline;
        }

        /* ── ALERTAS ────────────────────────────────────────── */
        .alert-danger-custom {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #b91c1c;
            font-size: 13px;
            border-radius: 10px;
            padding: 10px 14px;
            margin-bottom: 18px;
        }
        .alert-success-custom {
            background: #f0fdf4;
            border: 1px solid #86efac;
            color: #15803d;
            font-size: 13px;
            border-radius: 10px;
            padding: 10px 14px;
            margin-bottom: 18px;
        }

        /* ── REGLAS DE CONTRASEÑA (TOOLTIP FLOTANTE) ────────── */
        .pwd-rules {
            position: absolute;
            top: 50%;
            left: calc(100% + 15px);
            transform: translateY(-50%);
            background: #fff;
            border: 1px solid #dce3f0;
            box-shadow: 0 10px 30px rgba(0, 0, 30, 0.08);
            border-radius: 12px;
            padding: 14px;
            width: 250px;
            display: flex;
            flex-direction: column;
            gap: 6px;
            z-index: 100;
            opacity: 0;
            visibility: hidden;
            margin-left: -10px;
            transition: opacity 0.3s ease, visibility 0.3s ease, margin-left 0.3s ease;
        }

        /* Flecha del tooltip */
        .pwd-rules::before {
            content: '';
            position: absolute;
            top: 50%;
            left: -6px;
            transform: translateY(-50%) rotate(45deg);
            width: 10px;
            height: 10px;
            background: #fff;
            border-left: 1px solid #dce3f0;
            border-bottom: 1px solid #dce3f0;
        }

        .pwd-rules.show {
            opacity: 1;
            visibility: visible;
            margin-left: 0;
        }

        .rule {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 11.5px;
            color: #9baabf;
            transition: color 0.25s;
        }
        .rule.ok { color: #16a34a; }
        .rule-dot {
            width: 16px; height: 16px;
            border-radius: 50%;
            border: 1.5px solid #d0d9ee;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 9px;
            transition: background 0.25s, border-color 0.25s;
        }
        .rule.ok .rule-dot {
            background: #16a34a;
            border-color: #16a34a;
            color: #fff;
        }

        /* ── COINCIDENCIA ───────────────────────────────────── */
        .match-msg {
            font-size: 12px;
            margin-top: 6px;
            display: none;
            align-items: center;
            gap: 5px;
        }
        .match-msg.ok { color: #16a34a; display: flex; }
        .match-msg.no { color: #dc2626; display: flex; }

        /* ── LAYOUT ─────────────────────────────────────────── */
        section {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 16px;
        }

        /* ── FOOTER ─────────────────────────────────────────── */
        footer { flex-shrink: 0; }
        footer a { color: #93c5fd; text-decoration: none; }
        footer a:hover { text-decoration: underline; }

        /* ── ANIMACIÓN DE ACCESO (WELCOME OVERLAY) ──────────── */
        .welcome-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #0f1b35 0%, #1a3a6e 100%);
            z-index: 9999;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.4s ease, visibility 0.4s ease;
        }

        .welcome-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .welcome-wrapper {
            text-align: center;
            transform: scale(0.9);
            transition: transform 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .welcome-overlay.active .welcome-wrapper {
            transform: scale(1);
        }

        .welcome-logo {
            width: 110px;
            height: auto;
            margin-bottom: 24px;
            animation: floatLogo 2.5s ease-in-out infinite, pulseGlow 2.5s ease-in-out infinite;
            filter: drop-shadow(0 0 15px rgba(6, 182, 212, 0.4));
        }

        .welcome-spinner {
            width: 45px;
            height: 45px;
            border: 3.5px solid rgba(255, 255, 255, 0.1);
            border-top-color: #0ea5e9;
            border-radius: 50%;
            margin: 0 auto;
            animation: spin 0.8s linear infinite;
        }

        @keyframes floatLogo {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        @keyframes pulseGlow {
            0%, 100% { filter: drop-shadow(0 0 12px rgba(6, 182, 212, 0.3)); }
            50% { filter: drop-shadow(0 0 25px rgba(14, 165, 233, 0.7)); }
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* ── RESPONSIVE ─────────────────────────────────────── */
        @media (max-width: 991px) {

        section{
            padding:20px 12px;
        }

        .scene{
            width:100%;
        }

        #cardInner{
            max-width:100% !important;
        }

        .auth-card{
            border-radius:18px;
            overflow:hidden;
        }

        .panel-form{
            padding:32px 24px;
            border-radius:18px;
        }

        .pwd-rules{
            position:relative;
            top:auto;
            left:auto;
            transform:none;
            width:100%;
            margin-top:10px;
            margin-left:0;
            box-shadow:none;
        }

        .pwd-rules::before{
            display:none;
        }
    }

        @media (max-width: 767px) {

        body{
            overflow-x:hidden;
        }

        section{
            padding:12px;
            align-items:flex-start;
        }

        .container{
            padding:0;
        }

        .auth-card{
            border-radius:16px;
        }

        .panel-img{
            display:flex !important;
            border-radius:16px 16px 0 0;
            min-height:180px;
            padding:30px 20px;
        }

        .panel-img h2{
            font-size:22px;
        }

        .panel-img p{
            font-size:13px;
        }

        .panel-form{
            padding:24px 18px;
            border-radius:0 0 16px 16px;
        }

        .form-title{
            font-size:20px;
        }

        .form-sub{
            font-size:12px;
            margin-bottom:20px;
        }

        .input-wrap input{
            font-size:16px;
            min-height:48px;
        }

        .btn-main{
            min-height:50px;
            font-size:15px;
        }

        /* Nombre y apellido uno debajo del otro */
        .row.g-2 .col-6{
            width:100%;
            flex:0 0 100%;
            max-width:100%;
        }

        /* Password y confirmar uno debajo del otro */
        .row.g-2[style*="margin-top"] .col-6{
            width:100%;
            flex:0 0 100%;
            max-width:100%;
            margin-bottom:12px;
        }

        .match-msg{
            margin-top:8px;
        }

        .switch-link{
            font-size:12px;
        }

        footer{
            text-align:center;
        }

        footer img{
            width:110px !important;
        }

        footer p{
            font-size:12px !important;
        }
    }

    @media (max-width: 420px){

        .panel-img{
            min-height:150px;
            padding:20px 15px;
        }

        .panel-img .brand-icon{
            width:50px;
            height:50px;
        }

        .panel-img h2{
            font-size:18px;
        }

        .form-title{
            font-size:18px;
        }

        .panel-form{
            padding:20px 15px;
        }

        .input-wrap input{
            padding-left:36px;
            padding-right:36px;
        }

        .alert-danger-custom,
        .alert-success-custom{
            font-size:12px;
        }
    }
    </style>
</head>

<body>

<div class="welcome-overlay" id="welcomeOverlay">
    <div class="welcome-wrapper">
        <img src="{{ asset('assets/img/SN.png') }}" alt="Logo San Nicolás" class="welcome-logo">
        <div class="welcome-spinner"></div>
    </div>
</div>

@php
    $flip = request()->routeIs('register')
        || $errors->has('username')
        || $errors->has('nombre')
        || $errors->has('apellido');
@endphp

<section>
    <div class="container scene">
        <div class="flip-card-inner {{ $flip ? 'is-flipped' : '' }}" id="cardInner" style="max-width: 900px; margin: 0 auto;">

            <div class="flip-card-front">
                <div class="auth-card">
                    <div class="row g-0">
                        <div class="col-md-5 panel-img">
                            <div class="brand-icon">
                                <svg width="32" height="32" fill="none" viewBox="0 0 24 24" stroke="white" stroke-width="1.8">
                                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                                    <circle cx="9" cy="7" r="4"/>
                                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                                    <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                                </svg>
                            </div>
                            <h2>Bienvenido</h2>
                            <p>Sistema de gestión social comunitaria</p>
                            <div class="dot-row">
                                <span class="active"></span><span></span><span></span>
                            </div>
                        </div>

                        <div class="col-md-7 panel-form bg-white">
                            @if(session('success'))
                                <div class="alert-success-custom">
                                    <i class="fas fa-check-circle me-1"></i>{{ session('success') }}
                                </div>
                            @endif

                            @if ($errors->has('login') || $errors->has('password'))
                                <div class="alert-danger-custom">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $errors->first() }}
                                </div>
                            @endif

                            <div class="form-title">Iniciar Sesión</div>
                            <div class="form-sub">Ingresá tus credenciales para continuar</div>

                            <form method="POST" action="{{ route('login') }}" id="loginForm">
                                @csrf

                                <div class="field">
                                    <label>Usuario o Email</label>
                                    <div class="input-wrap">
                                        <span class="ico-left">
                                            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                                <circle cx="12" cy="7" r="4"/>
                                            </svg>
                                        </span>
                                        <input type="text" name="login" value="{{ old('login') }}" placeholder="usuario@ejemplo.com" required>
                                    </div>
                                </div>

                                <div class="field">
                                    <label>Contraseña</label>
                                    <div class="input-wrap">
                                        <span class="ico-left">
                                            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <rect x="3" y="11" width="18" height="11" rx="2"/>
                                                <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                                            </svg>
                                        </span>
                                        <input type="password" name="password" id="login_password" placeholder="••••••••" required>
                                        <button class="eye-btn" type="button" data-target="login_password">
                                            <svg class="eye-icon" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                                <circle cx="12" cy="12" r="3"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end mb-3">
                                    <a href="{{ route('password.request') }}" class="forgot-link">
                                        ¿Olvidaste tu contraseña?
                                    </a>
                                </div>

                                <button class="btn-main" type="submit">Ingresar</button>
                            </form>

                            <div class="switch-link">
                                ¿No tenés cuenta?
                                <a href="javascript:void(0)" onclick="flip(true)">Registrate</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flip-card-back">
                <div class="auth-card">
                    <div class="row g-0">
                        <div class="col-md-5 panel-img">
                            <div class="brand-icon">
                                <svg width="32" height="32" fill="none" viewBox="0 0 24 24" stroke="white" stroke-width="1.8">
                                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                                    <circle cx="9" cy="7" r="4"/>
                                    <line x1="19" y1="8" x2="19" y2="14"/>
                                    <line x1="22" y1="11" x2="16" y2="11"/>
                                </svg>
                            </div>
                            <h2>Unite al sistema</h2>
                            <p>Creá tu cuenta y esperá la aprobación del administrador</p>
                            <div class="dot-row">
                                <span></span><span class="active"></span><span></span>
                            </div>
                        </div>

                        <div class="col-md-7 panel-form bg-white">
                            @if ($errors->has('username') || $errors->has('email') || $errors->has('nombre') || $errors->has('apellido') || $errors->has('password'))
                                <div class="alert-danger-custom">
                                    <ul class="mb-0 ps-3">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="form-title">Crear cuenta</div>
                            <div class="form-sub">Completá el formulario para registrarte</div>

                            <form method="POST" action="{{ route('register') }}">
                                @csrf

                                <div class="field">
                                    <label>Usuario</label>
                                    <div class="input-wrap">
                                        <span class="ico-left">
                                            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                                <circle cx="12" cy="7" r="4"/>
                                            </svg>
                                        </span>
                                        <input type="text" name="username" value="{{ old('username') }}" placeholder="mi_usuario">
                                    </div>
                                </div>

                                <div class="field">
                                    <label>Correo Electrónico</label>
                                    <div class="input-wrap">
                                        <span class="ico-left">
                                            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                                                <polyline points="22,6 12,13 2,6"/>
                                            </svg>
                                        </span>
                                        <input type="email" name="email" value="{{ old('email') }}" placeholder="correo@ejemplo.com">
                                    </div>
                                </div>

                                <div class="row g-2 mb-0">
                                    <div class="col-6">
                                        <div class="field mb-0">
                                            <label>Nombre</label>
                                            <div class="input-wrap">
                                                <span class="ico-left">
                                                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                                        <circle cx="12" cy="7" r="4"/>
                                                    </svg>
                                                </span>
                                                <input type="text" name="nombre" value="{{ old('nombre') }}" placeholder="Juan">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="field mb-0">
                                            <label>Apellido</label>
                                            <div class="input-wrap">
                                                <span class="ico-left">
                                                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                                        <circle cx="12" cy="7" r="4"/>
                                                    </svg>
                                                </span>
                                                <input type="text" name="apellido" value="{{ old('apellido') }}" placeholder="Pérez">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row g-2 mb-0" style="margin-top: 16px;">
                                    <div class="col-6">
                                        <div class="field mb-0">
                                            <label>Contraseña</label>
                                            <div class="input-wrap">
                                                <span class="ico-left">
                                                    <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <rect x="3" y="11" width="18" height="11" rx="2"/>
                                                        <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                                                    </svg>
                                                </span>
                                                <input type="password" name="password" id="reg_password" 
                                                    placeholder="••••••••" oninput="checkRules(); checkMatch()">
                                                <button class="eye-btn" type="button" data-target="reg_password">
                                                    <svg class="eye-icon" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                                        <circle cx="12" cy="12" r="3"/>
                                                    </svg>
                                                </button>

                                                <div class="pwd-rules" id="pwd-rules-box">
                                                    <div class="rule" id="r-len"><div class="rule-dot">✓</div> Mínimo 8 carac.</div>
                                                    <div class="rule" id="r-num"><div class="rule-dot">✓</div> Al menos un número</div>
                                                    <div class="rule" id="r-low"><div class="rule-dot">✓</div> Una minúscula</div>
                                                    <div class="rule" id="r-spe"><div class="rule-dot">✓</div> Carácter especial</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="field mb-0">
                                            <label>Confirmar</label>
                                            <div class="input-wrap">
                                                <span class="ico-left">
                                                    <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <rect x="3" y="11" width="18" height="11" rx="2"/>
                                                        <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                                                    </svg>
                                                </span>
                                                <input type="password" name="password_confirmation" id="reg_password_confirmation" 
                                                    placeholder="••••••••" oninput="checkMatch()">
                                                <button class="eye-btn" type="button" data-target="reg_password_confirmation">
                                                    <svg class="eye-icon" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                                        <circle cx="12" cy="12" r="3"/>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="match-msg" id="match-msg" style="margin-bottom: 16px;"></div>

                                <button class="btn-main" type="submit">Registrarse</button>
                            </form>

                            <div class="switch-link">
                                ¿Ya tenés cuenta?
                                <a href="javascript:void(0)" onclick="flip(false)">Ingresar</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<footer class="bg-dark text-white py-3">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-3 text-center text-md-start mb-3 mb-md-0">
                <a href="https://www.sannicolasciudad.gob.ar/"><img src="{{ asset('assets/img/municipalidad_logo.png') }}"
                alt="Logo Municipalidad"
                width="140"></a>
            </div>
            <div class="col-md-9 text-center text-md-end">
                <p class="mb-0" style="font-size: 13px; line-height: 1.8;">
                    <i class="fas fa-map-marker-alt"></i> Lazarte y Brown, San Nicolás de los Arroyos<br>
                    <a href="mailto:sndesarrollohumano@gmail.com">
                        <i class="fas fa-envelope"></i> sndesarrollohumano@gmail.com
                    </a>
                </p>
            </div>
        </div>
    </div>
</footer>

<script>
function flip(showRegister) {
    document.getElementById('cardInner').classList.toggle('is-flipped', showRegister);
}

const EYE_OPEN  = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>';
const EYE_SLASH = '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/>'
                + '<path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/>'
                + '<line x1="1" y1="1" x2="23" y2="23"/>';

document.querySelectorAll('.eye-btn').forEach(btn => {
    btn.addEventListener('click', function () {
        const input = document.getElementById(this.dataset.target);
        const icon  = this.querySelector('.eye-icon');
        const isText = input.type === 'text';
        input.type   = isText ? 'password' : 'text';
        icon.innerHTML = isText ? EYE_OPEN : EYE_SLASH;
    });
});

const regPasswordInput = document.getElementById('reg_password');
const rulesBox = document.getElementById('pwd-rules-box');

function checkRules() {
    const v = regPasswordInput.value;
    
    const isLenOk = v.length >= 8;
    const isNumOk = /\d/.test(v);
    const isLowOk = /[a-z]/.test(v);
    const isSpeOk = /[.,!/@#$%^&*()\-_+=?;:'"`~<>[\]{}|\\]/.test(v);

    setRule('r-len', isLenOk);
    setRule('r-num', isNumOk);
    setRule('r-low', isLowOk);
    setRule('r-spe', isSpeOk);

    const allOk = isLenOk && isNumOk && isLowOk && isSpeOk;
    
    if (v.length > 0 && !allOk) {
        rulesBox.classList.add('show');
    } else {
        rulesBox.classList.remove('show');
    }
}

regPasswordInput.addEventListener('blur', () => {
    rulesBox.classList.remove('show');
});

regPasswordInput.addEventListener('focus', () => {
    checkRules(); 
});

function setRule(id, ok) {
    document.getElementById(id).classList.toggle('ok', ok);
}

function checkMatch() {
    const p   = document.getElementById('reg_password').value;
    const c   = document.getElementById('reg_password_confirmation').value;
    const msg = document.getElementById('match-msg');

    if (!c) { msg.className = 'match-msg'; return; }

    if (p === c) {
        msg.className   = 'match-msg ok';
        msg.innerHTML   = '<svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg> Las contraseñas coinciden';
    } else {
        msg.className   = 'match-msg no';
        msg.innerHTML   = '<svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg> Las contraseñas no coinciden';
    }
}

document.getElementById('loginForm').addEventListener('submit', function(e) {
    if (this.checkValidity()) {
        document.getElementById('welcomeOverlay').classList.add('active');
    }
});
</script>

</body>
</html>