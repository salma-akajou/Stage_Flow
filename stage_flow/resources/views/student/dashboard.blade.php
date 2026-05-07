@extends('layouts.student')

@section('title', 'Tableau de bord - StageFlow')

@section('breadcrumb', 'Tableau de bord')

@section('content')
    @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 rounded-2xl flex items-center gap-4 animate-in fade-in slide-in-from-top-4 duration-500 shadow-sm" data-aos="fade-down">
            <div class="size-10 bg-emerald-500 text-white rounded-xl flex items-center justify-center shrink-0 shadow-lg shadow-emerald-100">
                <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
            </div>
            <div>
                <p class="text-sm font-black text-emerald-900">Succès !</p>
                <p class="text-xs font-bold text-emerald-600/80">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    @include('components.student.dashboard.welcome-hero')

    @include('components.student.dashboard.stats-cards')

    @include('components.student.dashboard.recommended-offers')

    <div class="grid lg:grid-cols-2 gap-6" data-aos="fade-up">
        @include('components.student.dashboard.recent-applications')

        @include('components.student.dashboard.feedback-form')
    </div>
@endsection
