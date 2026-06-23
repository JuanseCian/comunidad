@extends('backend.layouts.back')

@section('header', 'Gestión de Enfermedades')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Enfermedades</h1>
            <p class="text-sm text-slate-500">Administra el catálogo de patologías y condiciones médicas.</p>
        </div>
        <a href="{{ route('enfermedades.create') }}" 
           class="inline-flex items-center justify-center px-5 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-semibold rounded-xl transition-all shadow-lg shadow-emerald-100 group">
            <i data-lucide="plus" class="w-4 h-4 mr-2 transition-transform group-hover:rotate-90"></i>
            Nueva Enfermedad
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gradient-to-r from-sky-50/50 to-emerald-50/50 border-b border-slate-100">
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500 w-24">ID</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500">Nombre de la Patología</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-400 text-right w-32">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($enfermedades as $e)
                    <tr class="hover:bg-slate-50/50 transition-colors group">
                        <td class="px-6 py-4 text-sm font-medium text-slate-400">#{{ $e->id }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-sky-50 text-sky-600 rounded-lg border border-sky-100">
                                    <i data-lucide="heart-pulse" class="w-4 h-4"></i>
                                </div>
                                <span class="text-sm font-semibold text-slate-700">{{ $e->nombre }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('enfermedades.edit', $e->id) }}" 
                                   class="p-2 text-slate-400 hover:text-sky-600 hover:bg-sky-50 rounded-lg transition-all"
                                   title="Editar">
                                    <i data-lucide="edit-3" class="w-4 h-4"></i>
                                </a>

                                <form action="{{ route('enfermedades.destroy', $e->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button"
                                            onclick="confirmDelete(this.form, 'enfermedad', '{{ $e->nombre }}')"
                                            class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection