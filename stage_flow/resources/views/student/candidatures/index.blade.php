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

    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6" data-aos="fade-up" data-aos-delay="100">
        <div class="flex flex-col bg-white border border-gray-200 shadow-sm rounded-2xl p-4 sm:p-5">
            <p class="text-[10px] uppercase tracking-widest text-gray-400 font-bold">Total Candidatures</p>
            <h3 class="text-2xl font-black text-gray-800 mt-2">{{ $stats['total'] }}</h3>
        </div>
        <div class="flex flex-col bg-white border border-gray-200 shadow-sm rounded-2xl p-4 sm:p-5">
            <p class="text-[10px] uppercase tracking-widest text-amber-500 font-bold">En attente</p>
            <h3 class="text-2xl font-black text-gray-800 mt-2">{{ $stats['attente'] }}</h3>
        </div>
        <div class="flex flex-col bg-white border border-gray-200 shadow-sm rounded-2xl p-4 sm:p-5">
            <p class="text-[10px] uppercase tracking-widest text-emerald-500 font-bold">Acceptées</p>
            <h3 class="text-2xl font-black text-gray-800 mt-2">{{ $stats['accepte'] }}</h3>
        </div>
        <div class="flex flex-col bg-white border border-gray-200 shadow-sm rounded-2xl p-4 sm:p-5">
            <p class="text-[10px] uppercase tracking-widest text-rose-500 font-bold">Refusées</p>
            <h3 class="text-2xl font-black text-gray-800 mt-2">{{ $stats['refuse'] }}</h3>
        </div>
    </div>

    <div class="bg-white border border-gray-200 rounded-2xl p-4 sm:p-5 shadow-sm" data-aos="fade-up" data-aos-delay="200">
        <form action="{{ route('student.candidatures') }}" method="GET" class="flex flex-col lg:flex-row items-center gap-4">
            <div class="relative w-full lg:flex-1">
                <div class="absolute inset-y-0 start-0 flex items-center ps-4 pointer-events-none">
                    <svg class="size-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}"
                    class="py-2.5 ps-11 pe-4 block w-full border-gray-200 rounded-xl text-sm focus:border-indigo-500 focus:ring-indigo-500"
                    placeholder="Rechercher une entreprise ou un poste...">
            </div>

            <div class="w-full lg:w-48">
                <select name="statut" onchange="this.form.submit()"
                    class="py-2.5 px-4 pe-9 block w-full border-gray-200 rounded-xl text-sm font-medium text-gray-700 bg-gray-50 focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">Tous les statuts</option>
                    <option value="En attente" {{ request('statut') == 'En attente' ? 'selected' : '' }}>En attente</option>
                    <option value="Accepté" {{ request('statut') == 'Accepté' ? 'selected' : '' }}>Accepté</option>
                    <option value="Refusé" {{ request('statut') == 'Refusé' ? 'selected' : '' }}>Refusé</option>
                </select>
            </div>
            <button type="submit" class="hidden">Filtrer</button>
        </form>
    </div>

    <div class="space-y-4" data-aos="fade-up" data-aos-delay="300">
        @forelse($candidatures as $candidature)
            <div class="bg-white border border-gray-200 rounded-2xl p-4 sm:p-5 shadow-sm hover:shadow-md transition group">
                <div class="flex flex-col sm:flex-row sm:items-center gap-4">
                    <div class="flex items-center gap-x-4 flex-1">
                        <div class="shrink-0 size-14 bg-indigo-50 flex justify-center items-center rounded-xl border border-indigo-100 overflow-hidden">
                            @if($candidature->offre->entreprise->logo)
                                <img src="{{ asset('storage/'.$candidature->offre->entreprise->logo) }}" class="size-full object-cover">
                            @else
                                <span class="text-indigo-600 font-bold text-lg">{{ substr($candidature->offre->entreprise->nom_entreprise, 0, 1) }}</span>
                            @endif
                        </div>
                        <div class="grow">
                            <a href="{{ route('offres.show', $candidature->offre_id) }}"
                                class="inline-block font-bold text-gray-800 hover:text-indigo-600 transition font-heading">{{ $candidature->offre->titre }}</a>
                            <div class="flex flex-wrap items-center gap-x-2 text-xs text-gray-500 mt-1">
                                <span class="font-bold text-gray-400 lowercase tracking-tight">{{ $candidature->offre->entreprise->nom_entreprise }}</span>
                                <span>•</span>
                                <span>{{ $candidature->offre->ville->nom }}</span>
                            </div>
                            <p class="text-xs text-gray-400 mt-1.5 line-clamp-1">
                                {{ \Illuminate\Support\Str::limit($candidature->offre->description, 60) }}
                            </p>
                        </div>
                    </div>
                    <div class="flex flex-wrap items-center sm:justify-end gap-3 sm:gap-6">
                        <div class="text-left sm:text-right">
                            @php
                                $statusClasses = [
                                    'En attente' => 'bg-amber-100 text-amber-700',
                                    'Accepté' => 'bg-emerald-100 text-emerald-700',
                                    'Refusé' => 'bg-rose-100 text-rose-700',
                                ];
                                $statusIcon = [
                                    'En attente' => 'bg-amber-500',
                                    'Accepté' => 'bg-emerald-500',
                                    'Refusé' => 'bg-rose-500',
                                ];
                            @endphp
                            <span class="inline-flex items-center gap-1.5 py-1 px-3 rounded-full text-xs font-bold {{ $statusClasses[$candidature->statut] ?? 'bg-gray-100 text-gray-700' }}">
                                <span class="size-1.5 inline-block {{ $statusIcon[$candidature->statut] ?? 'bg-gray-500' }} rounded-full"></span>
                                {{ $candidature->statut }}
                            </span>
                            <p class="text-[11px] text-gray-400 mt-1.5 italic font-medium">Postulé {{ $candidature->created_at->diffForHumans() }}</p>
                        </div>
                        <div class="flex items-center gap-x-2">
                            <a href="{{ route('offres.show', $candidature->offre_id) }}"
                                class="p-2.5 inline-flex justify-center items-center rounded-xl border border-gray-200 bg-white text-gray-600 shadow-sm hover:bg-gray-50 hover:text-indigo-600 transition"
                                title="Voir l'offre">
                                <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </a>
                            @if($candidature->statut == 'En attente')
                                <form action="{{ route('student.candidatures.destroy', $candidature->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2.5 inline-flex justify-center items-center rounded-xl border border-gray-200 bg-white text-rose-500 shadow-sm hover:bg-rose-50 hover:text-rose-600 transition"
                                        onclick="return confirm('Êtes-vous sûr de vouloir retirer cette candidature ?')"
                                        title="Retirer la candidature">
                                        <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white border-2 border-dashed border-gray-200 rounded-2xl p-12 text-center" data-aos="zoom-in">
                <div class="size-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="size-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <h3 class="text-lg font-bold text-gray-800 font-heading">Aucune candidature pour le moment</h3>
                <p class="text-gray-500 mt-2">Explorez nos offres et postulez pour lancer votre carrière !</p>
                <a href="{{ route('offres.index') }}" class="mt-6 inline-flex items-center gap-x-2 py-3 px-6 text-sm font-bold rounded-xl bg-indigo-600 text-white hover:bg-indigo-700 transition shadow-lg shadow-indigo-100">
                    Voir le catalogue
                </a>
            </div>
        @endforelse
    </div>

    <div class="pt-10">
        {{ $candidatures->links('components.pagination') }}
    </div>
</div>
@endsection
