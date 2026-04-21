<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next, ...$roles)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        // Bloquear inactivos directamente
        if ($user->rol_id == 4) {
            auth()->logout();
            return redirect()->route('login')
                ->withErrors('Tu cuenta está inactiva. Esperá aprobación.');
        }

        if (!in_array($user->rol_id, $roles)) {
            abort(403);
        }

        return $next($request);
    }
}
