@extends('backend.layouts.back')

@section('header', isset($localidad) ? 'Editar Localidad' : 'Nueva Localidad')

@section('content')
<div class="max-w-2xl mx-auto">
    <a href="{{ route('localidades.index') }}" class="inline-flex items-center text-sm text-slate-500 hover:text-emerald-600 mb-6 transition-colors">
        <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i>
        Volver al listado
    </a>

    <div class="bg-white rounded-3xl border border-slate-200 shadow-xl shadow-slate-200/50 overflow-hidden">
        <div class="bg-gradient-to-r from-sky-50 to-emerald-50 px-8 py-6 border-b border-slate-100">
            <h2 class="text-xl font-bold text-slate-800">
                {{ isset($localidad) ? 'Modificar Localidad' : 'Registrar Localidad' }}
            </h2>
            <p class="text-sm text-slate-500 mt-1">Vincula la ciudad a una provincia y asigna su código postal.</p>
        </div>

        <form method="POST" 
              action="{{ isset($localidad) ? route('localidades.update', $localidad->id) : route('localidades.store') }}"
              class="p-8 space-y-5">
            @csrf
            @if(isset($localidad)) @method('PUT') @endif

            <div class="space-y-2">
                <label class="text-sm font-bold text-slate-700 ml-1">Nombre de la Localidad</label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i data-lucide="map" class="w-5 h-5 text-slate-400 group-focus-within:text-emerald-500 transition-colors"></i>
                    </div>
                    <input type="text" name="nombre" value="{{ $localidad->nombre ?? '' }}" 
                           class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl focus:bg-white focus:border-emerald-400 focus:ring-4 focus:ring-emerald-500/10 transition-all outline-none"
                           placeholder="Ej: San Nicolás" required>
                </div>
            </div>

            <div class="space-y-2">
                <label class="text-sm font-bold text-slate-700 ml-1">Código Postal</label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i data-lucide="hash" class="w-5 h-5 text-slate-400 group-focus-within:text-emerald-500 transition-colors"></i>
                    </div>
                    <input type="number" name="codigo_postal" value="{{ $localidad->codigo_postal ?? '' }}" 
                           class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl focus:bg-white focus:border-emerald-400 focus:ring-4 focus:ring-emerald-500/10 transition-all outline-none"
                           placeholder="Ej: 2900" required>
                </div>
            </div>

            <div class="space-y-2">
                <label class="text-sm font-bold text-slate-700 ml-1">Provincia</label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i data-lucide="navigation-2" class="w-5 h-5 text-slate-400 group-focus-within:text-emerald-500 transition-colors"></i>
                    </div>
                    <select name="provincia_id" 
                            class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl focus:bg-white focus:border-emerald-400 focus:ring-4 focus:ring-emerald-500/10 transition-all outline-none appearance-none cursor-pointer">
                        @foreach($provincias as $prov)
                            <option value="{{ $prov->id }}"
                                {{ (isset($localidad) && $localidad->provincia_id == $prov->id) ? 'selected' : '' }}>
                                {{ $prov->nombre }}
                            </option>
                        @endforeach
                    </select>
                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                        <i data-lucide="chevron-down" class="w-4 h-4 text-slate-400"></i>
                    </div>
                </div>
            </div>

            <div class="pt-6 flex items-center gap-3">
                <button type="submit" 
                        class="flex-1 bg-emerald-500 hover:bg-emerald-600 text-white font-bold py-3.5 px-6 rounded-2xl shadow-lg shadow-emerald-200 transition-all active:scale-[0.98]">
                    {{ isset($localidad) ? 'Actualizar Localidad' : 'Guardar Localidad' }}
                </button>
                <a href="{{ route('localidades.index') }}" 
                   class="px-8 py-3.5 bg-slate-100 hover:bg-slate-200 text-slate-600 font-semibold rounded-2xl transition-all">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection