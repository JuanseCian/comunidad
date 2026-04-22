@extends('backend.layouts.back')

@section('header', isset($barrio) ? 'Editar Barrio' : 'Nuevo Barrio')

@section('content')
<div class="max-w-2xl mx-auto">
    <a href="{{ route('barrios.index') }}" class="inline-flex items-center text-sm text-slate-500 hover:text-emerald-600 mb-6 transition-colors">
        <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i>
        Volver al listado
    </a>

    <div class="bg-white rounded-3xl border border-slate-200 shadow-xl shadow-slate-200/50 overflow-hidden">
        <div class="bg-gradient-to-r from-sky-50 to-emerald-50 px-8 py-6 border-b border-slate-100">
            <h2 class="text-xl font-bold text-slate-800">
                {{ isset($barrio) ? 'Modificar Registro' : 'Registrar Nuevo Barrio' }}
            </h2>
            <p class="text-sm text-slate-500 mt-1">Asocia el barrio a su respectiva localidad y zona geográfica.</p>
        </div>

        <form action="{{ isset($barrio) ? route('barrios.update', $barrio->id) : route('barrios.store') }}" 
              method="POST" 
              class="p-8 space-y-5">
            @csrf
            @if(isset($barrio)) @method('PUT') @endif

            <div class="space-y-2">
                <label for="nombre" class="text-sm font-bold text-slate-700 ml-1">Nombre del Barrio</label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i data-lucide="home" class="w-5 h-5 text-slate-400 group-focus-within:text-emerald-500 transition-colors"></i>
                    </div>
                    <input type="text" name="nombre" id="nombre"
                           class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-slate-700 font-medium focus:bg-white focus:border-emerald-400 focus:ring-4 focus:ring-emerald-500/10 transition-all outline-none"
                           value="{{ $barrio->nombre ?? '' }}" placeholder="Ej: Barrio Norte" required>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="space-y-2">
                    <label class="text-sm font-bold text-slate-700 ml-1">Localidad</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i data-lucide="map-pin" class="w-5 h-5 text-slate-400 group-focus-within:text-emerald-500 transition-colors"></i>
                        </div>
                        <select name="localidad_id" class="w-full pl-11 pr-10 py-3 bg-slate-50 border border-slate-200 rounded-2xl appearance-none focus:bg-white focus:border-emerald-400 focus:ring-4 focus:ring-emerald-500/10 transition-all outline-none cursor-pointer">
                            <option value="">Seleccionar</option>
                            @foreach($localidades as $loc)
                                <option value="{{ $loc->id }}" {{ (isset($barrio) && $barrio->localidad_id == $loc->id) ? 'selected' : '' }}>
                                    {{ $loc->nombre }}
                                </option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-slate-400">
                            <i data-lucide="chevron-down" class="w-4 h-4"></i>
                        </div>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-bold text-slate-700 ml-1">Zona</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i data-lucide="layers" class="w-5 h-5 text-slate-400 group-focus-within:text-emerald-500 transition-colors"></i>
                        </div>
                        <select name="zona_barrio_id" class="w-full pl-11 pr-10 py-3 bg-slate-50 border border-slate-200 rounded-2xl appearance-none focus:bg-white focus:border-emerald-400 focus:ring-4 focus:ring-emerald-500/10 transition-all outline-none cursor-pointer">
                            <option value="">Seleccionar</option>
                            @foreach($zonas as $zona)
                                <option value="{{ $zona->id }}" {{ (isset($barrio) && $barrio->zona_barrio_id == $zona->id) ? 'selected' : '' }}>
                                    {{ $zona->nombre }}
                                </option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-slate-400">
                            <i data-lucide="chevron-down" class="w-4 h-4"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="pt-6 flex items-center gap-3">
                <button type="submit" 
                        class="flex-1 bg-emerald-500 hover:bg-emerald-600 text-white font-bold py-3.5 px-6 rounded-2xl shadow-lg shadow-emerald-200 transition-all active:scale-[0.98]">
                    {{ isset($barrio) ? 'Actualizar Cambios' : 'Guardar Barrio' }}
                </button>
                <a href="{{ route('barrios.index') }}" 
                   class="px-8 py-3.5 bg-slate-100 hover:bg-slate-200 text-slate-600 font-semibold rounded-2xl transition-all">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection