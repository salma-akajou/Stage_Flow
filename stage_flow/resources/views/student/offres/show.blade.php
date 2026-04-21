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
                        <img class="size-full object-contain p-2" src="{{ asset('storage/'.$offre->entreprise->logo) }}" alt="Logo">
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
                <button type="button" onclick="openCandidatureModal()" class="w-full sm:w-auto py-3 px-6 inline-flex justify-center items-center gap-x-2 text-sm font-bold rounded-xl bg-indigo-600 text-white hover:bg-indigo-700 shadow-md shadow-indigo-200 transition">
                    Postuler maintenant
                    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M5 12h14" /><path d="m12 5 7 7-7 7" />
                    </svg>
                </button>
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

<!-- Modal Container (Dynamically moved to body) -->
<div id="entreprise-modal-wrapper" style="display:none;" class="fixed inset-0 z-[100] transition-opacity duration-300 opacity-0">
    <!-- Backdrop inside wrapper -->
    <div id="entreprise-modal-backdrop" class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="closeEntrepriseModal()"></div>

    <!-- Modal Panel -->
    <div id="entreprise-modal-panel" class="absolute inset-0 flex flex-col items-center justify-center p-4 sm:p-6 pointer-events-none z-10 overflow-y-auto">
        <div id="entreprise-modal-card" class="bg-white w-full max-w-xl rounded-2xl shadow-xl flex flex-col max-h-[90vh] pointer-events-auto transform scale-95 transition-all duration-300 my-auto">
            
            <!-- Header -->
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 shrink-0">
                <h3 class="text-base font-bold text-gray-900" id="modal-header-title">Profil d'entreprise</h3>
                <button onclick="closeEntrepriseModal()" class="text-gray-400 hover:text-gray-700 bg-gray-50 hover:bg-gray-100 rounded-full p-1.5 transition focus:outline-none">
                    <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <!-- Scrollable Content -->
            <div class="flex-1 overflow-y-auto p-6 relative">
                <!-- Loading -->
                <div id="modal-loading-spinner" class="absolute inset-0 bg-white/90 z-20 flex flex-col items-center justify-center">
                    <div class="animate-spin size-8 border-4 border-indigo-100 border-t-indigo-600 rounded-full mb-3"></div>
                    <p class="text-sm font-semibold text-gray-500 tracking-wide">Chargement...</p>
                </div>

                <div id="modal-content-container" class="opacity-0 transition-opacity duration-300">
                    
                    <!-- Top Info: Logo, Name, Badges -->
                    <div class="flex flex-col items-center sm:items-start sm:flex-row gap-5 mb-8">
                        <div class="size-20 shrink-0 bg-white rounded-2xl shadow-sm border border-gray-100 flex items-center justify-center p-2 mb-2 sm:mb-0">
                            <img id="modal-entreprise-logo" src="" class="size-full object-contain hidden" alt="Logo">
                            <span id="modal-entreprise-initial" class="text-3xl font-black text-indigo-600 hidden uppercase"></span>
                        </div>
                        <div class="text-center sm:text-left flex-1">
                            <h4 id="modal-entreprise-name" class="text-xl sm:text-2xl font-bold text-gray-900 mb-2.5"></h4>
                            <div class="flex flex-wrap justify-center sm:justify-start gap-2">
                                <span class="bg-indigo-50 text-indigo-700 text-xs font-semibold px-2.5 py-1 rounded-md border border-indigo-100"><span id="modal-entreprise-secteur"></span></span>
                                <span class="bg-gray-50 text-gray-600 text-xs font-semibold px-2.5 py-1 rounded-md border border-gray-200"><span id="modal-entreprise-taille"></span></span>
                                <span class="bg-emerald-50 text-emerald-700 text-xs font-semibold px-2.5 py-1 rounded-md border border-emerald-100"><span id="modal-entreprise-ville"></span></span>
                            </div>
                        </div>
                    </div>

                    <!-- Layout for stats : 3 distinct key infos -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                        <!-- RC -->
                        <div id="modal-contact-rc" class="hidden bg-gray-50/80 p-4 rounded-xl border border-gray-100 flex flex-col items-center text-center gap-2 transition hover:bg-white hover:shadow-sm">
                            <div class="p-2.5 rounded-full shadow-sm text-amber-500 bg-white border border-amber-50">
                                <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wide">Registre Commerce</p>
                                <p id="modal-rc-text" class="text-xs font-bold text-gray-800 break-all"></p>
                            </div>
                        </div>

                        <!-- Adresse -->
                        <div id="modal-contact-adresse" class="hidden bg-gray-50/80 p-4 rounded-xl border border-gray-100 flex flex-col items-center text-center gap-2 transition hover:bg-white hover:shadow-sm">
                            <div class="p-2.5 rounded-full shadow-sm text-emerald-500 bg-white border border-emerald-50">
                                <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.242-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wide">Adresse</p>
                                <p id="modal-adresse-text" class="text-xs font-bold text-gray-800 leading-snug"></p>
                            </div>
                        </div>

                         <!-- Contact -->
                        <div id="modal-contact-email" class="hidden bg-gray-50/80 p-4 rounded-xl border border-gray-100 flex flex-col items-center text-center gap-2 transition hover:bg-white hover:shadow-sm">
                             <div class="p-2.5 rounded-full shadow-sm text-blue-500 bg-white border border-blue-50">
                                <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            </div>
                            <div class="w-full">
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wide">Email</p>
                                <a id="modal-email-text" href="#" class="text-xs font-bold text-blue-600 hover:underline truncate block mx-auto max-w-full"></a>
                            </div>
                        </div>
                    </div>

                    <!-- Bio -->
                    <div class="mb-8" id="modal-section-bio">
                        <h5 class="text-sm font-bold text-gray-900 mb-3 border-b border-gray-100 pb-2">À propos</h5>
                        <p id="modal-entreprise-bio" class="text-sm text-gray-600 leading-relaxed"></p>
                    </div>

                     <!-- Offers -->
                    <div class="mb-2">
                        <h5 class="text-sm font-bold text-gray-900 mb-4 border-b border-gray-100 pb-2">Opportunités actuelles</h5>
                        <div id="modal-offres-list" class="space-y-3"></div>
                        <div id="modal-offres-empty" class="hidden text-center py-6 bg-gray-50 rounded-xl border border-dashed border-gray-200">
                            <p class="text-xs font-semibold text-gray-500 mt-2">Aucune offre disponible.</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Candidature (Dynamically moved to body) -->
