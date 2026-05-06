@extends('backend.layouts.back')

@section('title', 'Home Dashboard')
@section('header', 'Dashboard')

@section('content')

<div class="mb-10">
    <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Bienvenido de nuevo 👋</h1>
    <p class="text-sm text-slate-400 mt-1">¿Qué querés gestionar hoy?</p>
</div>

{{-- Módulos --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">

    <a href="{{ route('usuarios.index') }}" class="group bg-white rounded-2xl border border-slate-100 shadow-sm hover:shadow-md hover:border-indigo-200 transition-all p-6 flex items-start gap-4">
        <div class="w-11 h-11 rounded-xl bg-indigo-50 flex items-center justify-center flex-shrink-0 group-hover:bg-indigo-100 transition-colors">
            <i data-lucide="users" class="w-5 h-5 text-indigo-500"></i>
        </div>
        <div>
            <p class="font-semibold text-slate-800 text-sm">Usuarios</p>
            <p class="text-xs text-slate-400 mt-0.5 leading-relaxed">Administrá los usuarios del sistema.</p>
        </div>
    </a>

    <a href="{{ route('provincias.index') }}" class="group bg-white rounded-2xl border border-slate-100 shadow-sm hover:shadow-md hover:border-emerald-200 transition-all p-6 flex items-start gap-4">
        <div class="w-11 h-11 rounded-xl bg-emerald-50 flex items-center justify-center flex-shrink-0 group-hover:bg-emerald-100 transition-colors">
            <i data-lucide="map-pin" class="w-5 h-5 text-emerald-500"></i>
        </div>
        <div>
            <p class="font-semibold text-slate-800 text-sm">Geografía</p>
            <p class="text-xs text-slate-400 mt-0.5 leading-relaxed">Provincias, localidades, zonas y barrios.</p>
        </div>
    </a>

    <a href="{{ route('enfermedades.index') }}" class="group bg-white rounded-2xl border border-slate-100 shadow-sm hover:shadow-md hover:border-rose-200 transition-all p-6 flex items-start gap-4">
        <div class="w-11 h-11 rounded-xl bg-rose-50 flex items-center justify-center flex-shrink-0 group-hover:bg-rose-100 transition-colors">
            <i data-lucide="heart-pulse" class="w-5 h-5 text-rose-400"></i>
        </div>
        <div>
            <p class="font-semibold text-slate-800 text-sm">Salud y Cobertura</p>
            <p class="text-xs text-slate-400 mt-0.5 leading-relaxed">Enfermedades, discapacidades y coberturas médicas.</p>
        </div>
    </a>

    <a href="{{ route('niveles-estudio.index') }}" class="group bg-white rounded-2xl border border-slate-100 shadow-sm hover:shadow-md hover:border-amber-200 transition-all p-6 flex items-start gap-4">
        <div class="w-11 h-11 rounded-xl bg-amber-50 flex items-center justify-center flex-shrink-0 group-hover:bg-amber-100 transition-colors">
            <i data-lucide="graduation-cap" class="w-5 h-5 text-amber-500"></i>
        </div>
        <div>
            <p class="font-semibold text-slate-800 text-sm">Social y Educación</p>
            <p class="text-xs text-slate-400 mt-0.5 leading-relaxed">Niveles de estudio y estados civiles.</p>
        </div>
    </a>

    <a href="{{ route('categorias.index') }}" class="group bg-white rounded-2xl border border-slate-100 shadow-sm hover:shadow-md hover:border-sky-200 transition-all p-6 flex items-start gap-4">
        <div class="w-11 h-11 rounded-xl bg-sky-50 flex items-center justify-center flex-shrink-0 group-hover:bg-sky-100 transition-colors">
            <i data-lucide="briefcase" class="w-5 h-5 text-sky-500"></i>
        </div>
        <div>
            <p class="font-semibold text-slate-800 text-sm">Laboral y Ayuda</p>
            <p class="text-xs text-slate-400 mt-0.5 leading-relaxed">Categorías, inactividad, programas y beneficios.</p>
        </div>
    </a>

</div>

@endsection