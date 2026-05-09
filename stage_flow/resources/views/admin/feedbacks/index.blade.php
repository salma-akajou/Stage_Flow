@extends('layouts.admin')
@section('title', 'Modération Feedbacks - StageFlow Admin')
@section('breadcrumb', 'Feedbacks')

@section('content')
<div class="fixed inset-0 pointer-events-none overflow-hidden z-[-1] opacity-[0.03]">
    <div class="absolute top-20 left-10 sticker-float"><svg class="size-44 text-indigo-600" fill="currentColor" viewBox="0 0 24 24"><rect width="18" height="18" x="3" y="3" rx="2" /></svg></div>
    <div class="absolute top-[35%] right-10 sticker-float-slow" style="animation-delay:-4s"><svg class="size-32 text-indigo-500" fill="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" /></svg></div>
</div>

<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8" data-aos="fade-down">
    <div>
        <h1 class="text-3xl font-extrabold text-gray-900 font-heading tracking-tight">Modération des Feedbacks</h1>
        <p class="text-sm text-gray-500 mt-1">{{ $feedbacks->total() }} feedbacks</p>
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

<!-- Filtres feedbacks -->
<div class="relative z-20">
    @include('components.admin.feedbacks.filters')
</div>

<!-- Liste des feedbacks -->
<div id="feedbacks-table-container" class="relative z-10 bg-white border border-gray-200 rounded-3xl shadow-sm overflow-hidden" data-aos="fade-up">
    @include('components.admin.feedbacks.table-partial', ['feedbacks' => $feedbacks])
</div>

@endsection

@push('styles')
<style>
    .sticker-float { animation: stickerFloat 12s ease-in-out infinite; }
    .sticker-float-slow { animation: stickerFloat 18s ease-in-out infinite; }
    @keyframes stickerFloat {
        0%, 100% { transform: translateY(0) rotate(0deg); }
        33% { transform: translateY(-20px) rotate(5deg); }
        66% { transform: translateY(10px) rotate(-3deg); }
    }
</style>
@endpush

