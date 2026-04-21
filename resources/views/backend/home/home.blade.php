@extends('backend.layouts.back')

@section('title', 'Home Dashboard')
@section('header', 'Bienvenido al Sistema')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm">
        <div class="flex items-center justify-between">
            <h1>PANEL DE ADMIN</h1>
        </div>
    </div>
</div>
@endsection