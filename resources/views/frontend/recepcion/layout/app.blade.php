<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        Recepción | @yield('title')
    </title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>

        :root{
            --primary:#2563eb;
            --secondary:#0f172a;
            --bg:#f1f5f9;
            --text:#1e293b;
        }

        *{
            box-sizing:border-box;
        }

        body{
            margin:0;
            background:
                radial-gradient(circle at top left, rgba(59,130,246,.08), transparent 28%),
                radial-gradient(circle at bottom right, rgba(16,185,129,.08), transparent 25%),
                var(--bg);
            min-height:100vh;
            font-family:'Inter',sans-serif;
            color:var(--text);
        }

        /* SIDEBAR */

        .sidebar{
            width:260px;
            height:100vh;
            position:fixed;
            left:0;
            top:0;
            background:linear-gradient(180deg,#0f172a 0%, #1e293b 55%, #334155 100%);
            padding:24px 18px;
            display:flex;
            flex-direction:column;
            justify-content:space-between;
            box-shadow:8px 0 25px rgba(15,23,42,.08);
            z-index:1000;
        }

        .brand{
            text-decoration:none;
            color:white;
            display:flex;
            align-items:center;
            gap:14px;
            margin-bottom:35px;
        }

        .brand-logo{
            width:48px;
            height:48px;
            border-radius:14px;
            background:linear-gradient(135deg,#3b82f6,#06b6d4);
            display:flex;
            align-items:center;
            justify-content:center;
            font-size:1.2rem;
            box-shadow:0 8px 20px rgba(59,130,246,.25);
        }

        .brand h5{
            margin:0;
            font-weight:700;
            font-size:1rem;
        }

        .brand span{
            color:rgba(255,255,255,.65);
            font-size:.82rem;
        }

        .sidebar-links{
            display:flex;
            flex-direction:column;
            gap:10px;
        }

        .sidebar-links a{
            text-decoration:none;
            color:rgba(255,255,255,.78);
            padding:13px 15px;
            border-radius:14px;
            display:flex;
            align-items:center;
            gap:12px;
            font-weight:500;
            transition:.2s ease;
        }

        .sidebar-links a i{
            font-size:1rem;
        }

        .sidebar-links a:hover,
        .sidebar-links a.active{
            background:rgba(255,255,255,.08);
            color:white;
            transform:translateX(2px);
        }

        .logout-btn{
            width:100%;
            border:none;
            background:rgba(255,255,255,.08);
            color:white;
            padding:12px;
            border-radius:14px;
            transition:.2s;
            font-weight:600;
        }

        .logout-btn:hover{
            background:rgba(255,255,255,.14);
        }

        /* CONTENT */

        .main{
            margin-left:260px;
            min-height:100vh;
            padding:26px;
        }

        .topbar{
            background:rgba(255,255,255,.75);
            backdrop-filter:blur(14px);
            border:1px solid rgba(255,255,255,.5);
            border-radius:20px;
            padding:18px 22px;
            margin-bottom:26px;
            display:flex;
            align-items:center;
            justify-content:space-between;
            box-shadow:0 8px 30px rgba(15,23,42,.04);
        }

        .topbar-title h4{
            margin:0;
            font-weight:700;
            color:#0f172a;
        }

        .topbar-title p{
            margin:2px 0 0;
            color:#64748b;
            font-size:.92rem;
        }

        .topbar-badge{
            background:linear-gradient(135deg,#3b82f6,#06b6d4);
            color:white;
            padding:10px 16px;
            border-radius:999px;
            font-size:.85rem;
            font-weight:600;
            box-shadow:0 8px 18px rgba(59,130,246,.18);
        }

        .content{
            animation:fade .25s ease;
        }

        @keyframes fade{
            from{
                opacity:0;
                transform:translateY(8px);
            }
            to{
                opacity:1;
                transform:translateY(0);
            }
        }

        footer{
            margin-top:40px;
            text-align:center;
            color:#64748b;
            font-size:.9rem;
        }

        /* MOBILE */

        @media(max-width:992px){

            .sidebar{
                width:100%;
                height:auto;
                position:relative;
                border-radius:0 0 24px 24px;
            }

            .main{
                margin-left:0;
                padding:18px;
            }

            .topbar{
                flex-direction:column;
                align-items:flex-start;
                gap:14px;
            }
        }

    </style>

</head>

<body>

    {{-- SIDEBAR --}}
    <aside class="sidebar">

        <div>

            {{-- BRAND --}}
            <a href="{{ route('recepcion.dashboard') }}"
               class="brand">

                <div class="brand-logo">
                    <i class="bi bi-grid-1x2-fill"></i>
                </div>

                <div>

                    <h5>
                        Comunidad
                    </h5>

                    <span>
                        Mesa de Entrada
                    </span>

                </div>

            </a>

            {{-- LINKS --}}
            <div class="sidebar-links">

                <a href="{{ route('recepcion.dashboard') }}"
                   class="{{ request()->routeIs('recepcion.dashboard') ? 'active' : '' }}">

                    <i class="bi bi-house-door-fill"></i>

                    Inicio
                </a>

                <a href="{{ route('recepcion.ingresos.index') }}"
                   class="{{ request()->routeIs('recepcion.ingresos.*') ? 'active' : '' }}">

                    <i class="bi bi-journal-text"></i>

                    Ingresos
                </a>

                <a href="{{ route('recepcion.mercaderias.index') }}"
                   class="{{ request()->routeIs('recepcion.mercaderias.*') ? 'active' : '' }}">

                    <i class="bi bi-box-seam"></i>

                    Mercadería
                </a>

                <a href="{{ route('personas.index') }}"
                   class="{{ request()->routeIs('personas.*') ? 'active' : '' }}">

                    <i class="bi bi-people-fill"></i>

                    Personas
                </a>

            </div>

        </div>

        {{-- LOGOUT --}}
        <form action="{{ route('logout') }}"
              method="POST">

            @csrf

            <button class="logout-btn">

                <i class="bi bi-box-arrow-right me-2"></i>

                Cerrar sesión

            </button>

        </form>

    </aside>

    {{-- MAIN --}}
    <main class="main">

        {{-- TOPBAR --}}
        <div class="topbar">

            <div class="topbar-title">

                <h4>
                    Panel de Recepción
                </h4>

                <p>
                    Gestión rápida y organizada de atención social.
                </p>

            </div>

            <div class="topbar-badge">

                <i class="bi bi-activity me-1"></i>

                Sistema activo

            </div>

        </div>

        {{-- CONTENT --}}
        <div class="content">

            @yield('content')

        </div>

        {{-- FOOTER --}}
        <footer>

            Comunidad · Mesa de Entrada

        </footer>

    </main>

    @stack('scripts')

</body>
</html>