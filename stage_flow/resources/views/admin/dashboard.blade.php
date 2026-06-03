@extends('layouts.admin')
@section('title', 'Tableau de Bord Admin - StageFlow')
@section('breadcrumb', 'Dashboard')

@section('content')
<div class="fixed inset-0 pointer-events-none overflow-hidden z-[-1] opacity-[0.03]">
    <div class="absolute top-20 left-10 sticker-float"><svg class="size-44 text-indigo-600" fill="currentColor" viewBox="0 0 24 24"><rect width="18" height="18" x="3" y="3" rx="2" /></svg></div>
    <div class="absolute top-[35%] right-10 sticker-float-slow" style="animation-delay:-4s"><svg class="size-32 text-indigo-500" fill="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" /></svg></div>
</div>

<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4" data-aos="fade-down">
    <div>
        <h1 class="text-2xl font-extrabold text-gray-900">Tableau de Bord Admin</h1>
        <p class="text-sm text-gray-500 mt-0.5">Vue d'ensemble de la plateforme</p>
    </div>
</div>

@include('components.admin.dashboard.stats', ['stats' => $stats])

<div class="grid lg:grid-cols-3 gap-6" data-aos="fade-up" data-aos-delay="150">
    @include('components.admin.dashboard.chart', ['chartData' => $chartData])
    @include('components.admin.dashboard.repartition', ['repartition' => $stats['repartition_users']])
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
