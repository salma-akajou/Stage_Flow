@extends('layouts.student')

@section('title', 'Mes Favoris - StageFlow')
@section('breadcrumb', 'Mes Favoris')

@section('content')
<div class="space-y-8">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4" data-aos="fade-down">
        <div class="max-w-xl">
            <h2 class="text-2xl sm:text-3xl font-black text-gray-800 font-heading">Mes Favoris</h2>
            <p class="mt-2 text-sm text-gray-600">Retrouvez ici toutes les offres de stage que vous avez repérées.</p>
        </div>
        <div class="flex gap-2">
            <span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-xl text-xs font-bold bg-indigo-50 text-indigo-700 border border-indigo-100">
                <svg class="size-3.5 fill-current" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                {{ $favoris->total() }} Sauvegardées
            </span>
        </div>
    </div>

    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6" data-aos="fade-up" data-aos-delay="100">
        @forelse($favoris as $offre)
            <div class="group flex flex-col h-full bg-white border border-gray-200 shadow-sm rounded-2xl p-6 hover:shadow-md transition relative">
                <form action="{{ route('student.favoris.toggle', $offre->id) }}" method="POST" class="absolute top-4 right-4">
                    @csrf
                    <button type="submit" class="text-rose-500 hover:text-rose-600 transition focus:outline-none" title="Retirer des favoris">
                        <svg class="size-6 fill-current" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                    </button>
                </form>

                <div class="flex items-center gap-x-3 mb-4">
                     <div class="size-10 bg-indigo-50 flex justify-center items-center rounded-lg border border-indigo-100 overflow-hidden">
                        @if($offre->entreprise->user->photo)
                            <img src="{{ asset('storage/'.$offre->entreprise->user->photo) }}" class="size-full object-cover">
                        @else
                            <span class="text-indigo-600 font-bold text-sm">{{ substr($offre->entreprise->nom_entreprise, 0, 1) }}</span>
                        @endif
                    </div>
                    <span class="text-[10px] font-black uppercase tracking-widest text-indigo-700">{{ $offre->entreprise->nom_entreprise }}</span>
                </div>

                <div class="min-w-0 mb-4 grow">
                    <h4 class="font-black text-gray-800 truncate group-hover:text-indigo-600 font-heading">{{ $offre->titre }}</h4>
                    <p class="text-xs text-gray-400 font-bold uppercase tracking-tighter mt-1">{{ $offre->ville->nom }}</p>
                </div>

                <p class="text-sm text-gray-500 line-clamp-2 mb-4 leading-relaxed">{{ Str::limit($offre->description, 80) }}</p>
                
                <div class="flex flex-wrap gap-2 mb-6">
                    <span class="py-1 px-2.5 rounded-lg text-[10px] font-bold bg-indigo-50 text-indigo-700 uppercase tracking-tight border border-indigo-100">{{ $offre->secteur }}</span>
                    <span class="py-1 px-2.5 rounded-lg text-[10px] font-bold bg-gray-50 text-gray-400 border border-gray-100 uppercase tracking-tight">{{ $offre->duree }}</span>
                </div>

                <div class="border-t border-gray-50 pt-4 flex items-center justify-between">
                    <span class="text-[10px] text-gray-400 font-medium italic">Ajouté {{ $offre->pivot->created_at->diffForHumans() }}</span>
                    <a href="{{ route('offres.show', $offre->id) }}"
                        class="py-2.5 px-5 inline-flex items-center gap-x-2 text-[11px] font-bold rounded-xl bg-indigo-50 text-indigo-600 hover:bg-indigo-100 transition shadow-sm">
                        Voir détails
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-full bg-white border-2 border-dashed border-gray-200 rounded-2xl p-12 text-center" data-aos="zoom-in">
                <div class="size-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="size-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                </div>
                <h3 class="text-lg font-bold text-gray-800 font-heading">Votre coup de cœur n'est pas encore là</h3>
                <p class="text-gray-500 mt-2">Explorez le catalogue et sauvez les offres qui vous inspirent !</p>
                <a href="{{ route('offres.index') }}" class="mt-6 inline-flex items-center gap-x-2 py-3 px-6 text-sm font-bold rounded-xl bg-indigo-600 text-white hover:bg-indigo-700 transition shadow-lg shadow-indigo-100">
                    Découvrir les offres
                </a>
            </div>
        @endforelse
    </div>

    <div class="pt-10">
        {{ $favoris->links() }}
    </div>
</div>
@endsection
