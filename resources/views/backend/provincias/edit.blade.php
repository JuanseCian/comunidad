@extends('backend.layouts.back')

@section('header', isset($provincia) ? 'Editar Provincia' : 'Nueva Provincia')

@section('content')
<div class="max-w-2xl mx-auto">
    <a href="{{ route('provincias.index') }}" class="inline-flex items-center text-sm text-slate-500 hover:text-emerald-600 mb-6 transition-colors">
        <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i>
        Volver al listado
    </a>

    <div class="bg-white rounded-3xl border border-slate-200 shadow-xl shadow-slate-200/50 overflow-hidden">
        <div class="bg-gradient-to-r from-sky-50 to-emerald-50 px-8 py-6 border-b border-slate-100">
            <h2 class="text-xl font-bold text-slate-800">
                {{ isset($provincia) ? 'Modificar Registro' : 'Crear Registro' }}
            </h2>
            <p class="text-sm text-slate-500 mt-1">Completa el campo para guardar la provincia.</p>
        </div>

        <form action="{{ isset($provincia) ? route('provincias.update', $provincia->id) : route('provincias.store') }}" 
              method="POST" 
              class="p-8 space-y-6">
            @csrf
            @if(isset($provincia)) @method('PUT') @endif

            <div class="space-y-2">
                <label for="nombre" class="text-sm font-bold text-slate-700 ml-1">Nombre de la Provincia</label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i data-lucide="map-pin" class="w-5 h-5 text-slate-400 group-focus-within:text-emerald-500 transition-colors"></i>
                    </div>
                    <input type="text" name="nombre" id="nombre"
                           class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-slate-700 font-medium focus:bg-white focus:border-emerald-400 focus:ring-4 focus:ring-emerald-500/10 transition-all outline-none placeholder:text-slate-400"
                           value="{{ $provincia->nombre ?? '' }}" 
                           placeholder="Ej: Buenos Aires" required>
                </div>
            </div>

            <div class="pt-4 flex items-center gap-3">
                <button type="submit" 
                        class="flex-1 bg-emerald-500 hover:bg-emerald-600 text-white font-bold py-3 px-6 rounded-2xl shadow-lg shadow-emerald-200 transition-all active:scale-[0.98]">
                    {{ isset($provincia) ? 'Actualizar Provincia' : 'Guardar Provincia' }}
                </button>
                <a href="{{ route('provincias.index') }}" 
                   class="px-6 py-3 bg-slate-100 hover:bg-slate-200 text-slate-600 font-semibold rounded-2xl transition-all">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection