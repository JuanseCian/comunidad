<x-app-layout>
    <x-slot name="header"></x-slot>

    <div class="profile-wrapper" x-data="{ tab: 'info' }" x-cloak>

        {{-- HERO --}}
        <section class="profile-hero">
            <div class="profile-hero-overlay"></div>

            <div class="profile-hero-content">

                @php
                    $words = explode(' ', auth()->user()->name);
                    $initials = strtoupper(
                        substr($words[0], 0, 1) .
                        (isset($words[1]) ? substr($words[1], 0, 1) : '')
                    );
                @endphp

                <div class="profile-avatar">
                    {{ $initials ?: 'US' }}
                </div>

                <div class="profile-user-info">
                    <div class="profile-badge">
                        <i class="bi bi-shield-check"></i>
                        Cuenta activa
                    </div>

                    <h1>{{ auth()->user()->name }}</h1>

                    <p>
                        <i class="bi bi-envelope-fill"></i>
                        {{ auth()->user()->email }}
                    </p>
                </div>

            </div>
        </section>

        {{-- CONTENT --}}
        <div class="profile-content">

            {{-- SIDEBAR --}}
            <aside class="profile-sidebar">

                <button
                    class="profile-tab"
                    :class="{ 'active': tab === 'info' }"
                    @click="tab = 'info'">

                    <div class="profile-tab-icon">
                        <i class="bi bi-person-vcard-fill"></i>
                    </div>

                    <div>
                        <strong>Información</strong>
                        <span>Datos personales y correo</span>
                    </div>

                </button>

                <button
                    class="profile-tab"
                    :class="{ 'active': tab === 'password' }"
                    @click="tab = 'password'">

                    <div class="profile-tab-icon">
                        <i class="bi bi-shield-lock-fill"></i>
                    </div>

                    <div>
                        <strong>Seguridad</strong>
                        <span>Actualizar contraseña</span>
                    </div>

                </button>

                <button
                    class="profile-tab danger"
                    :class="{ 'active': tab === 'delete' }"
                    @click="tab = 'delete'">

                    <div class="profile-tab-icon">
                        <i class="bi bi-trash3-fill"></i>
                    </div>

                    <div>
                        <strong>Eliminar cuenta</strong>
                        <span>Acción permanente</span>
                    </div>

                </button>

            </aside>

            {{-- MAIN --}}
            <section class="profile-main">

                <div
                    x-show="tab === 'info'"
                    x-transition.opacity.duration.200ms>

                    <div class="profile-card">
                        <div class="profile-card-header">
                            <div>
                                <h2>Información del perfil</h2>
                                <p>Actualizá tus datos personales y correo electrónico.</p>
                            </div>
                        </div>

                        @include('profile.partials.update-profile-information-form')
                    </div>

                </div>

                <div
                    x-show="tab === 'password'"
                    x-transition.opacity.duration.200ms>

                    <div class="profile-card">
                        <div class="profile-card-header">
                            <div>
                                <h2>Seguridad de la cuenta</h2>
                                <p>Mantené tu cuenta protegida con una contraseña segura.</p>
                            </div>
                        </div>

                        @include('profile.partials.update-password-form')
                    </div>

                </div>

                <div
                    x-show="tab === 'delete'"
                    x-transition.opacity.duration.200ms>

                    <div class="profile-card danger-card">
                        <div class="profile-card-header">
                            <div>
                                <h2>Eliminar cuenta</h2>
                                <p>Esta acción eliminará permanentemente tu cuenta y datos asociados.</p>
                            </div>
                        </div>

                        @include('profile.partials.delete-user-form')
                    </div>

                </div>

            </section>

        </div>
    </div>

    <style>

        [x-cloak] {
            display: none !important;
        }

        .profile-wrapper {
            --primary: #2563eb;
            --primary-dark: #1d4ed8;
            --bg: #f8fafc;
            --card: #ffffff;
            --text: #0f172a;
            --muted: #64748b;
            --border: #e2e8f0;
            --danger: #dc2626;

            min-height: 100vh;
            background:
                radial-gradient(circle at top right, rgba(37,99,235,.08), transparent 30%),
                #f8fafc;

            padding-bottom: 4rem;

            font-family:
                'Inter',
                'Plus Jakarta Sans',
                sans-serif;
        }

        /* HERO */

        .profile-hero {
            position: relative;
            overflow: hidden;

            background:
                linear-gradient(
                    135deg,
                    #0f172a 0%,
                    #1e293b 45%,
                    #2563eb 100%
                );

            padding: 4rem 1.5rem;
        }

        .profile-hero-overlay {
            position: absolute;
            inset: 0;

            background:
                radial-gradient(circle at top left, rgba(255,255,255,.08), transparent 30%);
        }

        .profile-hero-content {
            position: relative;
            z-index: 2;

            max-width: 1200px;
            margin: 0 auto;

            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .profile-avatar {
            width: 90px;
            height: 90px;

            border-radius: 24px;

            background: rgba(255,255,255,.12);

            border: 1px solid rgba(255,255,255,.18);

            backdrop-filter: blur(14px);

            display: flex;
            align-items: center;
            justify-content: center;

            color: white;
            font-size: 2rem;
            font-weight: 800;

            box-shadow:
                0 10px 30px rgba(0,0,0,.15);
        }

        .profile-user-info h1 {
            margin: .6rem 0 .35rem;

            color: white;
            font-size: 2rem;
            font-weight: 800;
            letter-spacing: -.03em;
        }

        .profile-user-info p {
            margin: 0;

            display: flex;
            align-items: center;
            gap: .5rem;

            color: rgba(255,255,255,.75);
            font-size: .95rem;
        }

        .profile-badge {
            display: inline-flex;
            align-items: center;
            gap: .5rem;

            background: rgba(255,255,255,.12);

            border: 1px solid rgba(255,255,255,.15);

            color: white;

            padding: .45rem .8rem;
            border-radius: 999px;

            font-size: .75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .04em;
        }

        /* CONTENT */

        .profile-content {
            max-width: 1200px;
            margin: -50px auto 0;

            padding: 0 1.5rem;

            display: grid;
            grid-template-columns: 300px 1fr;
            gap: 2rem;

            position: relative;
            z-index: 10;
        }

        /* SIDEBAR */

        .profile-sidebar {
            background: rgba(255,255,255,.75);

            backdrop-filter: blur(20px);

            border: 1px solid rgba(255,255,255,.4);

            border-radius: 28px;

            padding: 1rem;

            height: fit-content;

            box-shadow:
                0 10px 40px rgba(15,23,42,.06);
        }

        .profile-tab {
            width: 100%;

            border: none;
            background: transparent;

            padding: 1rem;

            border-radius: 18px;

            display: flex;
            align-items: center;
            gap: 1rem;

            text-align: left;

            cursor: pointer;

            transition: .25s ease;
        }

        .profile-tab:hover {
            background: #f8fafc;
        }

        .profile-tab.active {
            background:
                linear-gradient(
                    135deg,
                    rgba(37,99,235,.12),
                    rgba(37,99,235,.05)
                );

            border: 1px solid rgba(37,99,235,.12);
        }

        .profile-tab.danger.active {
            background: rgba(220,38,38,.08);
            border: 1px solid rgba(220,38,38,.12);
        }

        .profile-tab-icon {
            width: 46px;
            height: 46px;

            border-radius: 14px;

            background: #eff6ff;
            color: var(--primary);

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 1rem;

            flex-shrink: 0;
        }

        .profile-tab.danger .profile-tab-icon {
            background: #fef2f2;
            color: var(--danger);
        }

        .profile-tab strong {
            display: block;

            color: var(--text);
            font-size: .95rem;
            font-weight: 700;
        }

        .profile-tab span {
            color: var(--muted);
            font-size: .82rem;
        }

        /* MAIN */

        .profile-main {
            min-width: 0;
        }

        .profile-card {
            background: rgba(255,255,255,.85);

            backdrop-filter: blur(20px);

            border: 1px solid rgba(255,255,255,.5);

            border-radius: 32px;

            padding: 2rem;

            box-shadow:
                0 10px 40px rgba(15,23,42,.06);
        }

        .profile-card.danger-card {
            border-color: rgba(220,38,38,.15);
        }

        .profile-card-header {
            margin-bottom: 2rem;
        }

        .profile-card-header h2 {
            margin: 0 0 .4rem;

            color: var(--text);

            font-size: 1.45rem;
            font-weight: 800;

            letter-spacing: -.03em;
        }

        .profile-card-header p {
            margin: 0;

            color: var(--muted);
            font-size: .95rem;
        }

        /* MOBILE */

        @media (max-width: 992px) {

            .profile-content {
                grid-template-columns: 1fr;
            }

            .profile-sidebar {
                display: flex;
                flex-direction: column;
            }

        }

        @media (max-width: 640px) {

            .profile-hero-content {
                flex-direction: column;
                align-items: flex-start;
            }

            .profile-user-info h1 {
                font-size: 1.7rem;
            }

            .profile-card {
                padding: 1.35rem;
                border-radius: 24px;
            }

        }

    </style>
</x-app-layout>