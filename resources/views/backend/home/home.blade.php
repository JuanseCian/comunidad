@extends('backend.layouts.back')

@section('title', 'Home Dashboard')
@section('header', 'Dashboard')

@section('content')

{{-- SECCIÓN DE BIENVENIDA CON ANIMACIÓN --}}
<div class="mb-10 animate-fade-in-down">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight sm:text-4xl">
                Bienvenido de nuevo, <span class="bg-gradient-to-r from-indigo-500 to-purple-600 bg-clip-text text-transparent">Admin</span> 👋
            </h1>
            <p class="text-sm font-medium text-slate-500 mt-2 flex items-center gap-1.5">
                <i data-lucide="sparkles" class="w-4 h-4 text-amber-500 animate-pulse"></i>
                ¿Qué panel o parámetro querés gestionar hoy en la plataforma?
            </p>
        </div>
        
        {{-- Indicador de estado rápido --}}
        <div class="inline-flex items-center gap-2 bg-emerald-50 border border-emerald-100 text-emerald-700 px-4 py-2 rounded-2xl text-xs font-semibold self-start md:self-center shadow-sm">
            <span class="w-2 px-0 h-2 bg-emerald-500 rounded-full animate-ping"></span>
            Sistema en Línea
        </div>
    </div>
</div>

<hr class="border-slate-100 mb-8">

