<section x-data="{ confirmOpen: false, passwordVal: '' }">

    <div class="sp-section-header">
        <div class="sp-section-icon sp-icon-danger">
            <i class="bi bi-trash3-fill"></i>
        </div>
        <div>
            <h2 class="sp-section-title">Eliminar cuenta</h2>
            <p class="sp-section-desc">Esta acción es permanente e irreversible. Todos tus datos serán eliminados.</p>
        </div>
    </div>

    <div class="sp-danger-notice">
        <i class="bi bi-exclamation-triangle-fill"></i>
        <div>
            <strong>Antes de eliminar tu cuenta</strong> descargá cualquier dato o información que quieras conservar.
            Una vez eliminada, no podremos recuperarla.
        </div>
    </div>

    <button
        type="button"
        class="sp-btn-danger"
        @click="confirmOpen = true">
        <i class="bi bi-trash3"></i> Eliminar mi cuenta
    </button>

    {{-- Modal de confirmación --}}
    <div
        x-show="confirmOpen"
        x-transition.opacity
        class="sp-modal-overlay"
        @click.self="confirmOpen = false"
        style="display:none">

        <div class="sp-modal" x-transition.scale @click.stop>
            <div class="sp-modal-header">
                <div class="sp-modal-icon">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                </div>
                <h3 class="sp-modal-title">¿Confirmar eliminación?</h3>
                <button type="button" class="sp-modal-close" @click="confirmOpen = false">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>

            <p class="sp-modal-body">
                Todos tus recursos y datos serán eliminados de forma permanente.
                Ingresá tu contraseña para confirmar esta acción.
            </p>

            <form method="post" action="{{ route('profile.destroy') }}">
                @csrf
                @method('delete')

                <div class="sp-field-group" style="margin-bottom:1.25rem">
                    <label class="sp-label" for="password">
                        <i class="bi bi-lock"></i> Contraseña
                    </label>
                    <input
                        id="password"
                        name="password"
                        type="password"
                        class="sp-input {{ $errors->userDeletion->has('password') ? 'sp-input-error' : '' }}"
                        placeholder="Tu contraseña actual"
                        x-model="passwordVal"
                        required
                    />
                    @if ($errors->userDeletion->has('password'))
                        <span class="sp-error-msg">
                            <i class="bi bi-exclamation-circle"></i> {{ $errors->userDeletion->first('password') }}
                        </span>
                    @endif
                </div>

                <div class="sp-modal-footer">
                    <button type="button" class="sp-btn-secondary" @click="confirmOpen = false">
                        Cancelar
                    </button>
                    <button
                        type="submit"
                        class="sp-btn-danger"
                        :disabled="passwordVal.length < 1">
                        <i class="bi bi-trash3"></i> Sí, eliminar cuenta
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

<style>
.sp-icon-danger { background: linear-gradient(135deg, #991b1b, #dc2626) !important; }
.sp-danger-notice {
    display: flex;
    align-items: flex-start;
    gap: .75rem;
    padding: .9rem 1rem;
    background: #fff5f5;
    border: 1px solid #fecaca;
    border-left: 3px solid #ef4444;
    border-radius: 8px;
    font-size: .875rem;
    color: #7f1d1d;
    margin-bottom: 1.5rem;
    line-height: 1.5;
}
.sp-danger-notice i { color: #ef4444; font-size: 1.1rem; margin-top: .1rem; flex-shrink:0; }
.sp-btn-danger {
    background: #dc2626;
    color: #fff;
    border: none;
    padding: .6rem 1.35rem;
    border-radius: 8px;
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: .875rem;
    font-weight: 600;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: .4rem;
    transition: background .15s, transform .1s;
}
.sp-btn-danger:hover { background: #b91c1c; transform: translateY(-1px); }
.sp-btn-danger:disabled { opacity: .45; cursor: not-allowed; transform: none; }
.sp-modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(15,23,42,.55);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 9999;
    padding: 1rem;
}
.sp-modal {
    background: #fff;
    border-radius: 14px;
    padding: 1.75rem;
    max-width: 420px;
    width: 100%;
    box-shadow: 0 20px 60px rgba(0,0,0,.2);
}
.sp-modal-header {
    display: flex;
    align-items: center;
    gap: .75rem;
    margin-bottom: 1rem;
    position: relative;
}
.sp-modal-icon {
    width: 38px;
    height: 38px;
    border-radius: 9px;
    background: #fee2e2;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #dc2626;
    font-size: 1rem;
    flex-shrink: 0;
}
.sp-modal-title {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 1rem;
    font-weight: 700;
    color: #1e293b;
    margin: 0;
}
.sp-modal-close {
    background: none;
    border: none;
    color: #94a3b8;
    cursor: pointer;
    font-size: .9rem;
    padding: .2rem;
    position: absolute;
    right: 0;
    top: 0;
    transition: color .15s;
}
.sp-modal-close:hover { color: #475569; }
.sp-modal-body {
    font-size: .875rem;
    color: #64748b;
    margin: 0 0 1.25rem;
    line-height: 1.6;
}
.sp-modal-footer {
    display: flex;
    justify-content: flex-end;
    gap: .75rem;
    align-items: center;
}
.sp-btn-secondary {
    background: none;
    border: 1.5px solid #e2e8f0;
    color: #475569;
    padding: .55rem 1.1rem;
    border-radius: 8px;
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: .875rem;
    font-weight: 600;
    cursor: pointer;
    transition: border-color .15s, color .15s;
}
.sp-btn-secondary:hover { border-color: #94a3b8; color: #1e293b; }
</style>