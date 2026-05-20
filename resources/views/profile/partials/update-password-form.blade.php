<section x-data="{
    showCurrent: false,
    showNew: false,
    showConfirm: false,
    password: '',
    confirm: '',
    get strength() {
        let s = 0;
        if (this.password.length >= 8) s++;
        if (/[A-Z]/.test(this.password)) s++;
        if (/[0-9]/.test(this.password)) s++;
        if (/[^A-Za-z0-9]/.test(this.password)) s++;
        return s;
    },
    get strengthLabel() {
        return ['', 'Débil', 'Regular', 'Buena', 'Fuerte'][this.strength];
    },
    get strengthColor() {
        return ['', '#ef4444', '#f59e0b', '#3b82f6', '#22c55e'][this.strength];
    },
    get matches() {
        return this.confirm.length > 0 && this.password === this.confirm;
    }
}">
    <div class="sp-section-header">
        <div class="sp-section-icon sp-icon-amber">
            <i class="bi bi-shield-lock-fill"></i>
        </div>
        <div>
            <h2 class="sp-section-title">Cambiar contraseña</h2>
            <p class="sp-section-desc">Usá una contraseña larga y aleatoria para mantener tu cuenta segura.</p>
        </div>
    </div>

    <form method="post" action="{{ route('password.update') }}" class="sp-form">
        @csrf
        @method('put')

        {{-- Contraseña actual --}}
        <div class="sp-field-group">
            <label class="sp-label" for="update_password_current_password">
                <i class="bi bi-lock"></i> Contraseña actual
            </label>
            <div class="sp-input-wrap">
                <input
                    id="update_password_current_password"
                    name="current_password"
                    :type="showCurrent ? 'text' : 'password'"
                    class="sp-input sp-input-icon {{ $errors->updatePassword->has('current_password') ? 'sp-input-error' : '' }}"
                    autocomplete="current-password"
                    placeholder="••••••••"
                />
                <button type="button" class="sp-eye-btn" @click="showCurrent = !showCurrent" tabindex="-1">
                    <i :class="showCurrent ? 'bi bi-eye-slash' : 'bi bi-eye'"></i>
                </button>
            </div>
            @if ($errors->updatePassword->has('current_password'))
                <span class="sp-error-msg"><i class="bi bi-exclamation-circle"></i> {{ $errors->updatePassword->first('current_password') }}</span>
            @endif
        </div>

        {{-- Nueva contraseña --}}
        <div class="sp-field-group">
            <label class="sp-label" for="update_password_password">
                <i class="bi bi-key"></i> Nueva contraseña
            </label>
            <div class="sp-input-wrap">
                <input
                    id="update_password_password"
                    name="password"
                    :type="showNew ? 'text' : 'password'"
                    class="sp-input sp-input-icon {{ $errors->updatePassword->has('password') ? 'sp-input-error' : '' }}"
                    autocomplete="new-password"
                    placeholder="••••••••"
                    x-model="password"
                />
                <button type="button" class="sp-eye-btn" @click="showNew = !showNew" tabindex="-1">
                    <i :class="showNew ? 'bi bi-eye-slash' : 'bi bi-eye'"></i>
                </button>
            </div>
            @if ($errors->updatePassword->has('password'))
                <span class="sp-error-msg"><i class="bi bi-exclamation-circle"></i> {{ $errors->updatePassword->first('password') }}</span>
            @endif

            {{-- Barra de fortaleza --}}
            <div x-show="password.length > 0" x-transition class="sp-strength-wrap">
                <div class="sp-strength-bar">
                    <div class="sp-strength-fill" :style="`width: ${strength * 25}%; background: ${strengthColor}`"></div>
                </div>
                <span class="sp-strength-label" :style="`color: ${strengthColor}`" x-text="strengthLabel"></span>
            </div>
        </div>

        {{-- Confirmar contraseña --}}
        <div class="sp-field-group">
            <label class="sp-label" for="update_password_password_confirmation">
                <i class="bi bi-shield-check"></i> Confirmar contraseña
            </label>
            <div class="sp-input-wrap">
                <input
                    id="update_password_password_confirmation"
                    name="password_confirmation"
                    :type="showConfirm ? 'text' : 'password'"
                    class="sp-input sp-input-icon {{ $errors->updatePassword->has('password_confirmation') ? 'sp-input-error' : '' }}"
                    autocomplete="new-password"
                    placeholder="••••••••"
                    x-model="confirm"
                />
                <button type="button" class="sp-eye-btn" @click="showConfirm = !showConfirm" tabindex="-1">
                    <i :class="showConfirm ? 'bi bi-eye-slash' : 'bi bi-eye'"></i>
                </button>
            </div>
            <div x-show="confirm.length > 0" x-transition>
                <span x-show="matches" class="sp-match-ok"><i class="bi bi-check-circle-fill"></i> Las contraseñas coinciden</span>
                <span x-show="!matches" class="sp-match-err"><i class="bi bi-x-circle-fill"></i> No coinciden</span>
            </div>
            @if ($errors->updatePassword->has('password_confirmation'))
                <span class="sp-error-msg"><i class="bi bi-exclamation-circle"></i> {{ $errors->updatePassword->first('password_confirmation') }}</span>
            @endif
        </div>

        <div class="sp-form-footer">
            <button type="submit" class="sp-btn-primary">
                <i class="bi bi-shield-check"></i> Actualizar contraseña
            </button>
            @if (session('status') === 'password-updated')
                <span
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2500)"
                    class="sp-saved-badge">
                    <i class="bi bi-check-circle-fill"></i> Contraseña actualizada
                </span>
            @endif
        </div>
    </form>
</section>

<style>
.sp-icon-amber { background: linear-gradient(135deg, #b45309, #d97706) !important; }
.sp-input-wrap { position: relative; }
.sp-input-icon { padding-right: 2.8rem !important; }
.sp-eye-btn {
    position: absolute;
    right: .7rem;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    color: #94a3b8;
    cursor: pointer;
    font-size: 1rem;
    padding: 0;
    line-height: 1;
    transition: color .15s;
}
.sp-eye-btn:hover { color: #475569; }
.sp-strength-wrap {
    display: flex;
    align-items: center;
    gap: .75rem;
    margin-top: .2rem;
}
.sp-strength-bar {
    flex: 1;
    height: 4px;
    background: #e2e8f0;
    border-radius: 99px;
    overflow: hidden;
}
.sp-strength-fill {
    height: 100%;
    border-radius: 99px;
    transition: width .3s, background .3s;
}
.sp-strength-label {
    font-size: .78rem;
    font-weight: 600;
    min-width: 50px;
    transition: color .3s;
}
.sp-match-ok {
    font-size: .8rem;
    color: #16a34a;
    display: flex;
    align-items: center;
    gap: .3rem;
}
.sp-match-err {
    font-size: .8rem;
    color: #dc2626;
    display: flex;
    align-items: center;
    gap: .3rem;
}
</style>