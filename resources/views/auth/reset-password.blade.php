<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Restablecer contraseña | Comunidad</title>

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
            max-width:520px;
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
            margin-bottom:20px;
        }

        .field label{
            display:block;
            font-size:12px;
            font-weight:600;
            margin-bottom:8px;
            text-transform:uppercase;
            color:#334155;
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
            margin-top:10px;
            transition:.2s;
        }

        .btn-main:hover{
            transform:translateY(-1px);
            opacity:.95;
        }

        .error{
            color:#dc2626;
            font-size:12px;
            margin-top:6px;
        }

        .input-wrap{
            position:relative;
            display:flex;
            align-items:center;
        }

        .eye-btn{
            position:absolute;
            right:10px;
            background:none;
            border:none;
            cursor:pointer;
            color:#94a3b8;
            display:flex;
            align-items:center;
            padding:4px;
            border-radius:6px;
            transition:.2s;
        }

        .eye-btn:hover{
            color:#2563b8;
        }

        .pwd-rules{
            position:absolute;
            top:50%;
            left:calc(100% + 15px);
            transform:translateY(-50%);
            width:240px;
            background:#fff;
            border:1px solid #dbe4f0;
            border-radius:14px;
            padding:14px;
            box-shadow:0 10px 30px rgba(0,0,0,.08);
            display:flex;
            flex-direction:column;
            gap:7px;
            opacity:0;
            visibility:hidden;
            transition:.25s;
            z-index:10;
        }

        .pwd-rules.show{
            opacity:1;
            visibility:visible;
        }

        .pwd-rules::before{
            content:'';
            position:absolute;
            left:-6px;
            top:50%;
            transform:translateY(-50%) rotate(45deg);
            width:10px;
            height:10px;
            background:#fff;
            border-left:1px solid #dbe4f0;
            border-bottom:1px solid #dbe4f0;
        }

        .rule{
            display:flex;
            align-items:center;
            gap:8px;
            font-size:12px;
            color:#94a3b8;
        }

        .rule-dot{
            width:16px;
            height:16px;
            border-radius:50%;
            border:1.5px solid #cbd5e1;
            display:flex;
            align-items:center;
            justify-content:center;
            font-size:9px;
        }

        .rule.ok{
            color:#16a34a;
        }

        .rule.ok .rule-dot{
            background:#16a34a;
            border-color:#16a34a;
            color:#fff;
        }

        .match-msg{
            margin-top:8px;
            font-size:12px;
            display:none;
            align-items:center;
            gap:5px;
        }

        .match-msg.ok{
            display:flex;
            color:#16a34a;
        }

        .match-msg.no{
            display:flex;
            color:#dc2626;
        }

        @media(max-width:991px){

            .pwd-rules{
                position:relative;
                top:auto;
                left:auto;
                transform:none;
                width:100%;
                margin-top:10px;
                box-shadow:none;
            }

            .pwd-rules::before{
                display:none;
            }
        }
    </style>
</head>
<body>

<div class="auth-card">

    <div class="title">
        Nueva contraseña
    </div>

    <div class="sub">
        Ingresá una nueva contraseña para continuar utilizando el sistema Comunidad.
    </div>

    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div class="field">
            <label>Email</label>

            <input
                type="email"
                name="email"
                class="input"
                value="{{ old('email', $request->email) }}"
                required
                autofocus
            >

            @error('email')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="field">
            <label>Nueva contraseña</label>

            <div class="input-wrap">
                <input
                    type="password"
                    name="password"
                    id="password"
                    class="input"
                    placeholder="••••••••"
                    required
                    oninput="checkRules(); checkMatch()"
                >

                <button class="eye-btn" type="button" data-target="password">
                    <svg class="eye-icon" width="16" height="16" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                        <circle cx="12" cy="12" r="3"/>
                    </svg>
                </button>

                <div class="pwd-rules" id="pwd-rules-box">
                    <div class="rule" id="r-len">
                        <div class="rule-dot">✓</div>
                        Mínimo 8 caracteres
                    </div>

                    <div class="rule" id="r-num">
                        <div class="rule-dot">✓</div>
                        Al menos un número
                    </div>

                    <div class="rule" id="r-low">
                        <div class="rule-dot">✓</div>
                        Una minúscula
                    </div>

                    <div class="rule" id="r-spe">
                        <div class="rule-dot">✓</div>
                        Un carácter especial
                    </div>
                </div>
            </div>

            @error('password')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="field">
            <label>Confirmar contraseña</label>

            <div class="input-wrap">
                <input
                    type="password"
                    name="password_confirmation"
                    id="password_confirmation"
                    class="input"
                    placeholder="••••••••"
                    required
                    oninput="checkMatch()"
                >

                <button class="eye-btn" type="button" data-target="password_confirmation">
                    <svg class="eye-icon" width="16" height="16" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11-8-11-8z"/>
                        <circle cx="12" cy="12" r="3"/>
                    </svg>
                </button>
            </div>

            <div class="match-msg" id="match-msg"></div>

            @error('password_confirmation')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <button class="btn-main">
            Restablecer contraseña
        </button>
    </form>

</div>

<script>

const EYE_OPEN  = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>';
const EYE_SLASH = '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/>'
                + '<path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/>'
                + '<line x1="1" y1="1" x2="23" y2="23"/>';

document.querySelectorAll('.eye-btn').forEach(btn => {

    btn.addEventListener('click', function () {

        const input = document.getElementById(this.dataset.target);
        const icon  = this.querySelector('.eye-icon');

        const isText = input.type === 'text';

        input.type = isText ? 'password' : 'text';

        icon.innerHTML = isText ? EYE_OPEN : EYE_SLASH;
    });
});

const passwordInput = document.getElementById('password');
const rulesBox      = document.getElementById('pwd-rules-box');

function checkRules(){

    const v = passwordInput.value;

    const isLenOk = v.length >= 8;
    const isNumOk = /\d/.test(v);
    const isLowOk = /[a-z]/.test(v);
    const isSpeOk = /[.,!/@#$%^&*()\-_+=?;:'"`~<>[\]{}|\\]/.test(v);

    setRule('r-len', isLenOk);
    setRule('r-num', isNumOk);
    setRule('r-low', isLowOk);
    setRule('r-spe', isSpeOk);

    const allOk = isLenOk && isNumOk && isLowOk && isSpeOk;

    if(v.length > 0 && !allOk){
        rulesBox.classList.add('show');
    }else{
        rulesBox.classList.remove('show');
    }
}

passwordInput.addEventListener('focus', () => {
    checkRules();
});

passwordInput.addEventListener('blur', () => {
    rulesBox.classList.remove('show');
});

function setRule(id, ok){
    document.getElementById(id).classList.toggle('ok', ok);
}

function checkMatch(){

    const p   = document.getElementById('password').value;
    const c   = document.getElementById('password_confirmation').value;
    const msg = document.getElementById('match-msg');

    if(!c){
        msg.className = 'match-msg';
        return;
    }

    if(p === c){

        msg.className = 'match-msg ok';

        msg.innerHTML =
            '<svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg> Las contraseñas coinciden';

    }else{

        msg.className = 'match-msg no';

        msg.innerHTML =
            '<svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg> Las contraseñas no coinciden';
    }
}

</script>

</body>
</html>