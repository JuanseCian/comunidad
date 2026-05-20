<section>
    <div class="sp-section-header">
        <div class="sp-section-icon">
            <i class="bi bi-person-fill"></i>
        </div>
        <div>
            <h2 class="sp-section-title">Información del perfil</h2>
            <p class="sp-section-desc">Actualizá tu nombre y dirección de correo electrónico.</p>
        </div>
    </div>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="sp-form" x-data="{ changed: false }" @input="changed = true">
        @csrf
        @method('patch')

        <div class="sp-field-group">
            <label class="sp-label" for="name">
                <i class="bi bi-person"></i> Nombre
            </label>
            <input
                id="name" name="name" type="text"
                class="sp-input @error('name') sp-input-error @enderror"
                value="{{ old('name', $user->name) }}"
                required autofocus autocomplete="name"
                placeholder="Tu nombre completo"
            />
            @error('name')
                <span class="sp-error-msg"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span>
            @enderror
        </div>

        <div class="sp-field-group">
            <label class="sp-label" for="email">
                <i class="bi bi-envelope"></i> Correo electrónico
            </label>
            <input
                id="email" name="email" type="email"
                class="sp-input @error('email') sp-input-error @enderror"
                value="{{ old('email', $user->email) }}"
                required autocomplete="username"
                placeholder="tu@email.com"
            />
            @error('email')
                <span class="sp-error-msg"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span>
            @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="sp-verify-notice">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    <span>Tu dirección de email no está verificada.
                        <button form="send-verification" class="sp-link-btn">
                            Reenviar verificación
                        </button>
                    </span>
                </div>
                @if (session('status') === 'verification-link-sent')
                    <div class="sp-success-notice">
                        <i class="bi bi-check-circle-fill"></i> Se envió un nuevo enlace de verificación a tu email.
                    </div>
                @endif
            @endif
        </div>

        <div class="sp-form-footer">
            <button type="submit" class="sp-btn-primary">
                <i class="bi bi-check2"></i> Guardar cambios
            </button>
            @if (session('status') === 'profile-updated')
                <span
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2500)"
                    class="sp-saved-badge">
                    <i class="bi bi-check-circle-fill"></i> Guardado
                </span>
            @endif
        </div>
    </form>
</section>

<style>
.sp-section-header {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    margin-bottom: 1.75rem;
}
.sp-section-icon {
    width: 42px;
    height: 42px;
    border-radius: 10px;
    background: linear-gradient(135deg, #1a237e, #1565c0);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: 1.1rem;
    flex-shrink: 0;
}
.sp-section-title {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 1.05rem;
    font-weight: 700;
    color: #1e293b;
    margin: 0 0 .2rem;
}
.sp-section-desc {
    font-size: .85rem;
    color: #64748b;
    margin: 0;
}
.sp-form {
    display: flex;
    flex-direction: column;
    gap: 1.25rem;
}
.sp-field-group {
    display: flex;
    flex-direction: column;
    gap: .45rem;
}
.sp-label {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: .8rem;
    font-weight: 600;
    color: #475569;
    text-transform: uppercase;
    letter-spacing: .04em;
    display: flex;
    align-items: center;
    gap: .35rem;
}
.sp-input {
    width: 100%;
    padding: .6rem .85rem;
    border: 1.5px solid #e2e8f0;
    border-radius: 8px;
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: .9rem;
    color: #1e293b;
    background: #fff;
    transition: border-color .15s, box-shadow .15s;
    outline: none;
    box-sizing: border-box;
}
.sp-input:focus {
    border-color: #3949ab;
    box-shadow: 0 0 0 3px rgba(57,73,171,.12);
}
.sp-input-error { border-color: #ef4444 !important; }
.sp-error-msg {
    font-size: .8rem;
    color: #dc2626;
    display: flex;
    align-items: center;
    gap: .3rem;
}
.sp-verify-notice {
    display: flex;
    align-items: flex-start;
    gap: .5rem;
    padding: .65rem .85rem;
    background: #fff8e1;
    border: 1px solid #fde68a;
    border-radius: 8px;
    font-size: .85rem;
    color: #92400e;
}
.sp-success-notice {
    padding: .55rem .85rem;
    background: #f0fdf4;
    border: 1px solid #bbf7d0;
    border-radius: 8px;
    font-size: .85rem;
    color: #166534;
}
.sp-link-btn {
    background: none;
    border: none;
    padding: 0;
    color: #1d4ed8;
    font-size: .85rem;
    cursor: pointer;
    text-decoration: underline;
    font-family: inherit;
}
.sp-form-footer {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding-top: .5rem;
}
.sp-btn-primary {
    background: linear-gradient(135deg, #1a237e, #1565c0);
    color: #fff;
    border: none;
    padding: .6rem 1.35rem;
    border-radius: 8px;
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: .875rem;
    font-weight: 600;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: .4rem;
    transition: opacity .15s, transform .1s;
}
.sp-btn-primary:hover { opacity: .9; transform: translateY(-1px); }
.sp-btn-primary:active { transform: translateY(0); }
.sp-saved-badge {
    display: inline-flex;
    align-items: center;
    gap: .35rem;
    padding: .4rem .85rem;
    background: #f0fdf4;
    border: 1px solid #bbf7d0;
    border-radius: 20px;
    font-size: .82rem;
    font-weight: 600;
    color: #15803d;
}
</style>