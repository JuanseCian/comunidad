<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        /*
        |--------------------------------------------------------------------------
        | Usuarios pendientes
        |--------------------------------------------------------------------------
        */

        $pendientes = User::query()

            ->whereNull('rol_id')

            ->when($search, function ($query) use ($search) {

                $query->where(function ($q) use ($search) {

                    $q->where('nombre', 'like', "%{$search}%")
                        ->orWhere('apellido', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('username', 'like', "%{$search}%");

                });

            })

            ->latest()
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Usuarios activos
        |--------------------------------------------------------------------------
        */

        $activos = User::with('rol')

            ->whereNotNull('rol_id')
            ->where('rol_id', '!=', 4)

            ->when($search, function ($query) use ($search) {

                $query->where(function ($q) use ($search) {

                    $q->where('nombre', 'like', "%{$search}%")
                        ->orWhere('apellido', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('username', 'like', "%{$search}%");

                });

            })

            ->latest()
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Usuarios bloqueados / inactivos
        |--------------------------------------------------------------------------
        */

        $bloqueados = User::with('rol')

            ->where('rol_id', 4)

            ->when($search, function ($query) use ($search) {

                $query->where(function ($q) use ($search) {

                    $q->where('nombre', 'like', "%{$search}%")
                        ->orWhere('apellido', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('username', 'like', "%{$search}%");

                });

            })

            ->latest()
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Roles
        |--------------------------------------------------------------------------
        */

        $roles = Role::all();

        /*
        |--------------------------------------------------------------------------
        | Estadísticas
        |--------------------------------------------------------------------------
        */

        $totalUsuarios = User::count();

        $usuariosActivos = User::whereNotNull('rol_id')
            ->where('rol_id', '!=', 4)
            ->count();

        $usuariosPendientes = User::whereNull('rol_id')->count();

        $usuariosBloqueados = User::where('rol_id', 4)->count();

        return view('backend.usuarios.index', compact(
            'pendientes',
            'activos',
            'bloqueados',
            'roles',

            'totalUsuarios',
            'usuariosActivos',
            'usuariosPendientes',
            'usuariosBloqueados'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | Aprobar usuario
    |--------------------------------------------------------------------------
    */

    public function aprobar(Request $request, User $user)
    {
        $request->validate([
            'rol_id' => 'required|exists:roles,id'
        ]);

        $user->update([
            'rol_id' => $request->rol_id
        ]);

        return back()->with(
            'success',
            'Usuario aprobado correctamente.'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Cambiar rol
    |--------------------------------------------------------------------------
    */

    public function cambiarRol(Request $request, User $user)
    {
        $request->validate([
            'rol_id' => 'required|exists:roles,id'
        ]);

        /*
        |--------------------------------------------------------------------------
        | Evitar quitarse admin a sí mismo
        |--------------------------------------------------------------------------
        */

        if (
            auth()->id() === $user->id &&
            $request->rol_id != 3
        ) {
            return back()->with(
                'error',
                'No podés quitarte tu propio rol administrador.'
            );
        }

        $user->update([
            'rol_id' => $request->rol_id
        ]);

        return back()->with(
            'success',
            'Rol actualizado correctamente.'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Bloquear usuario
    |--------------------------------------------------------------------------
    */

    public function bloquear(User $user)
    {
        /*
        |--------------------------------------------------------------------------
        | Evitar bloquearse a sí mismo
        |--------------------------------------------------------------------------
        */

        if (auth()->id() === $user->id) {

            return back()->with(
                'error',
                'No podés bloquear tu propio usuario.'
            );
        }

        $user->update([
            'rol_id' => 4
        ]);

        return back()->with(
            'success',
            'Usuario bloqueado correctamente.'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Reactivar usuario
    |--------------------------------------------------------------------------
    */

    public function reactivar(User $user)
    {
        $user->update([
            'rol_id' => 2
        ]);

        return back()->with(
            'success',
            'Usuario reactivado correctamente.'
        );
    }
}
