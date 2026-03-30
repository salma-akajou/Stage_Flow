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

        <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-6 sm:p-8" data-aos="fade-up">
            <h3 class="text-lg font-black text-gray-800 mb-8 flex items-center gap-2 font-heading">
                <svg class="size-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                Informations personnelles
            </h3>

            <div class="mb-10 flex items-center gap-6" x-data="{ photoUrl: '{{ $etudiant->user->photo ? asset('storage/'.$etudiant->user->photo) : '' }}' }">
                <div class="relative group">
                    <div class="size-24 rounded-full bg-indigo-50 border-4 border-white shadow-md flex items-center justify-center overflow-hidden transition-transform group-hover:scale-105">
                        <template x-if="photoUrl">
                            <img :src="photoUrl" class="size-full object-cover">
                        </template>
                        <template x-if="!photoUrl">
                            <span class="text-indigo-600 font-black text-2xl uppercase font-heading">{{ substr($etudiant->user->prenom, 0, 1) }}{{ substr($etudiant->user->nom, 0, 1) }}</span>
                        </template>
                    </div>
                    <label for="profile-photo" class="absolute bottom-0 right-0 size-8 bg-indigo-600 text-white rounded-full flex items-center justify-center shadow-lg cursor-pointer transform hover:scale-110 active:scale-95 transition-all">
                        <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        <input id="profile-photo" name="photo" type="file" accept="image/*" class="sr-only" 
                            @change="const file = $event.target.files[0]; photoUrl = URL.createObjectURL(file);">
                    </label>
                </div>
                <div>
                    <span class="block text-sm font-black text-gray-800">Photo de profil</span>
                    <span class="block text-xs text-gray-400 mt-1">JPG, PNG (Max. 2MB)</span>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- Inputs -->
                <div class="space-y-2">
                    <label class="block text-sm font-bold text-gray-700">Prénom</label>
                    <input type="text" name="prenom" value="{{ $etudiant->user->prenom }}"
                        class="py-2.5 px-4 block w-full border-gray-200 rounded-xl text-sm focus:border-indigo-500 focus:ring-indigo-500 transition shadow-sm">
                </div>
                <div class="space-y-2">
                    <label class="block text-sm font-bold text-gray-700">Nom</label>
                    <input type="text" name="nom" value="{{ $etudiant->user->nom }}"
                        class="py-2.5 px-4 block w-full border-gray-200 rounded-xl text-sm focus:border-indigo-500 focus:ring-indigo-500 transition shadow-sm">
                </div>
                <div class="space-y-2">
                    <label class="block text-sm font-bold text-gray-700">Email (Non modifiable)</label>
                    <input type="email" value="{{ $etudiant->user->email }}" readonly
                        class="py-2.5 px-4 block w-full border-gray-200 rounded-xl text-sm bg-gray-50 text-gray-400 cursor-not-allowed">
                </div>
                <div class="space-y-2">
                    <label class="block text-sm font-bold text-gray-700">Ville</label>
                    <select name="ville_id" class="py-2.5 px-4 pe-9 block w-full border-gray-200 rounded-xl text-sm focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                        @foreach($villes as $ville)
                            <option value="{{ $ville->id }}" {{ $etudiant->ville_id == $ville->id ? 'selected' : '' }}>{{ $ville->nom }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-6 sm:p-8" data-aos="fade-up" data-aos-delay="100">
            <h3 class="text-lg font-black text-gray-800 mb-8 flex items-center gap-2 font-heading">
                <svg class="size-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/></svg>
                Parcours Académique
            </h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="block text-sm font-bold text-gray-700">École / Université</label>
                    <select name="etablissement" class="py-2.5 px-4 pe-9 block w-full border-gray-200 rounded-xl text-sm focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                        @foreach(['Solicode', 'Faculté', 'ISTA', 'EMSI', 'ENSI', 'BTS', 'Autre'] as $inst)
                            <option value="{{ $inst }}" {{ $etudiant->etablissement == $inst ? 'selected' : '' }}>{{ $inst }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="space-y-2">
                    <label class="block text-sm font-bold text-gray-700">Niveau d'études</label>
                    <select name="niveau_etudes" class="py-2.5 px-4 pe-9 block w-full border-gray-200 rounded-xl text-sm focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                        @foreach(['Bac+2', 'Bac+3', 'Master', 'Doctorat', 'Autre'] as $niv)
                            <option value="{{ $niv }}" {{ $etudiant->niveau_etudes == $niv ? 'selected' : '' }}>{{ $niv }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="space-y-2 sm:col-span-2">
                    <label class="block text-sm font-bold text-gray-700">Filière</label>
                    <input type="text" name="filiere" value="{{ $etudiant->filiere }}"
                        class="py-2.5 px-4 block w-full border-gray-200 rounded-xl text-sm focus:border-indigo-500 focus:ring-indigo-500 transition shadow-sm"
                        placeholder="Ex: Développement Fullstack">
                </div>
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-6 sm:p-8" data-aos="fade-up" data-aos-delay="200">
            <h3 class="text-lg font-black text-gray-800 mb-8 flex items-center gap-2 font-heading">
                <svg class="size-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                Profil Professionnel
            </h3>
            <div class="space-y-6">
                <div class="space-y-2">
                    <label class="block text-sm font-bold text-gray-700">À propos de moi (Bio)</label>
                    <textarea name="bio" rows="4"
                        class="py-3 px-4 block w-full border-gray-200 rounded-xl text-sm focus:border-indigo-500 focus:ring-indigo-500 transition shadow-sm"
                        placeholder="Décrivez vos compétences, vos passions technologiques...">{{ $etudiant->bio }}</textarea>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="block text-sm font-bold text-gray-700">Lien LinkedIn</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none ps-4">
                                <svg class="size-4 text-gray-400" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                            </div>
                            <input type="url" name="linkedin" value="{{ $etudiant->linkedin }}"
                                class="py-2.5 ps-11 pe-4 block w-full border-gray-200 rounded-xl text-sm focus:border-indigo-500 focus:ring-indigo-500 shadow-sm"
                                placeholder="https://linkedin.com/in/username">
                        </div>
                    </div>
                    <div class="space-y-2">
                        <label class="block text-sm font-bold text-gray-700">Lien GitHub</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none ps-4">
                                <svg class="size-4 text-gray-400" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/></svg>
                            </div>
                            <input type="url" name="github" value="{{ $etudiant->github }}"
                                class="py-2.5 ps-11 pe-4 block w-full border-gray-200 rounded-xl text-sm focus:border-indigo-500 focus:ring-indigo-500 shadow-sm"
                                placeholder="https://github.com/username">
                        </div>
                    </div>
                </div>
            </div>
        </div>

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
