<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;

class UserController extends Controller
{
    
    public function index()
    {
        $pendientes = User::whereNull('rol_id')->get();

        $activos = User::whereNotNull('rol_id')
            ->where('rol_id', '!=', 4)
            ->with('rol')
            ->get();

        $roles = Role::all();

        return view('backend.usuarios.index', compact('pendientes', 'activos', 'roles'));
    }

    
    public function aprobar(Request $request, User $user)
    {
        $request->validate([
            'rol_id' => 'required|exists:roles,id'
        ]);

        $user->rol_id = $request->rol_id;
        $user->save();

        return redirect()->back()->with('success', 'Usuario aprobado correctamente');
    }

    public function cambiarRol(Request $request, User $user)
    {
        $request->validate([
            'rol_id' => 'required|exists:roles,id'
        ]);

        $user->rol_id = $request->rol_id;
        $user->save();

        return redirect()->back()->with('success', 'Rol actualizado correctamente');
    }
}