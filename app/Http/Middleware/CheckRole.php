<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle($request, Closure $next, ...$roles)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        // Bloquear usuarios inactivos
        if ($user->rol_id == 4) {
            auth()->logout();

            return redirect()
                ->route('login')
                ->withErrors('Tu cuenta está inactiva. Esperá aprobación.');
        }

        // Validar roles permitidos
        if (!in_array($user->rol_id, $roles)) {

            return redirect()
                ->route('home')
                ->with('error', 'No posee permisos para ingresar a esta sección.');
        }

        return $next($request);
    }
}