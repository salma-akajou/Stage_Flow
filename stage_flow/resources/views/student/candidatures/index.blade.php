@extends('layouts.student')

@section('title', 'Mes Candidatures - StageFlow')
@section('breadcrumb', 'Mes Candidatures')

@section('content')
<div class="space-y-8">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4" data-aos="fade-down">
        <div>
            <h2 class="text-2xl sm:text-3xl font-black text-gray-800 font-heading">Mes Candidatures</h2>
            <p class="mt-2 text-sm text-gray-600">Suivez l'état d'avancement de vos demandes de stage en temps réel.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl p-4 shadow-sm flex items-center gap-3" data-aos="fade-right">
            <div class="size-10 bg-emerald-500 text-white rounded-xl flex items-center justify-center shrink-0 shadow-lg shadow-emerald-100">
                <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path d="M5 13l4 4L19 7"/></svg>
            </div>
            <div>
                <p class="font-black text-sm uppercase tracking-wider">Succès !</p>
                <p class="text-xs font-bold opacity-80">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    @include('components.student.candidatures.stats')

    @include('components.student.candidatures.filters')

    @include('components.student.candidatures.list')
</div>
@endsection
