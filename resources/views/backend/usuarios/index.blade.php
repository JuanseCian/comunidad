@extends('backend.layouts.back')

@section('title', 'Usuarios')
@section('header', 'Gestión de Usuarios')

@section('content')

<div class="space-y-8">

    {{-- ALERTAS --}}
    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-5 py-4 rounded-2xl text-sm shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-rose-50 border border-rose-200 text-rose-700 px-5 py-4 rounded-2xl text-sm shadow-sm">
            {{ session('error') }}
        </div>
    @endif

    {{-- ========================= --}}
    {{-- RESUMEN --}}
    {{-- ========================= --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-5">

        <div class="bg-white rounded-3xl border border-slate-100 p-6 shadow-sm">
            <p class="text-sm text-slate-400">
                Usuarios Totales
            </p>

            <h2 class="text-4xl font-bold text-slate-800 mt-3">
                {{ $totalUsuarios }}
            </h2>
        </div>

        <div class="bg-emerald-50 rounded-3xl border border-emerald-100 p-6 shadow-sm">
            <p class="text-sm text-emerald-600">
                Usuarios Activos
            </p>

            <h2 class="text-4xl font-bold text-emerald-700 mt-3">
                {{ $usuariosActivos }}
            </h2>
        </div>

        <div class="bg-amber-50 rounded-3xl border border-amber-100 p-6 shadow-sm">
            <p class="text-sm text-amber-600">
                Pendientes
            </p>

            <h2 class="text-4xl font-bold text-amber-700 mt-3">
                {{ $usuariosPendientes }}
            </h2>
        </div>

        <div class="bg-rose-50 rounded-3xl border border-rose-100 p-6 shadow-sm">
            <p class="text-sm text-rose-600">
                Bloqueados
            </p>

            <h2 class="text-4xl font-bold text-rose-700 mt-3">
                {{ $usuariosBloqueados }}
            </h2>
        </div>

    </div>

    {{-- ========================= --}}
    {{-- BUSCADOR --}}
    {{-- ========================= --}}
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-5">

        <form method="GET" class="flex flex-col md:flex-row gap-4">

            <div class="flex-1">
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Buscar por nombre, apellido, email o username..."
                    class="w-full border border-slate-200 rounded-2xl px-5 py-3 text-sm focus:ring-2 focus:ring-indigo-200 focus:outline-none"
                >
            </div>

            <button
                type="submit"
                class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-2xl text-sm font-medium transition">

                Buscar

            </button>

        </form>

    </div>

    {{-- ========================= --}}
    {{-- USUARIOS PENDIENTES --}}
    {{-- ========================= --}}
    <div>

        <div class="flex items-center justify-between mb-5">

            <div>
                <h2 class="text-xl font-bold text-slate-800">
                    Solicitudes Pendientes
                </h2>

                <p class="text-sm text-slate-400 mt-1">
                    Usuarios esperando aprobación
                </p>
            </div>

            <span class="bg-amber-100 text-amber-700 px-4 py-1 rounded-full text-xs font-semibold">
                {{ $pendientes->count() }} pendientes
            </span>

        </div>

        <div class="space-y-4">

            @forelse($pendientes as $user)

                <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6 flex flex-col xl:flex-row xl:items-center xl:justify-between gap-6">

                    {{-- INFO --}}
                    <div class="flex items-center gap-4">

                        <div class="w-14 h-14 rounded-2xl bg-amber-100 text-amber-700 flex items-center justify-center font-bold text-lg">
                            {{ strtoupper(substr($user->nombre, 0, 1)) }}
                        </div>

                        <div>

                            <h3 class="font-semibold text-slate-800 text-lg">
                                {{ $user->nombre }} {{ $user->apellido }}
                            </h3>

                            <p class="text-sm text-slate-500 mt-1">
                                {{ $user->email }}
                            </p>

                            <p class="text-xs text-slate-400 mt-1">
                                Usuario: {{ $user->username }}
                            </p>

                        </div>

                    </div>

                    {{-- ACCIONES --}}
                    <div class="flex flex-col md:flex-row gap-3">

                        {{-- APROBAR --}}
                        <form
                            method="POST"
                            action="{{ route('usuarios.aprobar', $user) }}"
                            class="flex flex-col md:flex-row gap-3">

                            @csrf
                            @method('PUT')

                            <select
                                name="rol_id"
                                class="border border-slate-200 rounded-2xl px-4 py-3 text-sm focus:ring-2 focus:ring-indigo-200 focus:outline-none">

                                @foreach($roles as $rol)

                                    @if($rol->nombre !== 'inactivo')

                                        <option value="{{ $rol->id }}">
                                            {{ ucfirst($rol->nombre) }}
                                        </option>

                                    @endif

                                @endforeach

                            </select>

                            <button
                                class="bg-emerald-500 hover:bg-emerald-600 text-white px-5 py-3 rounded-2xl text-sm font-medium transition">

                                Aprobar

                            </button>

                        </form>

                        {{-- BLOQUEAR --}}
                        <form
                            method="POST"
                            action="{{ route('usuarios.bloquear', $user) }}">

                            @csrf
                            @method('PUT')

                            <button
                                class="bg-rose-500 hover:bg-rose-600 text-white px-5 py-3 rounded-2xl text-sm font-medium transition">

                                Rechazar

                            </button>

                        </form>

                    </div>

                </div>

            @empty

                <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-10 text-center">

                    <p class="text-slate-400 text-sm">
                        No hay solicitudes pendientes.
                    </p>

                </div>

            @endforelse

        </div>

    </div>

    {{-- ========================= --}}
    {{-- USUARIOS ACTIVOS --}}
    {{-- ========================= --}}
    <div>

        <div class="flex items-center justify-between mb-5">

            <div>
                <h2 class="text-xl font-bold text-slate-800">
                    Usuarios Activos
                </h2>

                <p class="text-sm text-slate-400 mt-1">
                    Usuarios con acceso al sistema
                </p>
            </div>

            <span class="bg-emerald-100 text-emerald-700 px-4 py-1 rounded-full text-xs font-semibold">
                {{ $activos->count() }} activos
            </span>

        </div>

        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">

            <div class="overflow-x-auto">

                <table class="w-full text-sm">

                    <thead class="bg-slate-50 text-slate-500">
                        <tr>
                            <th class="text-left px-6 py-4">Usuario</th>
                            <th class="text-left px-6 py-4">Email</th>
                            <th class="text-left px-6 py-4">Rol</th>
                            <th class="text-left px-6 py-4">Acciones</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($activos as $user)

                            <tr class="border-t border-slate-100 hover:bg-slate-50 transition">

                                {{-- USUARIO --}}
                                <td class="px-6 py-5">

                                    <div class="flex items-center gap-4">

                                        <div class="w-12 h-12 rounded-2xl bg-indigo-100 text-indigo-600 flex items-center justify-center font-bold">
                                            {{ strtoupper(substr($user->nombre, 0, 1)) }}
                                        </div>

                                        <div>

                                            <p class="font-semibold text-slate-800">
                                                {{ $user->nombre }} {{ $user->apellido }}
                                            </p>

                                            <p class="text-xs text-slate-400 mt-1">
                                                {{ $user->username }}
                                            </p>

                                        </div>

                                    </div>

                                </td>

                                {{-- EMAIL --}}
                                <td class="px-6 py-5 text-slate-600">
                                    {{ $user->email }}
                                </td>

                                {{-- ROL --}}
                                <td class="px-6 py-5">

                                    <span class="px-3 py-1 rounded-full text-xs font-medium bg-indigo-50 text-indigo-600">
                                        {{ ucfirst($user->rol->nombre ?? 'Sin rol') }}
                                    </span>

                                </td>

                                {{-- ACCIONES --}}
                                <td class="px-6 py-5">

                                    <div class="flex flex-col xl:flex-row gap-3">

                                        {{-- CAMBIAR ROL --}}
                                        <form
                                            method="POST"
                                            action="{{ route('usuarios.rol', $user) }}"
                                            class="flex gap-2 items-center">

                                            @csrf
                                            @method('PUT')

                                            <select
                                                name="rol_id"
                                                class="border border-slate-200 rounded-xl px-3 py-2 text-xs focus:ring-2 focus:ring-indigo-200 focus:outline-none">

                                                @foreach($roles as $rol)

                                                    <option
                                                        value="{{ $rol->id }}"
                                                        {{ $user->rol_id == $rol->id ? 'selected' : '' }}>

                                                        {{ ucfirst($rol->nombre) }}

                                                    </option>

                                                @endforeach

                                            </select>

                                            <button
                                                class="bg-indigo-500 hover:bg-indigo-600 text-white text-xs px-4 py-2 rounded-xl transition">

                                                Guardar

                                            </button>

                                        </form>

                                        {{-- BLOQUEAR --}}
                                        <form
                                            method="POST"
                                            action="{{ route('usuarios.bloquear', $user) }}">

                                            @csrf
                                            @method('PUT')

                                            <button
                                                class="bg-rose-500 hover:bg-rose-600 text-white text-xs px-4 py-2 rounded-xl transition">

                                                Bloquear

                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="4" class="text-center py-10 text-slate-400">
                                    No hay usuarios activos.
                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

    {{-- ========================= --}}
    {{-- USUARIOS BLOQUEADOS --}}
    {{-- ========================= --}}
    <div>

        <div class="flex items-center justify-between mb-5">

            <div>
                <h2 class="text-xl font-bold text-slate-800">
                    Usuarios Bloqueados
                </h2>

                <p class="text-sm text-slate-400 mt-1">
                    Usuarios sin acceso al sistema
                </p>
            </div>

            <span class="bg-rose-100 text-rose-700 px-4 py-1 rounded-full text-xs font-semibold">
                {{ $bloqueados->count() }} bloqueados
            </span>

        </div>

        <div class="space-y-4">

            @forelse($bloqueados as $user)

                <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6 flex flex-col xl:flex-row xl:items-center xl:justify-between gap-6">

                    {{-- INFO --}}
                    <div class="flex items-center gap-4">

                        <div class="w-14 h-14 rounded-2xl bg-rose-100 text-rose-700 flex items-center justify-center font-bold text-lg">
                            {{ strtoupper(substr($user->nombre, 0, 1)) }}
                        </div>

                        <div>

                            <h3 class="font-semibold text-slate-800 text-lg">
                                {{ $user->nombre }} {{ $user->apellido }}
                            </h3>

                            <p class="text-sm text-slate-500 mt-1">
                                {{ $user->email }}
                            </p>

                            <p class="text-xs text-slate-400 mt-1">
                                Usuario: {{ $user->username }}
                            </p>

                        </div>

                    </div>

                    {{-- REACTIVAR --}}
                    <form
                        method="POST"
                        action="{{ route('usuarios.reactivar', $user) }}">

                        @csrf
                        @method('PUT')

                        <button
                            class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-3 rounded-2xl text-sm font-medium transition">

                            Reactivar Usuario

                        </button>

                    </form>

                </div>

            @empty

                <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-10 text-center">

                    <p class="text-slate-400 text-sm">
                        No hay usuarios bloqueados.
                    </p>

                </div>

            @endforelse

        </div>

    </div>

</div>

@endsection
