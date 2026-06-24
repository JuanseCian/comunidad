@extends('backend.layouts.back')

@section('title', 'Home Dashboard')
@section('header', 'Dashboard')

@section('content')

<div class="mb-12 transition-all duration-500 ease-in-out">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6">
        <div>
            <h1 class="text-3xl font-bold text-slate-800 tracking-tight sm:text-4xl">
                Bienvenido/a, <span class="text-sky-primary">{{ auth()->user()->nombre }}</span>
            </h1>
            <p class="text-base font-medium text-slate-400 mt-2">
                Seleccione el módulo o parámetro que desea gestionar en la plataforma.
            </p>
        </div>
        
        <div class="inline-flex items-center gap-2.5 bg-white border border-slate-200 text-slate-600 px-4 py-2 rounded-full text-sm font-medium self-start sm:self-center shadow-sm">
            <span class="w-2 h-2 bg-teal-primary rounded-full tracking-wide"></span>
            Sistema en Línea
        </div>
    </div>
</div>

<hr class="border-slate-200/60 mb-10">

{{-- GRILLA AMPLIA CON COLLAPSE E INTERACCIONES FLUIDAS --}}
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" x-data="{ activeSection: null }">

    {{-- USUARIOS (ACCESO DIRECTO) --}}
    <a href="{{ route('usuarios.index') }}" 
       class="group bg-white rounded-2xl border border-slate-200/80 p-7 flex flex-col justify-between hover:border-sky-primary hover:shadow-md transition-all duration-300 ease-out min-h-[140px]">
        <div class="flex items-start gap-5">
            <div class="w-12 h-12 rounded-xl bg-slate-50 flex items-center justify-center text-slate-500 group-hover:bg-sky-50 group-hover:text-sky-primary transition-all duration-300">
                <i data-lucide="users" class="w-5 h-5"></i>
            </div>
            <div>
                <h3 class="font-bold text-slate-800 text-lg group-hover:text-sky-primary transition-colors duration-200">Usuarios</h3>
                <p class="text-sm text-slate-400 mt-1 leading-relaxed">Cuentas, permisos y accesos generales.</p>
            </div>
        </div>
        <div class="flex items-center justify-end mt-4 text-sm font-semibold text-sky-primary opacity-0 group-hover:opacity-100 group-hover:translate-x-1 transition-all duration-300 gap-1.5">
            Acceder <i data-lucide="arrow-right" class="w-4 h-4"></i>
        </div>
    </a>

    {{-- GEOGRAFÍA TERRITORIAL (COLLAPSE) --}}
    <div class="bg-white rounded-2xl border border-slate-200/80 p-7 hover:shadow-md transition-all duration-300 ease-out flex flex-col justify-start min-h-[140px]"
         :class="activeSection === 'geografia' ? 'border-sky-primary shadow-sm' : ''">
        <button @click="activeSection = (activeSection === 'geografia' ? null : 'geografia')" 
                class="w-full flex items-start justify-between text-left group">
            <div class="flex items-start gap-5">
                <div class="w-12 h-12 rounded-xl bg-slate-50 flex items-center justify-center text-slate-500 transition-all duration-300"
                     :class="activeSection === 'geografia' ? 'bg-sky-50 text-sky-primary' : ''">
                    <i data-lucide="map-pin" class="w-5 h-5"></i>
                </div>
                <div>
                    <h3 class="font-bold text-slate-800 text-lg transition-colors duration-200"
                        :class="activeSection === 'geografia' ? 'text-sky-primary' : ''">Geografía Territorial</h3>
                    <p class="text-sm text-slate-400 mt-1 leading-relaxed">Provincias, localidades y división de barrios.</p>
                </div>
            </div>
            <i data-lucide="chevron-down" class="w-5 h-5 text-slate-400 transition-transform duration-300 mt-1 flex-shrink-0"
               :class="activeSection === 'geografia' ? 'rotate-180 text-sky-primary' : ''"></i>
        </button>
        
        <div x-show="activeSection === 'geografia'" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 transform -translate-y-2"
             x-transition:enter-end="opacity-100 transform translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 transform translate-y-0"
             x-transition:leave-end="opacity-0 transform -translate-y-2">
            <div class="grid grid-cols-2 gap-2.5 mt-6 pt-5 border-t border-slate-100">
                <a href="{{ route('provincias.index') }}" class="text-sm font-semibold text-slate-600 hover:text-sky-primary px-3 py-2.5 rounded-xl hover:bg-slate-50 transition-colors duration-150">Provincias</a>
                <a href="{{ route('localidades.index') }}" class="text-sm font-semibold text-slate-600 hover:text-sky-primary px-3 py-2.5 rounded-xl hover:bg-slate-50 transition-colors duration-150">Localidades</a>
                <a href="{{ route('zonas-barrios.index') }}" class="text-sm font-semibold text-slate-600 hover:text-sky-primary px-3 py-2.5 rounded-xl hover:bg-slate-50 transition-colors duration-150">Zonas</a>
                <a href="{{ route('barrios.index') }}" class="text-sm font-semibold text-slate-600 hover:text-sky-primary px-3 py-2.5 rounded-xl hover:bg-slate-50 transition-colors duration-150">Barrios</a>
            </div>
        </div>
    </div>

    {{-- SALUD Y COBERTURA (COLLAPSE) --}}
    <div class="bg-white rounded-2xl border border-slate-200/80 p-7 hover:shadow-md transition-all duration-300 ease-out flex flex-col justify-start min-h-[140px]"
         :class="activeSection === 'salud' ? 'border-sky-primary shadow-sm' : ''">
        <button @click="activeSection = (activeSection === 'salud' ? null : 'salud')" 
                class="w-full flex items-start justify-between text-left group">
            <div class="flex items-start gap-5">
                <div class="w-12 h-12 rounded-xl bg-slate-50 flex items-center justify-center text-slate-500 transition-all duration-300"
                     :class="activeSection === 'salud' ? 'bg-sky-50 text-sky-primary' : ''">
                    <i data-lucide="heart-pulse" class="w-5 h-5"></i>
                </div>
                <div>
                    <h3 class="font-bold text-slate-800 text-lg transition-colors duration-200"
                        :class="activeSection === 'salud' ? 'text-sky-primary' : ''">Salud y Cobertura</h3>
                    <p class="text-sm text-slate-400 mt-1 leading-relaxed">Registro de enfermedades y prestaciones.</p>
                </div>
            </div>
            <i data-lucide="chevron-down" class="w-5 h-5 text-slate-400 transition-transform duration-300 mt-1 flex-shrink-0"
               :class="activeSection === 'salud' ? 'rotate-180 text-sky-primary' : ''"></i>
        </button>
        
        <div x-show="activeSection === 'salud'" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 transform -translate-y-2"
             x-transition:enter-end="opacity-100 transform translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 transform translate-y-0"
             x-transition:leave-end="opacity-0 transform -translate-y-2">
            <div class="flex flex-col gap-1 mt-6 pt-5 border-t border-slate-100">
                <a href="{{ route('enfermedades.index') }}" class="text-sm font-semibold text-slate-600 hover:text-sky-primary px-3 py-2.5 rounded-xl hover:bg-slate-50 transition-colors duration-150">Enfermedades</a>
                <a href="{{ route('discapacidades.index') }}" class="text-sm font-semibold text-slate-600 hover:text-sky-primary px-3 py-2.5 rounded-xl hover:bg-slate-50 transition-colors duration-150">Discapacidades</a>
                <a href="{{ route('coberturas.index') }}" class="text-sm font-semibold text-slate-600 hover:text-sky-primary px-3 py-2.5 rounded-xl hover:bg-slate-50 transition-colors duration-150">Cobertura Médica</a>
            </div>
        </div>
    </div>

    {{-- SOCIAL Y EDUCACIÓN (COLLAPSE) --}}
    <div class="bg-white rounded-2xl border border-slate-200/80 p-7 hover:shadow-md transition-all duration-300 ease-out flex flex-col justify-start min-h-[140px]"
         :class="activeSection === 'social' ? 'border-sky-primary shadow-sm' : ''">
        <button @click="activeSection = (activeSection === 'social' ? null : 'social')" 
                class="w-full flex items-start justify-between text-left group">
            <div class="flex items-start gap-5">
                <div class="w-12 h-12 rounded-xl bg-slate-50 flex items-center justify-center text-slate-500 transition-all duration-300"
                     :class="activeSection === 'social' ? 'bg-sky-50 text-sky-primary' : ''">
                    <i data-lucide="graduation-cap" class="w-5 h-5"></i>
                </div>
                <div>
                    <h3 class="font-bold text-slate-800 text-lg transition-colors duration-200"
                        :class="activeSection === 'social' ? 'text-sky-primary' : ''">Social y Educación</h3>
                    <p class="text-sm text-slate-400 mt-1 leading-relaxed">Niveles académicos e indicadores civiles.</p>
                </div>
            </div>
            <i data-lucide="chevron-down" class="w-5 h-5 text-slate-400 transition-transform duration-300 mt-1 flex-shrink-0"
               :class="activeSection === 'social' ? 'rotate-180 text-sky-primary' : ''"></i>
        </button>
        
        <div x-show="activeSection === 'social'" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 transform -translate-y-2"
             x-transition:enter-end="opacity-100 transform translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 transform translate-y-0"
             x-transition:leave-end="opacity-0 transform -translate-y-2">
            <div class="flex flex-col gap-1 mt-6 pt-5 border-t border-slate-100">
                <a href="{{ route('niveles-estudio.index') }}" class="text-sm font-semibold text-slate-600 hover:text-sky-primary px-3 py-2.5 rounded-xl hover:bg-slate-50 transition-colors duration-150">Niveles de Estudio</a>
                <a href="{{ route('estados-civiles.index') }}" class="text-sm font-semibold text-slate-600 hover:text-sky-primary px-3 py-2.5 rounded-xl hover:bg-slate-50 transition-colors duration-150">Estado Civil</a>
            </div>
        </div>
    </div>

    {{-- LABORAL Y AYUDA (COLLAPSE) --}}
    <div class="bg-white rounded-2xl border border-slate-200/80 p-7 hover:shadow-md transition-all duration-300 ease-out flex flex-col justify-start min-h-[140px]"
         :class="activeSection === 'laboral' ? 'border-sky-primary shadow-sm' : ''">
        <button @click="activeSection = (activeSection === 'laboral' ? null : 'laboral')" 
                class="w-full flex items-start justify-between text-left group">
            <div class="flex items-start gap-5">
                <div class="w-12 h-12 rounded-xl bg-slate-50 flex items-center justify-center text-slate-500 transition-all duration-300"
                     :class="activeSection === 'laboral' ? 'bg-sky-50 text-sky-primary' : ''">
                    <i data-lucide="briefcase" class="w-5 h-5"></i>
                </div>
                <div>
                    <h3 class="font-bold text-slate-800 text-lg transition-colors duration-200"
                        :class="activeSection === 'laboral' ? 'text-sky-primary' : ''">Laboral y Ayuda</h3>
                    <p class="text-sm text-slate-400 mt-1 leading-relaxed">Situación de empleo y asistencia social.</p>
                </div>
            </div>
            <i data-lucide="chevron-down" class="w-5 h-5 text-slate-400 transition-transform duration-300 mt-1 flex-shrink-0"
               :class="activeSection === 'laboral' ? 'rotate-180 text-sky-primary' : ''"></i>
        </button>
        
        <div x-show="activeSection === 'laboral'" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 transform -translate-y-2"
             x-transition:enter-end="opacity-100 transform translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 transform translate-y-0"
             x-transition:leave-end="opacity-0 transform -translate-y-2">
            <div class="grid grid-cols-2 gap-2.5 mt-6 pt-5 border-t border-slate-100">
                <a href="{{ route('categorias.index') }}" class="text-sm font-semibold text-slate-600 hover:text-sky-primary px-3 py-2.5 rounded-xl hover:bg-slate-50 transition-colors duration-150">Categorías</a>
                <a href="{{ route('condiciones-inactividad.index') }}" class="text-sm font-semibold text-slate-600 hover:text-sky-primary px-3 py-2.5 rounded-xl hover:bg-slate-50 transition-colors duration-150">Inactividad</a>
                <a href="{{ route('programas-asistencia.index') }}" class="text-sm font-semibold text-slate-600 hover:text-sky-primary px-3 py-2.5 rounded-xl hover:bg-slate-50 transition-colors duration-150">Programas</a>
                <a href="{{ route('beneficios.index') }}" class="text-sm font-semibold text-slate-600 hover:text-sky-primary px-3 py-2.5 rounded-xl hover:bg-slate-50 transition-colors duration-150">Beneficios</a>
            </div>
        </div>
    </div>

</div>

@endsection