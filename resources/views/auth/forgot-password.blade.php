<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Recuperar contraseña | Comunidad</title>

    <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body{
            font-family:'Poppins',sans-serif;
            min-height:100vh;
            display:flex;
            align-items:center;
            justify-content:center;
            background:linear-gradient(135deg,#1a3a6e 0%,#2563b8 55%,#06b6d4 100%);
            padding:20px;
        }

        .auth-card{
            width:100%;
            max-width:480px;
            background:#fff;
            border-radius:24px;
            padding:42px;
            box-shadow:0 24px 60px rgba(0,0,0,.18);
        }

        .title{
            font-size:28px;
            font-weight:700;
            color:#0f172a;
            margin-bottom:8px;
        }

        .sub{
            color:#64748b;
            font-size:14px;
            line-height:1.6;
            margin-bottom:28px;
        }

        .field{
            margin-bottom:22px;
        }

        .field label{
            font-size:12px;
            font-weight:600;
            margin-bottom:8px;
            display:block;
            color:#334155;
            text-transform:uppercase;
        }

        .input{
            width:100%;
            border:1.5px solid #dbe4f0;
            background:#f8fafc;
            border-radius:12px;
            padding:12px 16px;
            font-size:14px;
            outline:none;
            transition:.2s;
        }

        .input:focus{
            border-color:#2563b8;
            background:#fff;
            box-shadow:0 0 0 4px rgba(37,99,184,.12);
        }

        .btn-main{
            width:100%;
            border:none;
            border-radius:12px;
            padding:13px;
            background:linear-gradient(135deg,#1d4ed8,#06b6d4);
            color:#fff;
            font-weight:600;
            font-size:15px;
            transition:.2s;
        }

        .btn-main:hover{
            transform:translateY(-1px);
            opacity:.95;
        }

        .status{
            background:#f0fdf4;
            border:1px solid #86efac;
            color:#166534;
            padding:12px;
            border-radius:12px;
            margin-bottom:20px;
            font-size:13px;
        }

        .error{
            color:#dc2626;
            font-size:12px;
            margin-top:6px;
        }

        .back-link{
            display:block;
            text-align:center;
            margin-top:18px;
            font-size:13px;
            color:#2563b8;
            text-decoration:none;
            font-weight:500;
        }

        .back-link:hover{
            text-decoration:underline;
        }
    </style>
</head>
<body>

<div class="auth-card">

    <div class="title">
        Recuperar contraseña
    </div>

    <div class="sub">
        Ingresá tu correo electrónico y te enviaremos un enlace para restablecer tu contraseña.
    </div>

    @if (session('status'))
        <div class="status">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="field">
            <label>Email</label>

            <input
                type="email"
                name="email"
                class="input"
                value="{{ old('email') }}"
                placeholder="correo@ejemplo.com"
                required
                autofocus
            >

            @error('email')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <button class="btn-main">
            Enviar enlace de recuperación
        </button>
    </form>

    <a href="{{ route('login') }}" class="back-link">
        ← Volver al inicio de sesión
    </a>

</div>

</body>
</html>