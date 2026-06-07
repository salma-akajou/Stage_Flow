<!DOCTYPE html>
<html lang="fr" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Espace Entreprise - StageFlow')</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography"></script>
    <script src="https://cdn.jsdelivr.net/npm/preline/dist/preline.js" defer></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Outfit:wght@600;700;800&display=swap" rel="stylesheet">

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

        .sticker-float {
            animation: stickerFloat 12s ease-in-out infinite;
        }

        .sticker-float-slow {
            animation: stickerFloat 18s ease-in-out infinite;
        }

        @keyframes stickerFloat {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            33% { transform: translateY(-20px) rotate(5deg); }
            66% { transform: translateY(10px) rotate(-3deg); }
        }

        .bg-enterprise {
            background-color: #f8fafc;
            background-image:
                radial-gradient(at 0% 0%, hsla(235, 80%, 65%, 0.06) 0, transparent 60%),
                radial-gradient(at 100% 0%, hsla(250, 90%, 68%, 0.05) 0, transparent 60%),
                radial-gradient(at 50% 100%, hsla(220, 80%, 70%, 0.04) 0, transparent 60%);
        }

        .stat-card {
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px -5px rgba(79, 70, 229, 0.12);
        }
    </style>
</head>
<body class="bg-mesh h-full overflow-x-hidden">
    
    @include('components.entreprise.topbar')
    @include('components.entreprise.sidebar')

    <main class="w-full h-full lg:ps-64 relative z-0">
        <div class="absolute inset-0 pointer-events-none overflow-hidden z-[-1] opacity-[0.05]">
            <div class="absolute top-10 left-10 sticker-float"><svg class="size-48 text-indigo-600" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5z"/></svg></div>
            <div class="absolute top-[50%] right-10 sticker-float" style="animation-delay: -2s"><svg class="size-32 text-indigo-500" fill="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/></svg></div>
            <div class="absolute bottom-20 left-[20%] sticker-float" style="animation-delay: -4s"><svg class="size-60 text-indigo-400 rotate-12" fill="currentColor" viewBox="0 0 24 24"><rect x="4" y="4" width="16" height="16" rx="2"/></svg></div>
        </div>

        <div class="p-4 sm:p-6 lg:p-8 space-y-6 sm:space-y-10">
            @yield('content')
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            AOS.init({ duration: 800, once: true });
        });

        document.addEventListener('alpine:init', () => {
            Alpine.store('toast', {
                show: false,
                message: '',
                type: 'success',
                display(message, type = 'success') {
                    this.show = true;
                    this.message = message;
                    this.type = type;
                    setTimeout(() => { this.show = false }, 3000);
                }
            });

            Alpine.store('confirm', {
                show: false,
                title: '',
                message: '',
                type: 'warning',
                onConfirm: null,
                open(title, message, callback, type = 'warning') {
                    this.title = title;
                    this.message = message;
                    this.onConfirm = callback;
                    this.type = type;
                    this.show = true;
                },
                execute() {
                    if (this.onConfirm) this.onConfirm();
                    this.show = false;
                }
            });
        });

        async function openStudentProfile(id) {
            const wrapper = document.getElementById('student-profile-modal-wrapper');
            const card = document.getElementById('student-profile-modal-card');
            if (!wrapper || !card) return;

            if (wrapper.parentElement !== document.body) document.body.appendChild(wrapper);
            
            wrapper.style.display = 'block';
            document.body.style.overflow = 'hidden';
            setTimeout(() => {
                wrapper.classList.remove('opacity-0');
                card.classList.remove('scale-95');
            }, 10);
            
            document.getElementById('stu-nom-complet').innerText = 'Chargement...';
            
            try {
                const response = await fetch(`/entreprise/candidatures/student/${id}`);
                const result = await response.json();
                if (result.success) {
                    const data = result.data;
                    document.getElementById('stu-nom-complet').innerText = `${data.prenom} ${data.nom}`;
                    document.getElementById('stu-email-text').innerText = data.email;
                    document.getElementById('stu-photo').src = data.photo;
                    document.getElementById('stu-filiere-badge').innerText = data.filiere;
                    document.getElementById('stu-niveau-badge').innerText = data.niveau;
                    document.getElementById('stu-etablissement').innerText = data.etablissement || 'Étudiant';
                    document.getElementById('stu-ville').innerText = data.ville;
                    document.getElementById('stu-bio').innerText = data.bio;
                    document.getElementById('stu-vues').innerText = data.vues;
                    
                    document.getElementById('stu-email').href = `mailto:${data.email}`;

                    const gh = document.getElementById('stu-github');
                    const li = document.getElementById('stu-linkedin');
                    if (data.github) { gh.href = data.github; gh.style.display = 'flex'; } else { gh.style.display = 'none'; }
                    if (data.linkedin) { li.href = data.linkedin; li.style.display = 'flex'; } else { li.style.display = 'none'; }

                    const list = document.getElementById('stu-candidatures-list');
                    const empty = document.getElementById('stu-candidatures-empty');
                    list.innerHTML = '';
                    if (data.candidatures && data.candidatures.length > 0) {
                        empty.style.display = 'none';
                        data.candidatures.forEach(c => {
                            let badgeClass = 'bg-orange-50 text-orange-600 border-orange-100';
                            if (c.statut === 'Accepté') badgeClass = 'bg-emerald-50 text-emerald-600 border-emerald-100';
                            if (c.statut === 'Refusé') badgeClass = 'bg-rose-50 text-rose-600 border-rose-100';

                            list.innerHTML += `
                                <div class="bg-white p-5 rounded-3xl border border-gray-100 shadow-sm hover:shadow-md transition-all group">
                                    <div class="flex items-center justify-between mb-3">
                                        <div class="flex flex-col">
                                            <h5 class="text-[11px] font-black text-gray-900 uppercase tracking-tight">${c.offre}</h5>
                                            <p class="text-[9px] text-indigo-500 font-black uppercase tracking-tighter mt-0.5">${c.entreprise}</p>
                                        </div>
                                        <span class="text-[8px] font-black px-2.5 py-1 rounded-full border uppercase tracking-widest ${badgeClass}">${c.statut}</span>
                                    </div>
                                    <div class="flex items-center gap-3 pt-3 border-t border-gray-50">
                                        <div class="flex items-center gap-1">
                                            <svg class="size-3 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2-2v10a2 2 0 002 2z"/></svg>
                                            <span class="text-[8px] font-bold text-gray-400 uppercase tracking-tight">${c.secteur || 'Secteur'}</span>
                                        </div>
                                        <div class="flex items-center gap-1">
                                            <svg class="size-3 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2-2v12a2 2 0 002 2z"/></svg>
                                            <span class="text-[8px] font-bold text-gray-400 uppercase tracking-tight">${c.date}</span>
                                        </div>
                                    </div>
                                </div>`;
                        });
                    } else { empty.style.display = 'block'; }
                }
            } catch (error) { console.error('Erreur AJAX Profil:', error); }
        }

        function closeStudentProfileModal() {
            const wrapper = document.getElementById('student-profile-modal-wrapper');
            const card = document.getElementById('student-profile-modal-card');
            if (!wrapper || !card) return;
            wrapper.classList.add('opacity-0');
            card.classList.add('scale-95');
            setTimeout(() => { wrapper.style.display = 'none'; document.body.style.overflow = ''; }, 300);
        }
    </script>
    <div x-data x-show="$store.toast.show"
         class="fixed top-24 right-10 z-[9999] pointer-events-none w-full max-w-[300px]"
         x-cloak>
        <div x-show="$store.toast.show" 
             x-transition:enter="transform ease-out duration-300 transition"
             x-transition:enter-start="translate-y-[-20px] opacity-0 scale-95"
             x-transition:enter-end="translate-y-0 opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0 translate-y-[-20px]"
             :class="$store.toast.type == 'success' ? 'bg-white border-emerald-100 shadow-emerald-500/10' : 'bg-white border-rose-100 shadow-rose-500/10'"
             class="border rounded-2xl p-3 flex items-center gap-3 pointer-events-auto w-full shadow-xl backdrop-blur-sm bg-white/95">
            
            <div :class="$store.toast.type == 'success' ? 'bg-emerald-500' : 'bg-rose-500'"
                 class="size-9 rounded-xl flex items-center justify-center shrink-0 text-white shadow-sm">
                <template x-if="$store.toast.type == 'success'">
                    <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                </template>
                <template x-if="$store.toast.type == 'error'">
                    <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </template>
            </div>
            
            <div class="flex-1">
                <p :class="$store.toast.type == 'success' ? 'text-emerald-900' : 'text-rose-900'" class="text-xs font-bold leading-tight" x-text="$store.toast.message"></p>
            </div>
            
            <button @click="$store.toast.show = false" class="text-gray-400 hover:text-gray-600 transition p-1.5 hover:bg-gray-50 rounded-lg">
                <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
    </div>

    <div x-data x-show="$store.confirm.show" 
         class="fixed inset-0 z-[10000] overflow-y-auto"
         x-cloak>
        <div class="flex items-center justify-center min-h-screen p-4 text-center">
            <div x-show="$store.confirm.show"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" @click="$store.confirm.show = false"></div>

            <div x-show="$store.confirm.show"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                 x-transition:leave-end="opacity-0 scale-95 translate-y-4"
                 class="relative bg-white rounded-[2rem] p-6 overflow-hidden shadow-2xl transform transition-all sm:max-w-md sm:w-full border border-gray-100">
                
                <div class="flex flex-col items-center">
                    <div :class="$store.confirm.type == 'warning' ? 'bg-amber-100 text-amber-600' : 'bg-rose-100 text-rose-600'" 
                         class="size-16 rounded-2xl flex items-center justify-center mb-5 shadow-sm">
                        <template x-if="$store.confirm.type == 'warning'">
                            <svg class="size-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                        </template>
                    </div>

                    <h3 class="text-xl font-black text-gray-900 mb-2 font-heading" x-text="$store.confirm.title"></h3>
                    <p class="text-sm text-gray-500 font-medium mb-8 leading-relaxed px-4" x-text="$store.confirm.message"></p>

                    <div class="flex gap-3 w-full">
                        <button @click="$store.confirm.show = false" type="button" 
                                class="flex-1 py-3 px-4 text-xs font-bold text-gray-500 bg-gray-50 hover:bg-gray-100 rounded-xl transition-all active:scale-95">
                            Annuler
                        </button>
                        <button @click="$store.confirm.execute()" type="button" 
                                :class="$store.confirm.type == 'warning' ? 'bg-indigo-600 hover:bg-indigo-700 shadow-indigo-100' : 'bg-rose-600 hover:bg-rose-700 shadow-rose-100'"
                                class="flex-1 py-3 px-4 text-xs font-bold text-white rounded-xl shadow-lg transition-all active:scale-95">
                            Confirmer
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('components.entreprise.profile-etudiant-modal')

    @stack('modals')
    <x-chatbot />
    @stack('scripts')
</body>
</html>
