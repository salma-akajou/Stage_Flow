@extends('layouts.student')

@section('title', $offre->titre . ' - StageFlow')
@section('breadcrumb', 'Détail de l\'Offre')

@section('content')
<div class="max-w-5xl mx-auto space-y-8">
    <div data-aos="fade-down">
        <a class="inline-flex items-center gap-x-1.5 text-sm text-gray-600 decoration-2 hover:underline font-medium hover:text-indigo-600 transition"
            href="{{ route('student.offres.index') }}">
            <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round">
                <path d="m15 18-6-6 6-6" />
            </svg>
            Retour au catalogue
        </a>
    </div>

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
        <div class="lg:col-span-2 space-y-8">
            <div class="bg-white border border-gray-200 shadow-sm rounded-2xl p-6 sm:p-8" data-aos="fade-up">
                <h2 class="text-xl font-bold text-gray-800 mb-6 font-heading">À propos de l'offre</h2>
                <div class="text-gray-600 leading-relaxed space-y-4 mb-10">
                    {!! nl2br(e($offre->description)) !!}
                </div>

                <div class="border-t border-gray-100 pt-10">
                    <h3 class="text-lg font-bold text-gray-800 mb-6 font-heading">Vos responsabilités</h3>
                    <ul class="space-y-5 text-sm text-gray-600">
                        @php
                            $resps = preg_split('/[\n|]+/', $offre->responsabilites);
                        @endphp
                        @foreach($resps as $resp)
                            @php $resp = trim(ltrim(trim($resp), '-•*')); @endphp
                            @if(!empty($resp))
                                <li class="flex gap-x-3">
                                    <span class="size-6 flex justify-center items-center rounded-full bg-indigo-50 text-indigo-600 shrink-0">
                                        <svg class="size-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    </span>
                                    <span class="pt-0.5 leading-relaxed">{{ $resp }}</span>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="bg-white border border-gray-200 shadow-sm rounded-2xl p-6 sm:p-8" data-aos="fade-up">
                <h3 class="text-xl font-bold text-gray-800 mb-6 font-heading">Profil recherché</h3>
                <ul class="space-y-4 text-sm text-gray-600">
                    @php
                        $profils = preg_split('/[\n|]+/', $offre->profil_recherche);
                    @endphp
                    @foreach($profils as $profil)
                        @php $profil = trim(ltrim(trim($profil), '-•*')); @endphp
                        @if(!empty($profil))
                            <li class="flex gap-x-3">
                                <div class="h-2 w-2 bg-indigo-600 rounded-full mt-2 shrink-0 shadow-sm shadow-indigo-200"></div>
                                <span class="pt-0.5">{{ $profil }}</span>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="space-y-6">
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
                        @php
                            $skills = is_array($offre->competences_techniques) ? $offre->competences_techniques : json_decode($offre->competences_techniques, true) ?? [];
                        @endphp
                        @foreach($skills as $index => $skill)
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

    @include('components.student.profil-entreprise-modal')

    @include('components.student.candidatures.modal-form-candidature')

@endsection

@push('scripts')
<script>
    @if($errors->any())
        document.addEventListener('DOMContentLoaded', () => {
            openCandidatureModal();
        });
    @endif
</script>
@endpush
