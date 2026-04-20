@extends('layouts.student')

@section('title', 'Tableau de bord - StageFlow')

@section('breadcrumb', 'Tableau de bord')

@section('content')
    @include('components.student.dashboard.welcome-hero')

    @include('components.student.dashboard.stats-cards')

    @include('components.student.dashboard.recommended-offers')

    <div class="grid lg:grid-cols-2 gap-6" data-aos="fade-up">
        @include('components.student.dashboard.recent-applications')

        @include('components.student.dashboard.feedback-form')
    </div>
@endsection
