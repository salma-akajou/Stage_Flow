@extends('layouts.admin')
@section('title', 'Gestion des Utilisateurs - StageFlow')
@section('breadcrumb', 'Utilisateurs')

@section('content')

<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8" data-aos="fade-down">
    <div>
        <h1 class="text-3xl font-extrabold text-gray-900 font-heading">Gestion des <span class="text-indigo-600">Utilisateurs</span></h1>
        <p class="text-sm text-gray-500 mt-1">Gérez les accès et les rôles de la plateforme en temps réel.</p>
    </div>
</div>

@if (session('success'))
    <div class="bg-emerald-50 border border-emerald-200 text-emerald-600 rounded-2xl p-4 mb-8 flex items-center gap-3 text-sm font-bold shadow-sm" role="alert" data-aos="fade-left">
        <div class="size-8 rounded-full bg-emerald-100 flex items-center justify-center">
            <svg class="size-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        {{ session('success') }}
    </div>
@endif

<!-- Filtres séparés -->
<div class="relative z-20">
    @include('components.admin.users.filters')
</div>

<!-- Conteneur pour le tableau (mis à jour par AJAX) -->
<div id="users-table-container" class="relative z-10">
    @include('components.admin.users.table', ['users' => $users])
</div>

@endsection

