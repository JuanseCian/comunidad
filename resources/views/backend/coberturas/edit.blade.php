@extends('backend.layouts.back')

@section('header', 'Editar Cobertura')

@section('content')
<div class="max-w-xl mx-auto">
    <a href="{{ route('coberturas.index') }}" class="inline-flex items-center text-sm text-slate-500 hover:text-emerald-600 mb-6 transition-colors">
        <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i>
        Volver al listado
    </a>

    <div class="bg-white rounded-3xl border border-slate-200 shadow-xl shadow-slate-200/50 overflow-hidden">
        <div class="bg-gradient-to-r from-sky-50 to-emerald-50 px-8 py-6 border-b border-slate-100">
            <div class="flex items-center gap-3 mb-1">
                <div class="p-2 bg-emerald-100 text-emerald-600 rounded-lg">
                    <i data-lucide="shield" class="w-5 h-5"></i>
                </div>
                <h2 class="text-xl font-bold text-slate-800">
                    Modificar Registro
                </h2>
            </div>
            <p class="text-sm text-slate-500 mt-2">
                Actualiza la información de la cobertura seleccionada.
            </p>
        </div>

        <form action="{{ route('coberturas.update', $cobertura->id) }}"
              method="POST"
              class="p-8 space-y-6">
            @csrf
            @method('PUT')

            <div class="space-y-2">
                <label for="nombre" class="text-sm font-bold text-slate-700 ml-1">
                    Nombre de la Cobertura
                </label>

                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i data-lucide="tag" class="w-5 h-5 text-slate-400 group-focus-within:text-emerald-500 transition-colors"></i>
                    </div>

                    <input
                        type="text"
                        name="nombre"
                        id="nombre"
                        value="{{ old('nombre', $cobertura->nombre) }}"
                        class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-slate-700 font-medium focus:bg-white focus:border-emerald-400 focus:ring-4 focus:ring-emerald-500/10 transition-all outline-none placeholder:text-slate-400"
                        placeholder="Ej: Obra Social"
                        required
                    >
                </div>

                @error('nombre')
                    <p class="text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-4 flex items-center gap-3">
                <button
                    type="submit"
                    class="flex-1 bg-amber-500 hover:bg-amber-600 text-white font-bold py-3.5 px-6 rounded-2xl shadow-lg shadow-amber-200 transition-all active:scale-[0.98]"
                >
                    Guardar Cambios
                </button>

                <a
                    href="{{ route('coberturas.index') }}"
                    class="px-6 py-3.5 bg-slate-100 hover:bg-slate-200 text-slate-600 font-semibold rounded-2xl transition-all"
                >
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection