@extends('layouts.student')

@section('title', 'Tableau de bord - StageFlow')

@section('breadcrumb', 'Tableau de bord')

@section('content')
<div class="bg-indigo-950 rounded-2xl p-8 sm:p-12 relative overflow-hidden shadow-lg" data-aos="zoom-in">
    <div class="relative z-10 max-w-2xl text-white">
        <div class="mb-8">
            <h1 class="text-3xl font-bold">Bonjour, {{ $etudiant->user->prenom }} 👋</h1>
            <p class="text-indigo-300 text-sm font-medium mt-1">{{ $etudiant->filiere }} - {{ $etudiant->etablissement }}</p>
        </div>
        <h2 class="text-4xl font-black mb-6 leading-tight">Propulse ton potentiel avec StageFlow.</h2>
        <p class="text-indigo-200 text-lg mb-8 leading-relaxed">Trouve le stage de tes rêves parmi des centaines d'opportunités exclusives et adaptées à ton profil.</p>
        <div class="flex flex-wrap gap-4">
            <a href="{{ route('offres.index') }}"
                class="py-3 px-8 inline-flex items-center gap-x-2 text-sm font-bold rounded-lg bg-white text-indigo-950 hover:bg-indigo-50 transition">
                Explorer les offres
            </a>
            <a href="#recommended-offers"
                class="py-3 px-8 inline-flex items-center gap-x-2 text-sm font-bold rounded-lg border border-white/20 text-white hover:bg-white/10 transition">
                Voir les recommandations
            </a>
        </div>
    </div>
    <div class="absolute -bottom-10 -right-10 opacity-10">
        <svg class="size-64 text-white" fill="none" stroke="currentColor" stroke-width="1"
            viewBox="0 0 24 24">
            <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5" />
        </svg>
    </div>
</div>

<div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6" data-aos="fade-up">
    <div class="flex flex-col bg-white border border-gray-200 shadow-sm rounded-xl p-5 hover:border-indigo-200 transition group">
        <div class="flex items-center justify-between mb-2">
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Candidatures</p>
            <div class="size-8 bg-indigo-50 text-indigo-600 rounded-lg flex items-center justify-center group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                <svg class="size-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </div>
        </div>
        <div class="flex items-center gap-x-2">
            <h3 class="text-3xl font-bold text-gray-800 tracking-tight">{{ sprintf('%02d', $stats['candidatures']) }}</h3>
            <span class="text-emerald-500 text-[10px] font-bold">+15%</span>
        </div>
    </div>
    <div class="flex flex-col bg-white border border-gray-200 shadow-sm rounded-xl p-5 hover:border-indigo-200 transition group">
        <div class="flex items-center justify-between mb-2">
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Vues Profil</p>
            <div class="size-8 bg-emerald-50 text-emerald-600 rounded-lg flex items-center justify-center group-hover:bg-emerald-600 group-hover:text-white transition-colors">
                <svg class="size-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
            </div>
        </div>
        <div class="font-bold text-3xl text-gray-800 tracking-tight">{{ sprintf('%02d', $stats['vues']) }}</div>
    </div>
    <div class="flex flex-col bg-white border border-gray-200 shadow-sm rounded-xl p-5 hover:border-indigo-200 transition group">
        <div class="flex items-center justify-between mb-2">
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Offres Retenues</p>
            <div class="size-8 bg-amber-50 text-amber-600 rounded-lg flex items-center justify-center group-hover:bg-amber-600 group-hover:text-white transition-colors">
                <svg class="size-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"/></svg>
            </div>
        </div>
        <div class="font-bold text-3xl text-gray-800 tracking-tight">{{ sprintf('%02d', $stats['retenues']) }}</div>
    </div>
    <div class="flex flex-col bg-white border border-gray-200 shadow-sm rounded-xl p-5 hover:border-indigo-200 transition group">
        <div class="flex items-center justify-between mb-2">
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Favoris</p>
            <div class="size-8 bg-rose-50 text-rose-600 rounded-lg flex items-center justify-center group-hover:bg-rose-600 group-hover:text-white transition-colors">
                <svg class="size-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
            </div>
        </div>
        <div class="font-bold text-3xl text-gray-800 tracking-tight">{{ sprintf('%02d', $stats['favoris']) }}</div>
    </div>
</div>

<div id="recommended-offers" class="space-y-4" data-aos="fade-up">
    <div class="flex justify-between items-center">
        <h3 class="text-xl font-bold text-gray-800">Stages recommandés</h3>
        <a class="text-xs font-bold text-indigo-600 hover:text-indigo-700 hover:underline" href="{{ route('offres.index') }}">Tout voir</a>
    </div>

    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 text-gray-800">
        @foreach($recommandations as $offre)
        <div class="group flex flex-col h-full bg-white border border-gray-200 shadow-sm rounded-2xl p-6 hover:shadow-md transition">
            <div class="flex items-center gap-x-4 mb-4">
                <div class="size-12 bg-gray-50 flex items-center justify-center rounded-xl border border-gray-100 shrink-0 overflow-hidden">
                    @if($offre->entreprise->user->photo)
                        <img src="{{ asset('storage/'.$offre->entreprise->user->photo) }}" class="size-8 object-contain">
                    @else
                        <span class="text-indigo-600 font-bold text-xs">{{ substr($offre->entreprise->nom_entreprise, 0, 1) }}</span>
                    @endif
                </div>
                <div class="min-w-0">
                    <h4 class="text-base font-bold text-gray-800 truncate group-hover:text-indigo-600 transition">{{ $offre->titre }}</h4>
                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">{{ $offre->entreprise->nom_entreprise }} • {{ $offre->ville->nom }}</p>
                </div>
            </div>
            <p class="text-xs text-gray-600 line-clamp-2 mb-4 leading-relaxed lowercase">{{ $offre->description }}</p>
            <div class="flex flex-wrap gap-2 mb-6">
                <span class="py-1 px-2.5 rounded-lg text-[10px] font-bold bg-indigo-50 text-indigo-700">{{ $offre->secteur }}</span>
                <span class="py-1 px-2.5 rounded-lg text-[10px] font-bold bg-gray-100 text-gray-600">{{ $offre->duree }}</span>
                @if ($offre->remuneration === 'Payé')
                    <span class="inline-flex items-center gap-1.5 py-0.5 px-2 rounded-full text-[10px] font-bold bg-green-100 text-green-800">
                        Payé
                    </span>
                @else
                    <span class="inline-flex items-center gap-1.5 py-0.5 px-2 rounded-full text-[10px] font-bold bg-red-100 text-red-800">
                        Non-payé
                    </span>
                @endif
            </div>
            <div class="mt-auto flex items-center justify-between pt-4 border-t border-gray-50">
                <span class="text-[10px] font-bold text-gray-400 italic">{{ $offre->created_at->diffForHumans() }}</span>
                <a href="{{ route('offres.show', $offre->id) }}" class="py-2 px-4 inline-flex items-center gap-x-2 text-xs font-bold rounded-lg bg-indigo-600 text-white hover:bg-indigo-700 transition">Voir Détails</a>
            </div>
        </div>
        @endforeach
    </div>
</div>

<div class="grid lg:grid-cols-2 gap-6" data-aos="fade-up">
    <div class="flex flex-col bg-white border border-gray-200 shadow-sm rounded-xl overflow-hidden min-h-[400px]">
        <div class="p-6 border-b border-gray-100 flex items-center justify-between">
            <h3 class="text-lg font-bold text-gray-800">Candidatures Récentes</h3>
            <a href="{{ route('student.candidatures') }}" class="text-xs font-bold text-indigo-600 hover:underline">Tout voir</a>
        </div>
        <div class="p-6 flex-grow">
            <div class="space-y-6">
                @forelse($candidatures_recentes as $candidature)
                <div class="flex items-center gap-x-4">
                    <div class="size-10 bg-gray-50 flex-none flex items-center justify-center rounded-lg border border-gray-100 overflow-hidden">
                        @if($candidature->offre->entreprise->user->photo)
                            <img src="{{ asset('storage/'.$candidature->offre->entreprise->user->photo) }}" class="size-6 object-contain">
                        @else
                            <span class="text-indigo-600 font-bold text-[10px]">{{ substr($candidature->offre->entreprise->nom_entreprise, 0, 1) }}</span>
                        @endif
                    </div>
                    <div class="grow min-w-0">
                        <h4 class="text-sm font-bold text-gray-800 truncate">{{ $candidature->offre->titre }}</h4>
                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">{{ $candidature->offre->entreprise->nom_entreprise }}</p>
                    </div>
                    <div class="flex-none text-right">
                        <span class="py-1 px-2.5 inline-flex items-center gap-x-1 text-[10px] font-bold rounded-lg 
                            @if($candidature->statut == 'Acceptée' || $candidature->statut == 'Accepté') bg-emerald-100 text-emerald-800
                            @elseif($candidature->statut == 'Refusée' || $candidature->statut == 'Refusé') bg-red-100 text-red-800
                            @else bg-amber-100 text-amber-800 @endif">
                            {{ $candidature->statut }}
                        </span>
                    </div>
                </div>
                @empty
                <p class="text-center py-10 text-gray-400 italic text-sm">Aucune candidature récente.</p>
                @endforelse
            </div>
        </div>
    </div>

    <div class="flex flex-col bg-white border border-gray-200 shadow-sm rounded-xl overflow-hidden min-h-[400px]">
        <div class="p-6 border-b border-gray-100 flex items-center gap-x-2">
            <h3 class="text-lg font-bold text-gray-800">Donnez votre Feedback</h3>
        </div>
        <form action="{{ route('feedback.store') }}" method="POST" class="p-6 flex-grow flex flex-col space-y-4">
            @csrf
            <p class="text-xs text-gray-500 font-bold lowercase">Partagez vos suggestions pour améliorer StageFlow.</p>
            <textarea name="texte"
                class="py-3 px-4 block w-full bg-gray-50 border-gray-200 rounded-xl text-sm focus:border-indigo-600 focus:ring-0 transition-all outline-none min-h-[140px]"
                placeholder="Votre avis sur l'application..."></textarea>
            
            <div class="flex items-center gap-x-2" x-data="{ rating: 5 }">
                <input type="hidden" name="note" x-model="rating">
                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Note :</span>
                <div class="flex space-x-1 text-yellow-400">
                    @for($i = 1; $i <= 5; $i++)
                    <button type="button" @click="rating = {{ $i }}" class="focus:outline-none transition-transform hover:scale-110">
                        <svg class="size-5 transition-colors" :class="rating >= {{ $i }} ? 'text-yellow-400' : 'text-gray-200'" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                        </svg>
                    </button>
                    @endfor
                </div>
            </div>
            
            <div class="pt-0 mt-auto">
                <button type="submit"
                    class="w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-xs font-bold rounded-lg bg-indigo-600 text-white hover:bg-indigo-700 transition">
                    Envoyer mon avis
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
