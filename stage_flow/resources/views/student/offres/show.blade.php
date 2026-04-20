@extends('layouts.student')

@section('title', $offre->titre . ' - StageFlow')
@section('breadcrumb', 'Détail de l\'Offre')

@section('content')
<div class="max-w-5xl mx-auto space-y-8">
    <!-- Go Back Link -->
    <div data-aos="fade-down">
        <a class="inline-flex items-center gap-x-1.5 text-sm text-gray-600 decoration-2 hover:underline font-medium hover:text-indigo-600 transition"
            href="{{ route('offres.index') }}">
            <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round">
                <path d="m15 18-6-6 6-6" />
            </svg>
            Retour au catalogue
        </a>
    </div>

    <!-- Header Card -->
    <div class="bg-white border border-gray-200 shadow-sm rounded-2xl p-6 sm:p-10" data-aos="fade-up">
        <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-6">
            <div class="flex items-center gap-x-6">
                <div class="size-20 bg-indigo-50 flex justify-center items-center rounded-2xl border border-indigo-100 shrink-0 overflow-hidden">
                    @if($offre->entreprise->logo)
                        <img class="size-full object-cover" src="{{ asset('storage/'.$offre->entreprise->logo) }}" alt="Logo">
                    @else
                        <span class="text-indigo-600 font-bold text-2xl uppercase">{{ substr($offre->entreprise->nom_entreprise, 0, 1) }}</span>
                    @endif
                </div>
                <div>
                    <div class="flex items-center gap-x-2 mb-1">
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">{{ $offre->entreprise->nom_entreprise }}</span>
                        <svg class="size-4 text-indigo-600" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 22S2 16 2 8V4l10-3 10 3v4c0 8-10 14-10 14Z" />
                        </svg>
                    </div>
                    <h1 class="text-2xl sm:text-3xl font-black text-gray-900 tracking-tight font-heading">{{ $offre->titre }}</h1>
                    <ul class="mt-2 flex flex-wrap items-center gap-x-4 gap-y-2 text-sm text-gray-500 font-medium">
                        <li class="flex items-center gap-x-1.5">
                            <svg class="shrink-0 size-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z" /><circle cx="12" cy="10" r="3" />
                            </svg>
                            {{ $offre->ville->nom }}
                        </li>
                        <li class="flex items-center gap-x-1.5">
                            <svg class="shrink-0 size-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect width="18" height="18" x="3" y="4" rx="2" ry="2" /><line x1="16" x2="16" y1="2" y2="6" /><line x1="8" x2="8" y1="2" y2="6" /><line x1="3" x2="21" y1="10" y2="10" />
                            </svg>
                            Publié {{ $offre->created_at->diffForHumans() }}
                        </li>
                    </ul>
                </div>
            </div>

            <div class="flex sm:flex-col lg:flex-row items-center gap-3">
                <form action="{{ route('student.favoris.toggle', $offre->id) }}" method="POST" class="w-full sm:w-auto">
                    @csrf
                    <button type="submit" class="w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-xl border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 transition">
                        <svg class="shrink-0 size-4 {{ $etudiant->favoris->contains($offre->id) ? 'fill-rose-500 text-rose-500' : '' }}" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z" />
                        </svg>
                        {{ $etudiant->favoris->contains($offre->id) ? 'Sauvegardé' : 'Sauvegarder' }}
                    </button>
                </form>
                <a href="{{ route('student.candidatures.create', $offre->id) }}" class="w-full sm:w-auto py-3 px-6 inline-flex justify-center items-center gap-x-2 text-sm font-bold rounded-xl bg-indigo-600 text-white hover:bg-indigo-700 shadow-md shadow-indigo-200 transition">
                    Postuler maintenant
                    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M5 12h14" /><path d="m12 5 7 7-7 7" />
                    </svg>
                </a>
            </div>
        </div>
    </div>

    <div class="grid lg:grid-cols-3 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-8">
            <div class="bg-white border border-gray-200 shadow-sm rounded-2xl p-6 sm:p-8" data-aos="fade-up">
                <h2 class="text-xl font-bold text-gray-800 mb-6 font-heading">À propos de l'offre</h2>
                <div class="text-gray-600 leading-relaxed space-y-4 mb-10">
                    {!! nl2br(e($offre->description)) !!}
                </div>

                <div class="border-t border-gray-100 pt-10">
                    <h3 class="text-lg font-bold text-gray-800 mb-6 font-heading">Vos responsabilités</h3>
                    <ul class="space-y-5 text-sm text-gray-600">
                        @foreach(explode('|', $offre->responsabilites) as $resp)
                            <li class="flex gap-x-3">
                                <span class="size-6 flex justify-center items-center rounded-full bg-indigo-50 text-indigo-600 shrink-0">
                                    <svg class="size-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                </span>
                                <span class="pt-0.5 leading-relaxed">{{ trim($resp) }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <!-- Profil Recherché (Separated) -->
            <div class="bg-white border border-gray-200 shadow-sm rounded-2xl p-6 sm:p-8" data-aos="fade-up">
                <h3 class="text-xl font-bold text-gray-800 mb-6 font-heading">Profil recherché</h3>
                <ul class="space-y-4 text-sm text-gray-600">
                    @foreach(explode('|', $offre->profil_recherche) as $profil)
                        <li class="flex gap-x-3">
                            <div class="h-2 w-2 bg-indigo-600 rounded-full mt-2 shrink-0 shadow-sm shadow-indigo-200"></div>
                            <span class="pt-0.5">{{ trim($profil) }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <!-- Sidebar Info -->
        <div class="space-y-6">
            <!-- Quick Facts -->
            <div class="bg-white border border-gray-200 shadow-sm rounded-2xl p-6" data-aos="fade-up" data-aos-delay="100">
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-6 border-b border-gray-50 pb-4">Informations clés</h3>
                <div class="space-y-5">
                    <div class="flex items-start gap-x-3">
                        <div class="p-2 bg-indigo-50 text-indigo-600 rounded-lg"><svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></div>
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase">Durée</p>
                            <p class="text-sm font-bold text-gray-800">{{ $offre->duree }}</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-x-3">
                        <div class="p-2 bg-emerald-50 text-emerald-600 rounded-lg"><svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></div>
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase">Rémunération</p>
                            <p class="text-sm font-bold text-gray-800">{{ $offre->remuneration }}</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-x-3">
                        <div class="p-2 bg-blue-50 text-blue-600 rounded-lg"><svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg></div>
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase">Format</p>
                            <p class="text-sm font-bold text-gray-800">{{ $offre->format }}</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-x-3">
                        <div class="p-2 bg-purple-50 text-purple-600 rounded-lg"><svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg></div>
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase">Secteur</p>
                            <p class="text-sm font-bold text-gray-800">{{ $offre->secteur }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Company Card -->
            <div class="bg-indigo-900 rounded-2xl p-6 shadow-xl relative overflow-hidden text-white" data-aos="fade-up" data-aos-delay="200">
                <div class="absolute top-0 right-0 p-4 opacity-10">
                    <svg class="size-32 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5z"/></svg>
                </div>
                <div class="relative z-10">
                    <div class="flex items-center gap-x-3 mb-4">
                        <div class="p-2 bg-white rounded-xl"><img class="size-8 object-contain" src="{{ asset('storage/'.$offre->entreprise->logo ?? 'images/default-company.png') }}" onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($offre->entreprise->nom_entreprise) }}&background=fff&color=4f46e5'" alt="Logo"></div>
                        <h3 class="text-sm font-bold uppercase tracking-wider">{{ $offre->entreprise->nom_entreprise }}</h3>
                    </div>
                    <p class="text-xs text-indigo-100 mb-6 leading-relaxed">{{ Str::limit($offre->entreprise->bio, 120) }}</p>
                    <button type="button" onclick="openEntrepriseModal({{ $offre->entreprise->user_id }})" class="inline-flex items-center gap-x-2 text-xs font-bold hover:text-indigo-200 transition focus:outline-none">
                        Profil Entreprise
                        <svg class="size-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </button>
                </div>
            </div>

            <!-- Skills -->
            @if($offre->competences_techniques)
                <div class="bg-white border border-gray-200 shadow-sm rounded-2xl p-6" data-aos="fade-up" data-aos-delay="300">
                    <h3 class="text-xs font-black text-gray-800 uppercase tracking-widest font-heading mb-4">Compétences Techniques</h3>
                    <div class="border-b border-gray-50 mb-8"></div>
                    <div class="flex flex-wrap gap-x-3 gap-y-4">
                        @php
                            $skillBgs = [
                                'bg-indigo-50 text-indigo-600 border-indigo-100',
                                'bg-blue-50 text-blue-600 border-blue-100',
                                'bg-purple-50 text-purple-600 border-purple-100',
                                'bg-slate-50 text-slate-600 border-slate-100',
                                'bg-emerald-50 text-emerald-600 border-emerald-100',
                            ];
                        @endphp
                        @foreach($offre->competences_techniques as $index => $skill)
                            <span class="py-2 px-4 {{ $skillBgs[$index % count($skillBgs)] }} text-xs font-bold rounded-xl border transition-colors hover:shadow-sm">
                                {{ $skill }}
                            </span>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Backdrop -->
<div id="entreprise-modal-backdrop" onclick="closeEntrepriseModal()" style="display:none;" class="fixed inset-0 z-[80] bg-black/50 backdrop-blur-sm"></div>

<!-- Modal Panel -->
<div id="entreprise-modal-panel" style="display:none;" class="fixed inset-0 z-[90] flex items-center justify-center p-4" onclick="handleBackdropClick(event)">
  <div id="entreprise-modal-card" class="bg-white w-full max-w-lg rounded-3xl shadow-2xl flex flex-col max-h-[90vh] overflow-hidden">

    <!-- Header épuré : fond blanc avec pattern subtil + logo centré -->
    <div class="relative bg-gradient-to-b from-slate-50 to-white px-6 pt-8 pb-6 border-b border-gray-100 shrink-0">
      <!-- Bouton fermer -->
      <button onclick="closeEntrepriseModal()" type="button"
        class="absolute top-4 right-4 size-8 flex items-center justify-center rounded-xl bg-gray-100 text-gray-500 hover:bg-gray-200 hover:text-gray-800 transition-all duration-150 focus:outline-none"
        aria-label="Fermer">
        <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
      </button>

      <!-- Logo centré -->
      <div class="flex flex-col items-center text-center">
        <div class="size-20 bg-white rounded-2xl border border-gray-200 shadow-md flex items-center justify-center overflow-hidden mb-4">
          <img id="modal-entreprise-logo" src="" class="size-full object-contain hidden" alt="Logo">
          <span id="modal-entreprise-initial" class="text-3xl font-black text-indigo-600 hidden uppercase"></span>
        </div>
        <h3 id="modal-entreprise-name" class="text-xl font-black text-gray-900 tracking-tight"></h3>
        <div class="flex items-center gap-2 mt-2 flex-wrap justify-center">
          <span id="modal-entreprise-secteur" class="text-xs font-bold text-indigo-700 bg-indigo-50 border border-indigo-100 px-3 py-1 rounded-full"></span>
          <span id="modal-entreprise-taille" class="text-xs font-bold text-gray-500 bg-gray-100 border border-gray-200 px-3 py-1 rounded-full"></span>
        </div>
      </div>
    </div>

    <!-- Loading -->
    <div id="modal-loading-spinner" class="flex-1 flex items-center justify-center py-16">
      <div class="text-center">
        <div class="animate-spin size-12 border-4 border-indigo-100 border-t-indigo-600 rounded-full mx-auto mb-3"></div>
        <p class="text-sm text-gray-400 font-medium">Chargement...</p>
      </div>
    </div>

    <!-- Content -->
    <div id="modal-content-container" class="hidden flex-1 overflow-y-auto">

      <!-- Stats : 5 colonnes avec icônes -->
      <div class="grid grid-cols-5 gap-0 divide-x divide-gray-100 border-b border-gray-100">
        <!-- Ville -->
        <div class="py-4 px-1 text-center flex flex-col items-center">
          <div class="size-8 bg-indigo-50 text-indigo-500 rounded-xl flex items-center justify-center mb-1.5">
            <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.242-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
          </div>
          <p class="text-[9px] font-black text-gray-400 uppercase tracking-wide mb-0.5">Ville</p>
          <p id="modal-entreprise-ville" class="text-[11px] font-black text-gray-800 leading-tight text-center"></p>
        </div>
        <!-- Secteur -->
        <div class="py-4 px-1 text-center flex flex-col items-center">
          <div class="size-8 bg-blue-50 text-blue-500 rounded-xl flex items-center justify-center mb-1.5">
            <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
          </div>
          <p class="text-[9px] font-black text-gray-400 uppercase tracking-wide mb-0.5">Secteur</p>
          <p id="modal-stat-secteur" class="text-[11px] font-black text-gray-800 leading-tight text-center"></p>
        </div>
        <!-- Taille -->
        <div class="py-4 px-1 text-center flex flex-col items-center">
          <div class="size-8 bg-emerald-50 text-emerald-500 rounded-xl flex items-center justify-center mb-1.5">
            <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
          </div>
          <p class="text-[9px] font-black text-gray-400 uppercase tracking-wide mb-0.5">Taille</p>
          <p id="modal-stat-taille" class="text-[11px] font-black text-gray-800 leading-tight text-center"></p>
        </div>
        <!-- Vues -->
        <div class="py-4 px-1 text-center flex flex-col items-center">
          <div class="size-8 bg-purple-50 text-purple-500 rounded-xl flex items-center justify-center mb-1.5">
            <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
          </div>
          <p class="text-[9px] font-black text-gray-400 uppercase tracking-wide mb-0.5">Vues</p>
          <p id="modal-entreprise-vues" class="text-[11px] font-black text-gray-800 leading-tight"></p>
        </div>
        <!-- RC -->
        <div class="py-4 px-1 text-center flex flex-col items-center">
          <div class="size-8 bg-amber-50 text-amber-500 rounded-xl flex items-center justify-center mb-1.5">
            <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
          </div>
          <p class="text-[9px] font-black text-gray-400 uppercase tracking-wide mb-0.5">RC</p>
          <p id="modal-entreprise-rc" class="text-[11px] font-black text-gray-800 leading-tight break-all"></p>
        </div>
      </div>

      <!-- Contact Info -->
      <div class="px-6 py-4 border-b border-gray-100 space-y-2">
        <div id="modal-contact-adresse" class="hidden flex items-center gap-3">
          <div class="size-7 bg-gray-100 rounded-lg flex items-center justify-center shrink-0">
            <svg class="size-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
          </div>
          <span id="modal-adresse-text" class="text-sm text-gray-600 truncate"></span>
        </div>
        <div id="modal-contact-email" class="hidden flex items-center gap-3">
          <div class="size-7 bg-gray-100 rounded-lg flex items-center justify-center shrink-0">
            <svg class="size-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
          </div>
          <a id="modal-email-text" href="" class="text-sm text-indigo-600 hover:underline font-medium truncate"></a>
        </div>
      </div>

      <!-- Bio -->
      <div class="px-6 py-5 border-b border-gray-100">
        <h4 class="text-[10px] font-black text-gray-500 uppercase tracking-widest mb-3 flex items-center gap-2">
          <span class="w-1.5 h-1.5 rounded-full bg-indigo-500 shrink-0"></span> À propos
        </h4>
        <p id="modal-entreprise-bio" class="text-sm text-gray-600 leading-relaxed"></p>
      </div>

      <!-- Offres Actives -->
      <div class="px-6 py-5">
        <h4 class="text-[10px] font-black text-gray-500 uppercase tracking-widest mb-4 flex items-center gap-2">
          <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 shrink-0"></span> Offres Actives
        </h4>
        <div id="modal-offres-list" class="space-y-3"></div>
        <div id="modal-offres-empty" class="hidden text-center py-8 bg-gray-50 border border-dashed border-gray-200 rounded-2xl">
          <svg class="size-8 text-gray-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
          <p class="text-xs text-gray-400 font-bold uppercase tracking-widest">Aucune offre active</p>
        </div>
      </div>

    </div>
  </div>
</div>

@endsection

@push('scripts')
<style>
  @keyframes modalSlideIn {
    from { opacity: 0; transform: translateY(20px) scale(0.98); }
    to   { opacity: 1; transform: translateY(0) scale(1); }
  }
  #entreprise-modal-card { animation: modalSlideIn 0.25s cubic-bezier(0.22, 1, 0.36, 1) both; }
</style>
<script>
    function openEntrepriseModal(id) {
        document.getElementById('modal-loading-spinner').style.display = 'flex';
        document.getElementById('modal-content-container').classList.add('hidden');

        const backdrop = document.getElementById('entreprise-modal-backdrop');
        const panel    = document.getElementById('entreprise-modal-panel');
        const card     = document.getElementById('entreprise-modal-card');

        backdrop.style.display = 'block';
        panel.style.display    = 'flex';
        document.body.style.overflow = 'hidden';

        card.style.animation = 'none';
        card.offsetHeight;
        card.style.animation = '';

        fetch(`/entreprises/${id}/profile`)
            .then(r => r.json())
            .then(res => {
                if (!res.success) return;
                const { entreprise: ent, offres } = res.data;

                // Logo
                const logoImg  = document.getElementById('modal-entreprise-logo');
                const initSpan = document.getElementById('modal-entreprise-initial');
                if (ent.logoUrl) {
                    logoImg.src = ent.logoUrl;
                    logoImg.classList.remove('hidden');
                    initSpan.classList.add('hidden');
                } else {
                    initSpan.textContent = ent.lettreInitiale;
                    initSpan.classList.remove('hidden');
                    logoImg.classList.add('hidden');
                }

                // Infos principales
                document.getElementById('modal-entreprise-name').textContent    = ent.nom_entreprise || '';
                document.getElementById('modal-entreprise-secteur').textContent = ent.secteur || '';
                document.getElementById('modal-entreprise-taille').textContent  = ent.taille || '';
                document.getElementById('modal-stat-secteur').textContent       = ent.secteur || '-';
                document.getElementById('modal-stat-taille').textContent        = ent.taille || '-';
                document.getElementById('modal-entreprise-ville').textContent   = ent.ville ? ent.ville.nom : '-';
                document.getElementById('modal-entreprise-vues').textContent    = ent.vues ?? 0;
                document.getElementById('modal-entreprise-rc').textContent      = ent.registre_commerce || '-';
                document.getElementById('modal-entreprise-bio').textContent     = ent.bio || 'Aucune description disponible.';

                // Adresse
                const adresseRow = document.getElementById('modal-contact-adresse');
                if (ent.adresse) { document.getElementById('modal-adresse-text').textContent = ent.adresse; adresseRow.classList.remove('hidden'); }
                else { adresseRow.classList.add('hidden'); }

                // Email
                const emailRow = document.getElementById('modal-contact-email');
                if (ent.email_contact) {
                    const emailEl = document.getElementById('modal-email-text');
                    emailEl.textContent = ent.email_contact;
                    emailEl.href = `mailto:${ent.email_contact}`;
                    emailRow.classList.remove('hidden');
                } else { emailRow.classList.add('hidden'); }

                // Offres enrichies
                const list  = document.getElementById('modal-offres-list');
                const empty = document.getElementById('modal-offres-empty');
                list.innerHTML = '';
                if (offres && offres.length > 0) {
                    empty.classList.add('hidden');
                    offres.forEach(offre => {
                        const descriptionShort = offre.description ? offre.description.substring(0, 80) + '...' : '';
                        list.innerHTML += `
                        <div class="bg-gray-50 border border-gray-100 rounded-2xl p-4 hover:border-indigo-200 hover:bg-indigo-50/30 transition-all duration-150 group">
                            <div class="flex items-start justify-between gap-3 mb-2">
                                <h5 class="text-sm font-bold text-gray-900 group-hover:text-indigo-700 transition leading-snug">${offre.titre}</h5>
                                <div class="flex gap-1.5 shrink-0">
                                    ${offre.duree ? `<span class="text-[10px] font-bold uppercase tracking-wide text-emerald-700 bg-emerald-50 border border-emerald-100 px-2 py-0.5 rounded-lg">${offre.duree}</span>` : ''}
                                    <span class="text-[10px] font-bold uppercase tracking-wide text-indigo-700 bg-indigo-50 border border-indigo-100 px-2 py-0.5 rounded-lg">${offre.type_stage || 'Stage'}</span>
                                </div>
                            </div>
                            ${descriptionShort ? `<p class="text-xs text-gray-500 leading-relaxed mb-3 line-clamp-2">${descriptionShort}</p>` : ''}
                            <a href="/offres/${offre.id}" class="inline-flex items-center gap-1.5 text-xs font-bold text-indigo-600 hover:text-indigo-800 transition">
                                Voir le détail
                                <svg class="size-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            </a>
                        </div>`;
                    });
                } else {
                    empty.classList.remove('hidden');
                }

                setTimeout(() => {
                    document.getElementById('modal-loading-spinner').style.display = 'none';
                    document.getElementById('modal-content-container').classList.remove('hidden');
                }, 150);
            })
            .catch(() => {
                document.getElementById('modal-loading-spinner').innerHTML = '<p class="text-red-500 text-sm font-semibold text-center">Erreur lors du chargement.</p>';
            });
    }

    function closeEntrepriseModal() {
        document.getElementById('entreprise-modal-backdrop').style.display = 'none';
        document.getElementById('entreprise-modal-panel').style.display    = 'none';
        document.body.style.overflow = '';
    }

    function handleBackdropClick(e) {
        if (e.target === document.getElementById('entreprise-modal-panel')) closeEntrepriseModal();
    }

    document.addEventListener('keydown', e => { if (e.key === 'Escape') closeEntrepriseModal(); });
</script>
@endpush
