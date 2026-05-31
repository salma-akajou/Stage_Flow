<!DOCTYPE html>
<html lang="fr" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - StageFlow</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography"></script>
    <script src="https://cdn.jsdelivr.net/npm/preline/dist/preline.js" defer></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Outfit:wght@600;700;800&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: { 50: '#eef2ff', 100: '#e0e7ff', 200: '#c7d2fe', 300: '#a5b4fc', 400: '#818cf8', 500: '#6366f1', 600: '#4f46e5', 700: '#4338ca', 800: '#3730a3', 900: '#312e81', 950: '#1e1b4b' },
                    },
                    fontFamily: { sans: ['Inter', 'sans-serif'], heading: ['Outfit', 'sans-serif'] },
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .font-heading { font-family: 'Outfit', sans-serif; }
        [x-cloak] { display: none !important; }
        .file-input-wrapper:hover .file-input-btn { @apply bg-indigo-100; }
    </style>
</head>
<body class="bg-[#fafbfc] min-h-full flex flex-col items-center justify-center relative overflow-x-hidden py-12">

    <!-- Background Decor -->
    <div class="fixed inset-0 pointer-events-none z-0 text-indigo-500/10">
        <div class="absolute top-[-15%] left-[-10%] size-[800px] bg-gradient-to-br from-indigo-500/15 via-purple-500/10 to-transparent rounded-full blur-[140px] animate-pulse"></div>
        <div class="absolute bottom-[-15%] right-[-10%] size-[800px] bg-gradient-to-tr from-purple-500/15 via-indigo-500/10 to-transparent rounded-full blur-[140px] animate-pulse" style="animation-delay: 3s;"></div>
    </div>

    <main class="w-full max-w-xl p-6 relative z-10" data-aos="fade-up">
        <!-- Logo -->
        <div class="text-center mb-10">
            <a href="{{ route('landing') }}" class="inline-flex items-center gap-x-3 group">
                <img src="{{ asset('logo_app.png') }}" alt="Logo" class="size-10 object-contain group-hover:rotate-12 transition-transform">
                <span class="text-2xl font-black font-heading text-slate-900 tracking-tight">StageFlow</span>
            </a>
        </div>

        <!-- Auth Card -->
        <div class="bg-white rounded-[3rem] shadow-2xl shadow-indigo-100/50 border border-slate-100 p-8 lg:p-12 relative overflow-hidden">
            <div class="absolute -top-10 -right-10 w-64 h-64 bg-indigo-50/50 rounded-full blur-3xl opacity-50"></div>
            
            <div class="text-center mb-10">
                <h1 class="text-3xl font-black font-heading text-slate-900 mb-2">Créez votre futur Profil</h1>
                <p class="text-sm font-medium text-slate-500">Rejoignez l'élite des stagiaires et recruteurs au Maroc</p>
            </div>

            <form action="{{ route('register') }}" method="POST" enctype="multipart/form-data" class="space-y-6" x-data="{ role: '{{ old('role', '') }}', fileName: 'Aucun fichier choisi' }">
                @csrf

                <!-- Common Fields -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-widest text-slate-400 mb-2 ml-1">Prénom</label>
                        <input type="text" name="prenom" value="{{ old('prenom') }}" class="py-3.5 px-5 block w-full border-slate-200 rounded-2xl text-sm focus:border-indigo-500 focus:ring-indigo-500 transition-all font-medium" placeholder="Prénom" required>
                        @error('prenom') <p class="text-[10px] text-rose-500 font-bold mt-1 ml-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-widest text-slate-400 mb-2 ml-1">Nom</label>
                        <input type="text" name="nom" value="{{ old('nom') }}" class="py-3.5 px-5 block w-full border-slate-200 rounded-2xl text-sm focus:border-indigo-500 focus:ring-indigo-500 transition-all font-medium" placeholder="Nom" required>
                        @error('nom') <p class="text-[10px] text-rose-500 font-bold mt-1 ml-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-widest text-slate-400 mb-2 ml-1">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="py-3.5 px-5 block w-full border-slate-200 rounded-2xl text-sm focus:border-indigo-500 focus:ring-indigo-500 transition-all font-medium" placeholder="nom@exemple.com" required>
                    @error('email') <p class="text-[10px] text-rose-500 font-bold mt-1 ml-1">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-widest text-slate-400 mb-2 ml-1">Mot de passe</label>
                        <input type="password" name="password" class="py-3.5 px-5 block w-full border-slate-200 rounded-2xl text-sm focus:border-indigo-500 focus:ring-indigo-500 transition-all font-medium" placeholder="••••••••" required>
                        @error('password') <p class="text-[10px] text-rose-500 font-bold mt-1 ml-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-widest text-slate-400 mb-2 ml-1">Confirmation</label>
                        <input type="password" name="password_confirmation" class="py-3.5 px-5 block w-full border-slate-200 rounded-2xl text-sm focus:border-indigo-500 focus:ring-indigo-500 transition-all font-medium" placeholder="••••••••" required>
                    </div>
                </div>

                <!-- Role Selection -->
                <div>
                    <label class="block text-xs font-bold uppercase tracking-widest text-slate-400 mb-3 ml-1 text-center">Quel est votre profil ?</label>
                    <div class="grid grid-cols-2 gap-4">
                        <label class="flex items-center p-4 w-full bg-white border border-slate-100 rounded-[2rem] shadow-sm cursor-pointer hover:bg-slate-50 transition-all group" :class="{ 'border-indigo-600 ring-2 ring-indigo-500/20 bg-indigo-50/30': role === 'etudiant' }">
                            <input type="radio" name="role" value="etudiant" x-model="role" class="shrink-0 border-slate-200 rounded-full text-indigo-600 focus:ring-indigo-500">
                            <span class="text-sm font-black text-slate-700 ms-3 uppercase tracking-widest group-hover:text-indigo-600 transition">Étudiant</span>
                        </label>
                        <label class="flex items-center p-4 w-full bg-white border border-slate-100 rounded-[2rem] shadow-sm cursor-pointer hover:bg-slate-50 transition-all group" :class="{ 'border-indigo-600 ring-2 ring-indigo-500/20 bg-indigo-50/30': role === 'entreprise' }">
                            <input type="radio" name="role" value="entreprise" x-model="role" class="shrink-0 border-slate-200 rounded-full text-indigo-600 focus:ring-indigo-500">
                            <span class="text-sm font-black text-slate-700 ms-3 uppercase tracking-widest group-hover:text-indigo-600 transition">Entreprise</span>
                        </label>
                    </div>
                    @error('role') <p class="text-[10px] text-rose-500 font-bold mt-2 text-center">{{ $message }}</p> @enderror
                </div>


                <!-- Dynamic Student Fields -->
                <div x-show="role === 'etudiant'" x-transition class="space-y-6 pt-6 border-t border-slate-50">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-widest text-slate-400 mb-2 ml-1">Établissement</label>
                            <div x-data="{
                                open: false,
                                value: '{{ old('etablissement', 'Solicode') }}',
                                labels: { 'Solicode': 'Solicode', 'Faculté': 'Faculté', 'ISTA': 'ISTA', 'EMSI': 'EMSI', 'ENSI': 'ENSI', 'BTS': 'BTS', 'Autre': 'Autre' }
                            }" class="relative">
                                <input type="hidden" name="etablissement" x-model="value" :disabled="role !== 'etudiant'">
                                <button @click="open = !open" type="button" class="w-full flex justify-between items-center py-3.5 px-5 border border-slate-200 rounded-2xl text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 font-medium bg-white text-slate-700 transition">
                                    <span x-text="labels[value]"></span>
                                    <svg class="size-4 text-slate-400 transition-transform" :class="{ 'rotate-180': open }" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                                </button>
                                <div x-show="open" @click.outside="open = false" x-transition class="absolute z-50 w-full mt-2 bg-white border border-slate-100 rounded-2xl shadow-xl p-2 max-h-60 overflow-y-auto">
                                    <template x-for="(label, key) in labels" :key="key">
                                        <div @click="value = key; open = false" class="px-4 py-2.5 rounded-xl text-sm text-slate-700 hover:bg-indigo-50 hover:text-indigo-600 cursor-pointer font-semibold transition" :class="{ 'bg-indigo-50/50 text-indigo-600': value === key }">
                                            <span x-text="label"></span>
                                        </div>
                                    </template>
                                </div>
                            </div>
                            @error('etablissement') <p class="text-[10px] text-rose-500 font-bold mt-1 ml-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-widest text-slate-400 mb-2 ml-1">Filière</label>
                            <input type="text" name="filiere" :disabled="role !== 'etudiant'" value="{{ old('filiere') }}" class="py-3.5 px-5 block w-full border-slate-200 rounded-2xl text-sm focus:border-indigo-500 focus:ring-indigo-500 font-medium" placeholder="Génie Logiciel">
                            @error('filiere') <p class="text-[10px] text-rose-500 font-bold mt-1 ml-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-widest text-slate-400 mb-2 ml-1">Niveau d'études</label>
                            <div x-data="{
                                open: false,
                                value: '{{ old('niveau_etude', 'Bac+2') }}',
                                labels: { 'Bac+2': 'Bac +2', 'Bac+3': 'Bac +3', 'Master': 'Master', 'Doctorat': 'Doctorat', 'Autre': 'Autre' }
                            }" class="relative">
                                <input type="hidden" name="niveau_etude" x-model="value" :disabled="role !== 'etudiant'">
                                <button @click="open = !open" type="button" class="w-full flex justify-between items-center py-3.5 px-5 border border-slate-200 rounded-2xl text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 font-medium bg-white text-slate-700 transition">
                                    <span x-text="labels[value]"></span>
                                    <svg class="size-4 text-slate-400 transition-transform" :class="{ 'rotate-180': open }" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                                </button>
                                <div x-show="open" @click.outside="open = false" x-transition class="absolute z-50 w-full mt-2 bg-white border border-slate-100 rounded-2xl shadow-xl p-2 max-h-60 overflow-y-auto">
                                    <template x-for="(label, key) in labels" :key="key">
                                        <div @click="value = key; open = false" class="px-4 py-2.5 rounded-xl text-sm text-slate-700 hover:bg-indigo-50 hover:text-indigo-600 cursor-pointer font-semibold transition" :class="{ 'bg-indigo-50/50 text-indigo-600': value === key }">
                                            <span x-text="label"></span>
                                        </div>
                                    </template>
                                </div>
                            </div>
                            @error('niveau_etude') <p class="text-[10px] text-rose-500 font-bold mt-1 ml-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-widest text-slate-400 mb-2 ml-1">Ville</label>
                            <div x-data="{ open: false, value: '{{ old('ville_id', $villes->first()->id ?? '') }}', label: '{{ old('ville_id') ? $villes->find(old('ville_id'))?->nom : ($villes->first()->nom ?? '') }}' }" class="relative">
                                <input type="hidden" name="ville_id" x-model="value" :disabled="role !== 'etudiant'">
                                <button @click="open = !open" type="button" class="w-full flex justify-between items-center py-3.5 px-5 border border-slate-200 rounded-2xl text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 font-medium bg-white text-slate-700 transition">
                                    <span x-text="label"></span>
                                    <svg class="size-4 text-slate-400 transition-transform" :class="{ 'rotate-180': open }" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                                </button>
                                <div x-show="open" @click.outside="open = false" x-transition class="absolute z-50 w-full mt-2 bg-white border border-slate-100 rounded-2xl shadow-xl p-2 max-h-60 overflow-y-auto">
                                    @foreach($villes as $ville)
                                    <div @click="value = '{{ $ville->id }}'; label = '{{ $ville->nom }}'; open = false" class="px-4 py-2.5 rounded-xl text-sm text-slate-700 hover:bg-indigo-50 hover:text-indigo-600 cursor-pointer font-semibold transition" :class="{ 'bg-indigo-50/50 text-indigo-600': value === '{{ $ville->id }}' }">
                                        {{ $ville->nom }}
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @error('ville_id') <p class="text-[10px] text-rose-500 font-bold mt-1 ml-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-widest text-slate-400 mb-2 ml-1">À propos de moi (Bio)</label>
                        <textarea name="bio_etudiant" :disabled="role !== 'etudiant'" rows="3" class="py-3.5 px-5 block w-full border-slate-200 rounded-2xl text-sm focus:border-indigo-500 focus:ring-indigo-500 transition-all font-medium" placeholder="Décrivez votre parcours en quelques mots...">{{ old('bio_etudiant') }}</textarea>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-widest text-slate-400 mb-2 ml-1">LinkedIn</label>
                            <input type="url" name="linkedin" :disabled="role !== 'etudiant'" value="{{ old('linkedin') }}" class="py-3.5 px-5 block w-full border-slate-200 rounded-2xl text-sm focus:border-indigo-500 focus:ring-indigo-500 transition-all font-medium" placeholder="https://linkedin.com/in/...">
                            @error('linkedin') <p class="text-[10px] text-rose-500 font-bold mt-1 ml-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-widest text-slate-400 mb-2 ml-1">GitHub</label>
                            <input type="url" name="github" :disabled="role !== 'etudiant'" value="{{ old('github') }}" class="py-3.5 px-5 block w-full border-slate-200 rounded-2xl text-sm focus:border-indigo-500 focus:ring-indigo-500 transition-all font-medium" placeholder="https://github.com/...">
                            @error('github') <p class="text-[10px] text-rose-500 font-bold mt-1 ml-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div class="space-y-2">
                        <label class="block text-xs font-bold uppercase tracking-widest text-slate-400 mb-2 ml-1">Photo de profil</label>
                        <div class="relative group cursor-pointer">
                            <input type="file" name="photo" :disabled="role !== 'etudiant'" @change="fileName = $event.target.files[0].name" class="absolute inset-0 w-full h-full opacity-0 z-20 cursor-pointer">
                            <div class="py-4 px-6 bg-slate-50 border-2 border-dashed border-slate-200 rounded-2xl flex items-center gap-4 transition-all group-hover:bg-indigo-50 group-hover:border-indigo-200">
                                <div class="size-10 bg-white rounded-xl shadow-sm flex items-center justify-center text-indigo-600">
                                    <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                </div>
                                <span class="text-sm font-bold text-slate-500 truncate" x-text="fileName"></span>
                            </div>
                        </div>
                        @error('photo') <p class="text-[10px] text-rose-500 font-bold mt-1 ml-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <!-- Dynamic Company Fields -->
                <div x-show="role === 'entreprise'" x-transition x-cloak class="space-y-6 pt-6 border-t border-slate-50">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-widest text-slate-400 mb-2 ml-1">Nom Entreprise</label>
                            <input type="text" name="nom_entreprise" :disabled="role !== 'entreprise'" value="{{ old('nom_entreprise') }}" class="py-3.5 px-5 block w-full border-slate-200 rounded-2xl text-sm focus:border-indigo-500 focus:ring-indigo-500 font-medium" placeholder="OCP Group">
                            @error('nom_entreprise') <p class="text-[10px] text-rose-500 font-bold mt-1 ml-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-widest text-slate-400 mb-2 ml-1">Secteur</label>
                            <div x-data="{
                                open: false,
                                value: '{{ old('secteur', 'Informatique') }}',
                                labels: { 'Informatique': 'Informatique', 'Design': 'Design', 'Marketing': 'Marketing', 'Commerce': 'Commerce', 'Industrie': 'Industrie', 'Autre': 'Autre' }
                            }" class="relative">
                                <input type="hidden" name="secteur" x-model="value" :disabled="role !== 'entreprise'">
                                <button @click="open = !open" type="button" class="w-full flex justify-between items-center py-3.5 px-5 border border-slate-200 rounded-2xl text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 font-medium bg-white text-slate-700 transition">
                                    <span x-text="labels[value]"></span>
                                    <svg class="size-4 text-slate-400 transition-transform" :class="{ 'rotate-180': open }" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                                </button>
                                <div x-show="open" @click.outside="open = false" x-transition class="absolute z-50 w-full mt-2 bg-white border border-slate-100 rounded-2xl shadow-xl p-2 max-h-60 overflow-y-auto">
                                    <template x-for="(label, key) in labels" :key="key">
                                        <div @click="value = key; open = false" class="px-4 py-2.5 rounded-xl text-sm text-slate-700 hover:bg-indigo-50 hover:text-indigo-600 cursor-pointer font-semibold transition" :class="{ 'bg-indigo-50/50 text-indigo-600': value === key }">
                                            <span x-text="label"></span>
                                        </div>
                                    </template>
                                </div>
                            </div>
                            @error('secteur') <p class="text-[10px] text-rose-500 font-bold mt-1 ml-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-widest text-slate-400 mb-2 ml-1">Taille</label>
                            <div x-data="{
                                open: false,
                                value: '{{ old('taille', 'TPE / PME') }}',
                                labels: { 'TPE / PME': 'TPE / PME', 'Grande Entreprise': 'Grande Entreprise', 'Multinationale': 'Multinationale' }
                            }" class="relative">
                                <input type="hidden" name="taille" x-model="value" :disabled="role !== 'entreprise'">
                                <button @click="open = !open" type="button" class="w-full flex justify-between items-center py-3.5 px-5 border border-slate-200 rounded-2xl text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 font-medium bg-white text-slate-700 transition">
                                    <span x-text="labels[value]"></span>
                                    <svg class="size-4 text-slate-400 transition-transform" :class="{ 'rotate-180': open }" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                                </button>
                                <div x-show="open" @click.outside="open = false" x-transition class="absolute z-50 w-full mt-2 bg-white border border-slate-100 rounded-2xl shadow-xl p-2 max-h-60 overflow-y-auto">
                                    <template x-for="(label, key) in labels" :key="key">
                                        <div @click="value = key; open = false" class="px-4 py-2.5 rounded-xl text-sm text-slate-700 hover:bg-indigo-50 hover:text-indigo-600 cursor-pointer font-semibold transition" :class="{ 'bg-indigo-50/50 text-indigo-600': value === key }">
                                            <span x-text="label"></span>
                                        </div>
                                    </template>
                                </div>
                            </div>
                            @error('taille') <p class="text-[10px] text-rose-500 font-bold mt-1 ml-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-widest text-slate-400 mb-2 ml-1">Ville du siège</label>
                            <div x-data="{ open: false, value: '{{ old('ville_id', $villes->first()->id ?? '') }}', label: '{{ old('ville_id') ? $villes->find(old('ville_id'))?->nom : ($villes->first()->nom ?? '') }}' }" class="relative">
                                <input type="hidden" name="ville_id" x-model="value" :disabled="role !== 'entreprise'">
                                <button @click="open = !open" type="button" class="w-full flex justify-between items-center py-3.5 px-5 border border-slate-200 rounded-2xl text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 font-medium bg-white text-slate-700 transition">
                                    <span x-text="label"></span>
                                    <svg class="size-4 text-slate-400 transition-transform" :class="{ 'rotate-180': open }" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                                </button>
                                <div x-show="open" @click.outside="open = false" x-transition class="absolute z-50 w-full mt-2 bg-white border border-slate-100 rounded-2xl shadow-xl p-2 max-h-60 overflow-y-auto">
                                    @foreach($villes as $ville)
                                    <div @click="value = '{{ $ville->id }}'; label = '{{ $ville->nom }}'; open = false" class="px-4 py-2.5 rounded-xl text-sm text-slate-700 hover:bg-indigo-50 hover:text-indigo-600 cursor-pointer font-semibold transition" :class="{ 'bg-indigo-50/50 text-indigo-600': value === '{{ $ville->id }}' }">
                                        {{ $ville->nom }}
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @error('ville_id') <p class="text-[10px] text-rose-500 font-bold mt-1 ml-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-widest text-slate-400 mb-2 ml-1">Adresse complète</label>
                            <input type="text" name="adresse" :disabled="role !== 'entreprise'" value="{{ old('adresse') }}" class="py-3.5 px-5 block w-full border-slate-200 rounded-2xl text-sm focus:border-indigo-500 focus:ring-indigo-500 font-medium" placeholder="12 Rue des Oliviers">
                            @error('adresse') <p class="text-[10px] text-rose-500 font-bold mt-1 ml-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-widest text-slate-400 mb-2 ml-1">Email de contact RH</label>
                            <input type="email" name="email_contact" :disabled="role !== 'entreprise'" value="{{ old('email_contact') }}" class="py-3.5 px-5 block w-full border-slate-200 rounded-2xl text-sm focus:border-indigo-500 focus:ring-indigo-500 font-medium" placeholder="rh@entreprise.ma">
                            @error('email_contact') <p class="text-[10px] text-rose-500 font-bold mt-1 ml-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-widest text-slate-400 mb-2 ml-1">Registre de Commerce (RC)</label>
                        <input type="text" name="registre_commerce" :disabled="role !== 'entreprise'" value="{{ old('registre_commerce') }}" class="py-3.5 px-5 block w-full border-slate-200 rounded-2xl text-sm focus:border-indigo-500 focus:ring-indigo-500 font-medium" placeholder="RC 123456">
                        @error('registre_commerce') <p class="text-[10px] text-rose-500 font-bold mt-1 ml-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-widest text-slate-400 mb-2 ml-1">Présentation de l'entreprise</label>
                        <textarea name="bio_entreprise" :disabled="role !== 'entreprise'" rows="3" class="py-3.5 px-5 block w-full border-slate-200 rounded-2xl text-sm focus:border-indigo-500 focus:ring-indigo-500 transition-all font-medium" placeholder="Parlez-nous de vos missions...">{{ old('bio_entreprise') }}</textarea>
                    </div>
                    <div class="space-y-2">
                        <label class="block text-xs font-bold uppercase tracking-widest text-slate-400 mb-2 ml-1">Logo de l'entreprise</label>
                        <div class="relative group cursor-pointer">
                            <input type="file" name="logo" :disabled="role !== 'entreprise'" @change="fileName = $event.target.files[0].name" class="absolute inset-0 w-full h-full opacity-0 z-20 cursor-pointer">
                            <div class="py-4 px-6 bg-slate-50 border-2 border-dashed border-slate-200 rounded-2xl flex items-center gap-4 transition-all group-hover:bg-indigo-50 group-hover:border-indigo-200">
                                <div class="size-10 bg-white rounded-xl shadow-sm flex items-center justify-center text-indigo-600">
                                    <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                </div>
                                <span class="text-sm font-bold text-slate-500 truncate" x-text="fileName"></span>
                            </div>
                        </div>
                        @error('logo') <p class="text-[10px] text-rose-500 font-bold mt-1 ml-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full py-4 px-6 inline-flex justify-center items-center gap-x-2 text-sm font-bold rounded-2xl border border-transparent bg-indigo-600 text-white hover:bg-indigo-700 shadow-xl shadow-indigo-100 transition-all hover:scale-[1.02] active:scale-[0.98]">
                    Créer mon compte
                </button>
            </form>

            <!-- Footer -->
            <p class="mt-8 text-center text-sm font-medium text-slate-500 border-t border-slate-50 pt-6">
                Déjà membre ?
                <a class="text-indigo-600 font-bold hover:text-indigo-700 transition" href="{{ route('login') }}">
                    Se connecter
                </a>
            </p>
        </div>

        <div class="mt-8 text-center">
            <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-slate-400">© 2026 StageFlow Maroc</p>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            AOS.init({ once: true, duration: 800 });
        });
    </script>
</body>
</html>
