@extends('backend.layouts.back')

@section('title', 'Usuarios')
@section('header', 'Gestión de Usuarios')

@section('content')

{{-- Mensaje de éxito --}}
@if(session('success'))
    <div class="mb-4 p-3 rounded-lg bg-green-50 text-green-600 text-sm">
        {{ session('success') }}
    </div>
@endif

{{-- ========================= --}}
{{-- 🔴 USUARIOS PENDIENTES --}}
{{-- ========================= --}}
<div class="mb-10">
    <h2 class="text-lg font-semibold text-slate-800 mb-4">Solicitudes pendientes</h2>

    @forelse($pendientes as $user)
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5 mb-3 flex flex-col md:flex-row md:items-center md:justify-between gap-4">

            {{-- Info --}}
            <div>
                <p class="font-semibold text-slate-800 text-sm">
                    {{ $user->nombre }} {{ $user->apellido }}
                </p>
                <p class="text-xs text-slate-400">
                    {{ $user->email }}
                </p>
            </div>

            {{-- Acción --}}
            <form method="POST" action="{{ route('usuarios.aprobar', $user) }}" class="flex gap-2">
                @csrf
                @method('PUT')

                <select name="rol_id" class="border border-slate-200 rounded-lg px-3 py-1.5 text-sm focus:ring-2 focus:ring-indigo-200">
                    @foreach($roles as $rol)
                        @if($rol->nombre !== 'inactivo')
                            <option value="{{ $rol->id }}">{{ ucfirst($rol->nombre) }}</option>
                        @endif
                    @endforeach
                </select>

                <button class="bg-emerald-500 hover:bg-emerald-600 text-white text-sm px-4 py-1.5 rounded-lg transition">
                    Aprobar
                </button>
            </form>

        </div>
    @empty
        <div class="bg-white rounded-xl border border-slate-100 p-4 text-sm text-slate-400">
            No hay solicitudes pendientes.
        </div>
    @endforelse
</div>

{{-- ========================= --}}
{{-- 🟢 USUARIOS ACTIVOS --}}
{{-- ========================= --}}
<div>
    <h2 class="text-lg font-semibold text-slate-800 mb-4">Usuarios activos</h2>

    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-slate-500">
                <tr>
                    <th class="text-left px-4 py-3">Usuario</th>
                    <th class="text-left px-4 py-3">Email</th>
                    <th class="text-left px-4 py-3">Rol</th>
                    <th class="text-left px-4 py-3">Acción</th>
                </tr>
            </thead>

            <tbody>
                @forelse($activos as $user)
                    <tr class="border-t">

                        {{-- Nombre --}}
                        <td class="px-4 py-3">
                            <p class="font-medium text-slate-800">
                                {{ $user->nombre }} {{ $user->apellido }}
                            </p>
                            <p class="text-xs text-slate-400">
                                {{ $user->username }}
                            </p>
                        </td>

                        {{-- Email --}}
                        <td class="px-4 py-3 text-slate-600">
                            {{ $user->email }}
                        </td>

                        {{-- Rol --}}
                        <td class="px-4 py-3">
                            <span class="px-2 py-1 rounded-md text-xs bg-indigo-50 text-indigo-600">
                                {{ ucfirst($user->rol->nombre ?? 'Sin rol') }}
                            </span>
                        </td>

                        {{-- Cambiar rol --}}
                        <td class="px-4 py-3">
                            <form method="POST" action="{{ route('usuarios.rol', $user) }}" class="flex gap-2">
                                @csrf
                                @method('PUT')

                                <select name="rol_id" class="border border-slate-200 rounded-lg px-2 py-1 text-xs">
                                    @foreach($roles as $rol)
                                        <option value="{{ $rol->id }}"
                                            {{ $user->rol_id == $rol->id ? 'selected' : '' }}>
                                            {{ ucfirst($rol->nombre) }}
                                        </option>
                                    @endforeach
                                </select>

                                <button class="bg-indigo-500 hover:bg-indigo-600 text-white text-xs px-3 py-1 rounded-lg">
                                    Guardar
                                </button>
                            </form>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-slate-400 py-6">
                            No hay usuarios activos.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection