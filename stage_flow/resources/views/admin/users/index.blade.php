@extends('layouts.admin')
@section('title', 'Gestion des Utilisateurs - StageFlow')
@section('breadcrumb', 'Utilisateurs')

@section('content')

<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8" data-aos="fade-down"
     x-data="{ search: '', role: '' }"
     @users-filter-changed.window="search = $event.detail.search; role = $event.detail.role">
    <div>
        <h1 class="text-3xl font-extrabold text-gray-900 font-heading">Gestion des <span class="text-indigo-600">Utilisateurs</span></h1>
        <p class="text-sm text-gray-500 mt-1">Gérez les accès et les rôles de la plateforme en temps réel.</p>
    </div>
    <div>
        <a :href="'{{ route('admin.users.export') }}?' + new URLSearchParams({
            search: search,
            role: role
        }).toString()" 
           class="py-2.5 px-4 inline-flex items-center gap-x-2 text-xs font-bold rounded-xl border border-gray-200 bg-white text-gray-700 shadow-sm hover:bg-gray-50 hover:text-emerald-600 transition active:scale-95">
            <svg class="shrink-0 size-4 text-emerald-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m.75 12 3 3m0 0 3-3m-3 3v-6m-1.5-9H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" /></svg>
            Exporter (Excel)
        </a>
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
