@extends('layouts.student')

@section('title', 'Mon Profil - StageFlow')
@section('breadcrumb', 'Mon Profil')

@section('content')
<div class="p-4 sm:p-6 lg:p-8 max-w-4xl mx-auto space-y-8">
    <div class="mb-8" data-aos="fade-down">
        <h2 class="text-2xl sm:text-3xl font-black text-gray-800 font-heading">Paramètres du Profil</h2>
        <p class="mt-1 text-sm text-gray-600">Gérez vos informations personnelles, votre parcours et vos liens sociaux.</p>
    </div>

    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl p-4 mb-6 shadow-sm" data-aos="fade-in">
            <div class="flex items-center gap-x-3">
                <svg class="size-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <p class="text-sm font-bold">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    <form action="{{ route('student.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        @include('components.student.profile.personal-info')

        @include('components.student.profile.academic-info')

        @include('components.student.profile.professional-info')

        <div class="flex justify-end gap-x-3 pt-6" data-aos="fade-up" data-aos-delay="300">
            <a href="{{ route('student.dashboard') }}"
                class="py-3 px-6 inline-flex items-center gap-x-2 text-sm font-bold rounded-xl border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 transition">
                Annuler
            </a>
            <button type="submit"
                class="py-3 px-10 inline-flex items-center gap-x-2 text-sm font-bold rounded-xl border border-transparent bg-indigo-600 text-white hover:bg-indigo-700 transition shadow-lg shadow-indigo-100 transform hover:scale-[1.02] active:scale-[0.98]">
                Enregistrer les modifications
                <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            </button>
        </div>
    </form>
</div>
@endsection
