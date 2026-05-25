@extends('layouts.entreprise')

@section('title', 'Candidatures Reçues - StageFlow')

@section('content')
<div class="relative min-h-screen space-y-10" x-data="candidatureManager('{{ route("entreprise.candidatures.index") }}', {{ $candidatures->total() }})" x-init="initPagination()">
    <div class="fixed inset-0 pointer-events-none overflow-hidden z-[-1] opacity-[0.06]">
        <div class="absolute top-20 left-10 animate-bounce duration-[10s]">
            <svg class="size-64 text-indigo-200" fill="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/></svg>
        </div>
        <div class="absolute bottom-20 right-20 animate-pulse duration-[8s]">
            <svg class="size-80 text-blue-100" fill="currentColor" viewBox="0 0 24 24"><rect width="20" height="20" x="2" y="2" rx="5"/></svg>
        </div>
        <div class="absolute top-1/2 left-1/4 animate-spin duration-[20s]">
            <svg class="size-48 text-indigo-50" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5z"/></svg>
        </div>
    </div>

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4" data-aos="fade-down">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900">Candidatures <span class="text-indigo-600">Récentes</span></h1>
            <p class="text-sm text-gray-500 mt-1 font-medium">Analysez les profils et sélectionnez vos futurs stagiaires</p>
        </div>
        <div class="flex items-center gap-2 text-xs font-bold bg-white border border-gray-200 px-4 py-2 rounded-xl shadow-sm">
            <span class="size-2 bg-indigo-500 rounded-full animate-pulse"></span>
            Total : <span x-text="totalCount">{{ $candidatures->total() }}</span> candidatures
        </div>
    </div>

    @include('components.entreprise.candidatures.filters')

    <div id="table-content" class="relative mt-10" data-aos="fade-up" data-aos-delay="100">
        @include('components.entreprise.candidatures.table')
    </div>

    @push('modals')
        @include('components.entreprise.candidatures.detail-candidature-modal')
    @endpush
</div>

@endsection