{{-- GRILLA DE SECCIONES INTERACTIVAS --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

    {{-- USUARIOS --}}
    <a href="{{ route('usuarios.index') }}" 
       class="group relative bg-white rounded-2xl border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-1 hover:border-indigo-300 transition-all duration-300 p-6 flex flex-col justify-between overflow-hidden">
        <div class="absolute top-0 right-0 w-24 h-24 bg-indigo-50/30 rounded-bl-full translate-x-6 -translate-y-6 group-hover:scale-110 transition-transform duration-300"></div>
        
        <div class="flex items-start gap-4 relative z-10">
            <div class="w-12 h-12 rounded-xl bg-indigo-50 flex items-center justify-center flex-shrink-0 group-hover:bg-indigo-500 group-hover:text-white transition-all duration-300 shadow-sm group-hover:shadow-indigo-200 group-hover:shadow-lg">
                <i data-lucide="users" class="w-5 h-5 text-indigo-600 group-hover:text-white transition-colors duration-300"></i>
            </div>
            <div>
                <p class="font-bold text-slate-800 text-base group-hover:text-indigo-600 transition-colors">Usuarios</p>
                <p class="text-xs text-slate-400 mt-1.5 leading-relaxed">Administrá, editá y controlá los roles y accesos de los usuarios generales del sistema.</p>
            </div>
        </div>
        <div class="mt-6 flex items-center justify-end text-xs font-semibold text-indigo-600 opacity-0 group-hover:opacity-100 group-hover:translate-x-1 transition-all duration-300 gap-1">
            Gestionar <i data-lucide="arrow-right" class="w-4 h-4"></i>
        </div>
    </a>

    {{-- GEOGRAFÍA --}}
    <a href="{{ route('provincias.index') }}" 
       class="group relative bg-white rounded-2xl border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-1 hover:border-emerald-300 transition-all duration-300 p-6 flex flex-col justify-between overflow-hidden">
        <div class="absolute top-0 right-0 w-24 h-24 bg-emerald-50/30 rounded-bl-full translate-x-6 -translate-y-6 group-hover:scale-110 transition-transform duration-300"></div>
        
        <div class="flex items-start gap-4 relative z-10">
            <div class="w-12 h-12 rounded-xl bg-emerald-50 flex items-center justify-center flex-shrink-0 group-hover:bg-emerald-500 group-hover:text-white transition-all duration-300 shadow-sm group-hover:shadow-emerald-200 group-hover:shadow-lg">
                <i data-lucide="map-pin" class="w-5 h-5 text-emerald-600 group-hover:text-white transition-colors duration-300"></i>
            </div>
            <div>
                <p class="font-bold text-slate-800 text-base group-hover:text-emerald-600 transition-colors">Geografía Territorial</p>
                <p class="text-xs text-slate-400 mt-1.5 leading-relaxed">Configuración analítica de provincias, localidades, zonas específicas y barrios periféricos.</p>
            </div>
        </div>
        <div class="mt-6 flex items-center justify-end text-xs font-semibold text-emerald-600 opacity-0 group-hover:opacity-100 group-hover:translate-x-1 transition-all duration-300 gap-1">
            Gestionar <i data-lucide="arrow-right" class="w-4 h-4"></i>
        </div>
    </a>

    {{-- SALUD Y COBERTURA --}}
    <a href="{{ route('enfermedades.index') }}" 
       class="group relative bg-white rounded-2xl border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-1 hover:border-rose-300 transition-all duration-300 p-6 flex flex-col justify-between overflow-hidden">
        <div class="absolute top-0 right-0 w-24 h-24 bg-rose-50/30 rounded-bl-full translate-x-6 -translate-y-6 group-hover:scale-110 transition-transform duration-300"></div>
        
        <div class="flex items-start gap-4 relative z-10">
            <div class="w-12 h-12 rounded-xl bg-rose-50 flex items-center justify-center flex-shrink-0 group-hover:bg-rose-500 group-hover:text-white transition-all duration-300 shadow-sm group-hover:shadow-rose-200 group-hover:shadow-lg">
                <i data-lucide="heart-pulse" class="w-5 h-5 text-rose-500 group-hover:text-white transition-colors duration-300"></i>
            </div>
            <div>
                <p class="font-bold text-slate-800 text-base group-hover:text-rose-600 transition-colors">Salud y Cobertura</p>
                <p class="text-xs text-slate-400 mt-1.5 leading-relaxed">Catálogo clínico: enfermedades crónicas, niveles de discapacidad y obras sociales disponibles.</p>
            </div>
        </div>
        <div class="mt-6 flex items-center justify-end text-xs font-semibold text-rose-600 opacity-0 group-hover:opacity-100 group-hover:translate-x-1 transition-all duration-300 gap-1">
            Gestionar <i data-lucide="arrow-right" class="w-4 h-4"></i>
        </div>
    </a>

    {{-- SOCIAL Y EDUCACIÓN --}}
    <a href="{{ route('niveles-estudio.index') }}" 
       class="group relative bg-white rounded-2xl border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-1 hover:border-amber-300 transition-all duration-300 p-6 flex flex-col justify-between overflow-hidden">
        <div class="absolute top-0 right-0 w-24 h-24 bg-amber-50/30 rounded-bl-full translate-x-6 -translate-y-6 group-hover:scale-110 transition-transform duration-300"></div>
        
        <div class="flex items-start gap-4 relative z-10">
            <div class="w-12 h-12 rounded-xl bg-amber-50 flex items-center justify-center flex-shrink-0 group-hover:bg-amber-500 group-hover:text-white transition-all duration-300 shadow-sm group-hover:shadow-amber-200 group-hover:shadow-lg">
                <i data-lucide="graduation-cap" class="w-5 h-5 text-amber-600 group-hover:text-white transition-colors duration-300"></i>
            </div>
            <div>
                <p class="font-bold text-slate-800 text-base group-hover:text-amber-600 transition-colors">Social y Educación</p>
                <p class="text-xs text-slate-400 mt-1.5 leading-relaxed">Parámetros demográficos, niveles educativos alcanzados y estados civiles declarados.</p>
            </div>
        </div>
        <div class="mt-6 flex items-center justify-end text-xs font-semibold text-amber-600 opacity-0 group-hover:opacity-100 group-hover:translate-x-1 transition-all duration-300 gap-1">
            Gestionar <i data-lucide="arrow-right" class="w-4 h-4"></i>
        </div>
    </a>

    {{-- LABORAL Y AYUDA --}}
    <a href="{{ route('categorias.index') }}" 
       class="group relative bg-white rounded-2xl border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-1 hover:border-sky-300 transition-all duration-300 p-6 flex flex-col justify-between overflow-hidden">
        <div class="absolute top-0 right-0 w-24 h-24 bg-sky-50/30 rounded-bl-full translate-x-6 -translate-y-6 group-hover:scale-110 transition-transform duration-300"></div>
        
        <div class="flex items-start gap-4 relative z-10">
            <div class="w-12 h-12 rounded-xl bg-sky-50 flex items-center justify-center flex-shrink-0 group-hover:bg-sky-500 group-hover:text-white transition-all duration-300 shadow-sm group-hover:shadow-sky-200 group-hover:shadow-lg">
                <i data-lucide="briefcase" class="w-5 h-5 text-sky-600 group-hover:text-white transition-colors duration-300"></i>
            </div>
            <div>
                <p class="font-bold text-slate-800 text-base group-hover:text-sky-600 transition-colors">Laboral y Ayuda Social</p>
                <p class="text-xs text-slate-400 mt-1.5 leading-relaxed">Variables de ocupación, condiciones de inactividad, programas públicos y asignación de beneficios.</p>
            </div>
        </div>
        <div class="mt-6 flex items-center justify-end text-xs font-semibold text-sky-600 opacity-0 group-hover:opacity-100 group-hover:translate-x-1 transition-all duration-300 gap-1">
            Gestionar <i data-lucide="arrow-right" class="w-4 h-4"></i>
        </div>
    </a>

</div>

@endsection