<section class="relative overflow-hidden pt-6 lg:pt-12 min-h-[85vh] flex items-center">
    <div class="max-w-[85rem] mx-auto px-4 sm:px-6 lg:px-8 w-full">
        <div class="grid lg:grid-cols-2 gap-10 items-center">
            <div class="space-y-4" data-aos="fade-right">
                <div class="inline-flex items-center gap-x-2 py-1.5 px-4 rounded-full bg-indigo-50 border border-indigo-100">
                    <span class="size-2 rounded-full bg-indigo-600 animate-pulse"></span>
                    <span class="text-[10px] font-bold text-indigo-600 uppercase tracking-widest">StageFlow Premium</span>
                </div>

                <h1 class="text-5xl lg:text-7xl font-black font-heading text-slate-900 leading-tight">
                    Propulsez votre <br>
                    <span class="text-indigo-600">avenir</span> professionnel.
                </h1>

                <p class="text-lg text-slate-500 max-w-lg leading-relaxed font-medium">
                    La plateforme marocaine de référence pour connecter les étudiants ambitieux avec les meilleures entreprises du marché.
                </p>

                <div class="flex flex-wrap gap-4 pt-2">
                    <button class="py-4 px-8 inline-flex items-center gap-x-2 text-sm font-bold rounded-xl border border-transparent bg-indigo-600 text-white hover:bg-indigo-700 shadow-xl shadow-indigo-100 transition-all hover:scale-105 active:scale-95 group">
                        Rejoindre l'aventure
                        <svg class="size-4 group-hover:translate-x-1 transition-transform" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m9 18 6-6-6-6" />
                        </svg>
                    </button>
                    <a href="{{ route('entreprise.dashboard') }}" class="py-4 px-8 inline-flex items-center gap-x-2 text-sm font-bold rounded-xl border border-slate-200 bg-white text-slate-700 hover:bg-slate-50 transition-all">
                        Nos partenaires
                    </a>
                </div>
            </div>

            <div class="relative" data-aos="fade-left">
                <div class="relative z-10 w-full rounded-[2.5rem] overflow-hidden shadow-2xl border-4 border-white ring-1 ring-slate-100">
                    <img src="https://i.pinimg.com/1200x/e0/1e/8c/e01e8c03de998fc0aa35b45fafd88cea.jpg" alt="Professional workspace" class="w-full h-auto object-cover aspect-[4/3] transform hover:scale-105 transition-transform duration-700">
                    
                    <div class="absolute bottom-6 left-6 bg-white/95 backdrop-blur-md p-4 rounded-2xl shadow-2xl flex items-center gap-3 animate-float border border-white">
                        <div class="size-8 bg-emerald-100 rounded-lg flex items-center justify-center">
                            <svg class="size-4 text-emerald-600" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                                <polyline points="22 4 12 14.01 9 11.01" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-slate-900 leading-tight">Stage Trouvé !</p>
                            <p class="text-[8px] text-slate-500 font-bold uppercase tracking-widest">Secteur IT @Maroc</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