<div id="candidature-modal-wrapper" style="display:none;" class="fixed inset-0 z-[100] transition-opacity duration-300 opacity-0">
    <!-- Backdrop inside wrapper -->
    <div id="candidature-modal-backdrop" class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="closeCandidatureModal()"></div>

    <!-- Modal Panel -->
    <div id="candidature-modal-panel" class="absolute inset-0 flex flex-col items-center justify-center p-4 sm:p-6 pointer-events-none z-10 overflow-y-auto w-full">
        <div id="candidature-modal-card" class="bg-white w-full max-w-xl mx-auto rounded-2xl shadow-xl flex flex-col max-h-[90vh] min-h-[50vh] pointer-events-auto transform scale-95 transition-all duration-300 my-auto">
            
            <!-- Header -->
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 shrink-0">
                <div>
                    <h3 class="text-lg font-black text-gray-900 font-heading" id="modal-candidature-title">Formulaire de candidature</h3>
                    <p class="text-[11px] text-gray-500 font-bold uppercase tracking-widest mt-0.5">Offre : {{ $offre->titre }}</p>
                </div>
                <button onclick="closeCandidatureModal()" class="text-gray-400 hover:text-gray-700 bg-gray-50 hover:bg-gray-100 rounded-full p-2 transition focus:outline-none">
                    <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <!-- Scrollable Form Content -->
            <div class="flex-1 overflow-y-auto p-6 sm:p-8 relative">
                <form id="candidature-form" action="{{ route('student.candidatures.store', $offre->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="space-y-8">

                        <!-- Photo Upload avec Preview -->
                        <div x-data="{ photoUrl: '', photoName: '' }">
                            <label class="block text-sm font-bold mb-3 text-gray-800">Photo de profil pour cette candidature</label>
                            <div class="flex items-center gap-5">
                                <div class="shrink-0">
                                    <div class="size-20 rounded-full bg-gray-100 border-2 border-dashed border-gray-300 flex items-center justify-center overflow-hidden shadow-sm">
                                        <template x-if="photoUrl">
                                            <img :src="photoUrl" class="size-full object-cover">
                                        </template>
                                        <template x-if="!photoUrl">
                                            <span class="text-xl font-black text-gray-400 uppercase">{{ substr($etudiant->user->prenom ?? 'A', 0, 1) }}{{ substr($etudiant->user->nom ?? 'A', 0, 1) }}</span>
                                        </template>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <label for="form-photo-upload" class="group flex items-center gap-2 cursor-pointer text-indigo-600 hover:text-indigo-700 font-bold text-sm">
                                        <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                        <span x-text="photoName || 'Choisir une photo'"></span>
                                    </label>
                                    <p class="text-xs font-semibold text-gray-400 mt-1">JPG, PNG – Max 2MB</p>
                                    @error('photo')
                                        <p class="text-sm text-rose-600 font-semibold mt-1">{{ $message }}</p>
                                    @enderror
                                    <input id="form-photo-upload" name="photo" type="file" accept="image/*" class="hidden"
                                        @change="const file = $event.target.files[0]; if(file) { photoUrl = URL.createObjectURL(file); photoName = file.name; }">
                                </div>
                            </div>
                        </div>

                        <!-- CV Upload -->
                        <div x-data="{ fileName: '' }">
                            <label class="block text-sm font-bold mb-2 text-gray-800">Votre CV (PDF) <span class="text-rose-500">*</span></label>
                            <label for="cv-upload-form"
                                class="group p-6 flex flex-col items-center justify-center cursor-pointer text-center border-2 border-dashed border-gray-200 rounded-xl bg-gray-50 hover:bg-indigo-50/50 hover:border-indigo-300 transition-all">
                                <input id="cv-upload-form" name="cv" type="file" accept=".pdf" class="sr-only"
                                    @change="fileName = $event.target.files[0]?.name || ''">
                                <svg class="size-8 text-indigo-300 group-hover:text-indigo-500 transition-colors mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                                <span class="block text-sm text-indigo-700 font-bold mb-1" x-text="fileName || 'Télécharger le CV'"></span>
                                <span class="block text-xs font-bold text-gray-400 uppercase tracking-widest">Formats : PDF (Max. 20MB)</span>
                            </label>
                            @error('cv')
                                <p class="text-sm text-rose-600 font-semibold mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Motivation Letter -->
                        <div>
                            <label class="block text-sm font-bold mb-2 text-gray-800">Lettre de motivation <span class="text-rose-500">*</span></label>
                            <textarea name="message_motivation" rows="4"
                                class="py-3.5 px-4 block w-full border-gray-200 rounded-xl text-sm focus:border-indigo-500 focus:ring-indigo-500 transition shadow-sm @error('message_motivation') border-rose-300 focus:border-rose-500 focus:ring-rose-500 @enderror"
                                placeholder="Présentez brièvement vos atouts pour ce poste, vos motivations...">{{ old('message_motivation') }}</textarea>
                            @error('message_motivation')
                                <p class="text-sm text-rose-600 font-semibold mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Phone Number -->
                        <div>
                            <label class="block text-sm font-bold mb-2 text-gray-800">Numéro de téléphone <span class="text-rose-500">*</span></label>
                            <div class="relative">
                                <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none z-20 ps-4">
                                    <svg class="shrink-0 size-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                                </div>
                                <input type="tel" name="telephone" value="{{ old('telephone') }}"
                                    class="py-3 px-4 ps-11 block w-full border-gray-200 rounded-xl text-sm font-semibold focus:border-indigo-500 focus:ring-indigo-500 shadow-sm @error('telephone') border-rose-300 focus:border-rose-500 focus:ring-rose-500 @enderror"
                                    placeholder="06XXXXXXXX">
                            </div>
                            @error('telephone')
                                <p class="text-sm text-rose-600 font-semibold mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Portfolio Link -->
                        <div>
                            <label class="block text-sm font-bold mb-2 text-gray-800">Lien du Portfolio</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none z-20 ps-4">
                                    <svg class="shrink-0 size-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/></svg>
                                </div>
                                <input type="url" name="portfolio_url" value="{{ old('portfolio_url') }}"
                                    class="py-3 px-4 ps-11 block w-full border-gray-200 rounded-xl text-sm font-semibold focus:border-indigo-500 focus:ring-indigo-500 shadow-sm @error('portfolio_url') border-rose-300 focus:border-rose-500 focus:ring-rose-500 @enderror"
                                    placeholder="https://votresite.com">
                            </div>
                            @error('portfolio_url')
                                <p class="text-sm text-rose-600 font-semibold mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </form>
            </div>
            
            <!-- Footer -->
            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50 rounded-b-2xl flex justify-end shrink-0 gap-3">
                 <button onclick="closeCandidatureModal()" class="px-5 py-2.5 bg-white border border-gray-200 text-gray-700 rounded-xl text-sm font-bold shadow-sm hover:bg-gray-50 transition focus:outline-none">Annuler</button>
                 <button onclick="document.getElementById('candidature-form').submit()" class="px-5 py-2.5 bg-indigo-600 border border-transparent text-white rounded-xl text-sm font-bold shadow-md shadow-indigo-200 hover:bg-indigo-700 transition focus:outline-none">Soumettre</button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function openEntrepriseModal(id) {
        const wrapper = document.getElementById('entreprise-modal-wrapper');
        const card    = document.getElementById('entreprise-modal-card');
        const content = document.getElementById('modal-content-container');
        const spinner = document.getElementById('modal-loading-spinner');

        // Teleport the entire wrapper to body to escape ANY relative/z-index issues.
        if (wrapper.parentElement !== document.body) { 
            document.body.appendChild(wrapper); 
        }

        spinner.classList.remove('hidden');
        content.classList.replace('opacity-100', 'opacity-0');

        wrapper.style.display = 'block';
        document.body.style.overflow = 'hidden';

        // Trigger animations
        setTimeout(() => {
            wrapper.classList.remove('opacity-0');
            wrapper.classList.add('opacity-100');
            card.classList.remove('scale-95');
            card.classList.add('scale-100');
        }, 10);

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
                    initSpan.textContent = ent.lettreInitiale || (ent.nom_entreprise ? ent.nom_entreprise.charAt(0) : 'E');
                    initSpan.classList.remove('hidden');
                    logoImg.classList.add('hidden');
                }

                document.getElementById('modal-entreprise-name').textContent    = ent.nom_entreprise || 'Non renseigné';
                document.getElementById('modal-entreprise-secteur').textContent = ent.secteur || 'Non défini';
                document.getElementById('modal-entreprise-taille').textContent  = ent.taille || 'Non défini';
                document.getElementById('modal-entreprise-ville').textContent   = ent.ville ? ent.ville.nom : 'Non définie';

                // BIO: Check if empty, hide securely
                const bioSection = document.getElementById('modal-section-bio');
                if (ent.bio && ent.bio.trim() !== '') {
                    document.getElementById('modal-entreprise-bio').textContent = ent.bio;
                    bioSection.classList.remove('hidden');
                } else {
                    bioSection.classList.add('hidden');
                }

                // Info: RC
                const rcRow = document.getElementById('modal-contact-rc');
                if (ent.registre_commerce) { document.getElementById('modal-rc-text').textContent = ent.registre_commerce; rcRow.classList.remove('hidden'); }
                else { rcRow.classList.add('hidden'); }

                // Info: Adresse
                const adresseRow = document.getElementById('modal-contact-adresse');
                if (ent.adresse || (ent.ville && ent.ville.nom)) { 
                    document.getElementById('modal-adresse-text').textContent = ent.adresse || ent.ville.nom; 
                    adresseRow.classList.remove('hidden'); 
                } else { adresseRow.classList.add('hidden'); }

                // Info: Email
                const emailRow = document.getElementById('modal-contact-email');
                if (ent.email_contact) {
                    const emailEl = document.getElementById('modal-email-text');
                    emailEl.textContent = ent.email_contact;
                    emailEl.href = `mailto:${ent.email_contact}`;
                    emailRow.classList.remove('hidden');
                } else { emailRow.classList.add('hidden'); }

                // Offres
                const list  = document.getElementById('modal-offres-list');
                const empty = document.getElementById('modal-offres-empty');
                list.innerHTML = '';

                if (offres && offres.length > 0) {
                    empty.classList.add('hidden');
                    offres.forEach(offre => {
                        const descriptionShort = offre.description ? offre.description.substring(0, 180) + (offre.description.length > 180 ? '...' : '') : '';
                        list.innerHTML += `
                        <a href="/offres/${offre.id}" class="block bg-white border border-gray-100 rounded-xl p-4 hover:border-indigo-300 hover:shadow-md transition-all duration-300 group">
                            <h5 class="text-sm font-bold text-gray-900 group-hover:text-indigo-600 transition leading-snug mb-2.5">${offre.titre}</h5>
                            <div class="flex flex-wrap gap-2 mb-3">
                                ${offre.secteur ? `<span class="text-[10px] font-bold text-indigo-700 bg-indigo-50 border border-indigo-100 px-2 py-0.5 rounded-md">${offre.secteur}</span>` : ''}
                                ${offre.type_stage ? `<span class="text-[10px] font-bold text-gray-600 bg-gray-50 border border-gray-200 px-2 py-0.5 rounded-md">${offre.type_stage}</span>` : ''}
                                ${offre.duree ? `<span class="text-[10px] font-bold text-blue-700 bg-blue-50 border border-blue-100 px-2 py-0.5 rounded-md">${offre.duree}</span>` : ''}
                                ${offre.remuneration && offre.remuneration !== 'Non' && offre.remuneration !== 'Non rémunéré' ? `<span class="text-[10px] font-bold text-emerald-700 bg-emerald-50 border border-emerald-100 px-2 py-0.5 rounded-md">${offre.remuneration}</span>` : ''}
                            </div>
                            ${descriptionShort ? `<p class="text-[11px] text-gray-500 leading-relaxed mb-3 line-clamp-3">${descriptionShort}</p>` : ''}
                            <div class="flex justify-end mt-1">
                                <span class="inline-flex items-center gap-1 text-[10px] font-bold text-indigo-600 bg-indigo-50 px-2.5 py-1 rounded-lg group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                                    Détails <svg class="size-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                </span>
                            </div>
                        </a>`;
                    });
                } else {
                    empty.classList.remove('hidden');
                }

                setTimeout(() => {
                    spinner.classList.add('hidden');
                    content.classList.replace('opacity-0', 'opacity-100');
                }, 200);
            })
            .catch(() => {
                spinner.innerHTML = '<div class="bg-red-50 p-4 rounded-xl text-center"><p class="text-red-500 text-sm font-bold">Impossible de charger le profil.</p></div>';
            });
    }

    function closeEntrepriseModal() {
        const wrapper = document.getElementById('entreprise-modal-wrapper');
        const card    = document.getElementById('entreprise-modal-card');

        wrapper.classList.remove('opacity-100');
        wrapper.classList.add('opacity-0');
        card.classList.remove('scale-100');
        card.classList.add('scale-95');

        setTimeout(() => {
            wrapper.style.display = 'none';
            document.body.style.overflow = '';
        }, 300);
    }

    // Modal Candidature logic
    function openCandidatureModal() {
        const wrapper = document.getElementById('candidature-modal-wrapper');
        const card    = document.getElementById('candidature-modal-card');

        // Teleport to body
        if (wrapper.parentElement !== document.body) { 
            document.body.appendChild(wrapper); 
        }

        wrapper.style.display = 'block';
        document.body.style.overflow = 'hidden';

        setTimeout(() => {
            wrapper.classList.remove('opacity-0');
            wrapper.classList.add('opacity-100');
            card.classList.remove('scale-95');
            card.classList.add('scale-100');
        }, 10);
    }

    function closeCandidatureModal() {
        const wrapper = document.getElementById('candidature-modal-wrapper');
        const card    = document.getElementById('candidature-modal-card');

        wrapper.classList.remove('opacity-100');
        wrapper.classList.add('opacity-0');
        card.classList.remove('scale-100');
        card.classList.add('scale-95');

        setTimeout(() => {
            wrapper.style.display = 'none';
            document.body.style.overflow = '';
        }, 300);
    }

    @if($errors->any() && old('telephone') !== null)
        document.addEventListener('DOMContentLoaded', () => {
            openCandidatureModal();
        });
    @endif
</script>
@endpush
