@extends('layouts.app')

@section('title', 'StageFlow - Visez l\'excellence')

@section('content')
    <!-- Scroll Background Stickers (Atoms) -->
    <div class="fixed inset-0 pointer-events-none z-0 overflow-hidden">
        <div class="absolute top-[10%] left-[8%] text-5xl opacity-[0.08] animate-float">🎓</div>
        <div class="absolute top-[40%] right-[10%] text-6xl opacity-[0.08] animate-float-delayed">💼</div>
        <div class="absolute bottom-[20%] left-[12%] text-5xl opacity-[0.08] animate-float-slow">🚀</div>
        <div class="absolute bottom-[5%] right-[20%] text-5xl opacity-[0.08] animate-float-delayed">📚</div>
    </div>

    <!-- Hero Section -->
    <section class="relative overflow-hidden pt-6 lg:pt-12 min-h-[85vh] flex items-center">
        <div class="max-w-[85rem] mx-auto px-4 sm:px-6 lg:px-8 w-full">
            <div class="grid lg:grid-cols-2 gap-10 items-center">
                <!-- Text Content -->
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
                        <a href="{{ route('offres.index') }}" class="py-4 px-8 inline-flex items-center gap-x-2 text-sm font-bold rounded-xl border border-slate-200 bg-white text-slate-700 hover:bg-slate-50 transition-all">
                            Nos partenaires
                        </a>
                    </div>
                </div>

                <!-- Visual Content -->
                <div class="relative" data-aos="fade-left">
                    <div class="relative z-10 w-full rounded-[2.5rem] overflow-hidden shadow-2xl border-4 border-white ring-1 ring-slate-100">
                        <img src="https://i.pinimg.com/1200x/e0/1e/8c/e01e8c03de998fc0aa35b45fafd88cea.jpg" alt="Professional workspace" class="w-full h-auto object-cover aspect-[4/3] transform hover:scale-105 transition-transform duration-700">
                        
                        <!-- Floating Badge -->
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

    <!-- Stats -->
    <section class="py-24" data-aos="fade-up">
        <div class="max-w-[85rem] mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-12">
                <div class="text-center group p-8 rounded-[2.5rem] bg-indigo-50/30 hover:bg-white border border-transparent hover:border-indigo-100 transition-all duration-500">
                    <h2 class="text-5xl font-black font-heading text-slate-900 mb-3 group-hover:text-indigo-600 transition-colors">
                        {{ $stats['partenaires'] ?? '350' }}+</h2>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Partenaires</p>
                </div>
                <div class="text-center group p-8 rounded-[2.5rem] bg-indigo-50/30 hover:bg-white border border-transparent hover:border-indigo-100 transition-all duration-500">
                    <h2 class="text-5xl font-black font-heading text-slate-900 mb-3 group-hover:text-indigo-600 transition-colors">
                        {{ $stats['offres_an'] ?? '15k' }}</h2>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Offres / an</p>
                </div>
                <div class="text-center group p-8 rounded-[2.5rem] bg-indigo-50/30 hover:bg-white border border-transparent hover:border-indigo-100 transition-all duration-500">
                    <h2 class="text-5xl font-black font-heading text-slate-900 mb-3 group-hover:text-indigo-600 transition-colors">
                        {{ isset($stats['satisfaction']) && $stats['satisfaction'] > 0 ? number_format($stats['satisfaction'], 0).'%' : '92%' }}</h2>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Satisfaction</p>
                </div>
                <div class="text-center group p-8 rounded-[2.5rem] bg-indigo-50/30 hover:bg-white border border-transparent hover:border-indigo-100 transition-all duration-500">
                    <h2 class="text-5xl font-black font-heading text-slate-900 mb-3 group-hover:text-indigo-600 transition-colors">
                        48h</h2>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Rep. moyenne</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Experience -->
    <section id="experience" class="py-32 relative">
        <div class="max-w-[85rem] mx-auto px-4">
            <div class="text-center mb-20" data-aos="fade-up">
                <h2 class="text-4xl lg:text-5xl font-black font-heading text-slate-900 mb-6">L\'expérience StageFlow</h2>
                <p class="text-slate-500 max-w-2xl mx-auto text-lg">Tout ce dont vous avez besoin pour réussir votre recherche de stage ou votre recrutement, réuni sur une plateforme premium.</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <div class="group p-10 bg-white border border-slate-100 rounded-[3rem] shadow-sm hover:shadow-2xl hover:shadow-indigo-100/50 hover:-translate-y-2 transition-all duration-500" data-aos="fade-up" data-aos-delay="100">
                    <div class="size-16 bg-indigo-50 text-indigo-600 rounded-[1.5rem] flex items-center justify-center mb-8 text-3xl group-hover:bg-indigo-600 group-hover:text-white transition-colors duration-500">🔍</div>
                    <h3 class="text-2xl font-bold font-heading text-slate-900 mb-4">Matching Intelligent</h3>
                    <p class="text-slate-500 leading-relaxed">Notre algorithme propriétaire analyse votre profil pour vous suggérer les offres qui correspondent réellement à vos ambitions.</p>
                </div>
                <div class="group p-10 bg-white border border-slate-100 rounded-[3rem] shadow-sm hover:shadow-2xl hover:shadow-emerald-100/50 hover:-translate-y-2 transition-all duration-500" data-aos="fade-up" data-aos-delay="200">
                    <div class="size-16 bg-emerald-50 text-emerald-600 rounded-[1.5rem] flex items-center justify-center mb-8 text-3xl group-hover:bg-emerald-500 group-hover:text-white transition-colors duration-500">✨</div>
                    <h3 class="text-2xl font-bold font-heading text-slate-900 mb-4">Postulez en 1-Clic</h3>
                    <p class="text-slate-500 leading-relaxed">Gérez vos candidatures, suivez les retours des recruteurs et organisez vos entretiens depuis un tableau de bord immersif.</p>
                </div>
                <div class="group p-10 bg-white border border-slate-100 rounded-[3rem] shadow-sm hover:shadow-2xl hover:shadow-amber-100/50 hover:-translate-y-2 transition-all duration-500" data-aos="fade-up" data-aos-delay="300">
                    <div class="size-16 bg-amber-50 text-amber-600 rounded-[1.5rem] flex items-center justify-center mb-8 text-3xl group-hover:bg-amber-500 group-hover:text-white transition-colors duration-500">💎</div>
                    <h3 class="text-2xl font-bold font-heading text-slate-900 mb-4">Réseau Elite</h3>
                    <p class="text-slate-500 leading-relaxed">Accédez à des opportunités exclusives chez les leaders du marché technologique au Maroc.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="py-32 bg-slate-50 relative overflow-hidden">
        <div class="absolute top-0 right-0 p-20 opacity-5 text-9xl">💡</div>
        <div class="max-w-[85rem] mx-auto px-4 relative z-10">
            <div class="text-center mb-20" data-aos="fade-up">
                <h2 class="text-4xl font-black font-heading text-slate-900 mb-6">Ils nous font confiance</h2>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                @forelse($feedbacks as $feedback)
                <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100 flex flex-col h-full" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                    <div class="flex gap-1 text-amber-400 mb-4">
                        @for($i = 0; $i < 5; $i++)
                            @if($i < $feedback->note) ★ @else ☆ @endif
                        @endfor
                    </div>
                    <p class="text-slate-600 italic mb-8 flex-1">"{{ $feedback->texte }}"</p>
                    <div class="flex items-center gap-4">
                        <div class="size-12 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold overflow-hidden">
                            @if($feedback->auteur->photo)
                                <img src="{{ asset('storage/'.$feedback->auteur->photo) }}" class="size-full object-cover">
                            @else
                                {{ substr($feedback->auteur->prenom ?? 'U', 0, 1) }}{{ substr($feedback->auteur->nom ?? '', 0, 1) }}
                            @endif
                        </div>
                        <div>
                            <h4 class="font-bold text-slate-900 text-sm">{{ $feedback->auteur->prenom ?? '' }} {{ $feedback->auteur->nom ?? 'Utilisateur' }}</h4>
                            <p class="text-xs text-slate-400 font-bold uppercase tracking-widest">
                                @if($feedback->auteur->etudiant)
                                    Étudiant
                                @elseif($feedback->auteur->entreprise)
                                    Entreprise
                                @else
                                    Utilisateur
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
                @empty
                <!-- Mockup default testimonials (Photo 2 look) -->
                <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100" data-aos="fade-up">
                    <div class="flex gap-1 text-amber-400 mb-4">★★★★★</div>
                    <p class="text-slate-600 italic mb-8">"StageFlow m\'a permis de décrocher mon stage de fin d\'études chez OCP en moins de deux semaines. Une expérience fluide et premium !"</p>
                    <div class="flex items-center gap-4">
                        <img class="size-12 rounded-full object-cover" src="https://images.unsplash.com/photo-1531927557220-a9e23c1e4794?auto=format&fit=facearea&facepad=2&w=300&h=300&q=80" alt="Student">
                        <div>
                            <h4 class="font-bold text-slate-900 text-sm">Amine Bennani</h4>
                            <p class="text-xs text-slate-400 font-bold uppercase tracking-widest">Étudiant - EMI</p>
                        </div>
                    </div>
                </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- FAQ -->
    <section id="faq" class="py-24" data-aos="fade-up">
        <div class="max-w-[85rem] mx-auto px-4">
            <div class="max-w-2xl mx-auto text-center mb-16">
                <h2 class="text-3xl font-extrabold font-heading text-slate-900">Questions fréquentes</h2>
            </div>
            <div class="max-w-3xl mx-auto hs-accordion-group space-y-4">
                <div class="hs-accordion active bg-white border border-slate-200 rounded-[2rem] overflow-hidden" id="faq-1">
                    <button class="hs-accordion-toggle hs-accordion-active:text-indigo-600 inline-flex justify-between items-center w-full font-bold text-slate-800 py-6 px-8 hover:bg-slate-50 transition-all">
                        Comment postuler à un stage ? 
                        <svg class="hs-accordion-active:rotate-180 size-5 transition-transform" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m6 9 6 6 6-6" /></svg>
                    </button>
                    <div class="hs-accordion-content w-full overflow-hidden transition-[height] duration-300">
                        <div class="pb-6 px-8 text-sm text-slate-500">Créez votre compte, uploadez votre CV et postulez en un clic sur l'offre de votre choix. Les dossiers sont transmis directement aux recruteurs.</div>
                    </div>
                </div>
                <div class="hs-accordion bg-white border border-slate-200 rounded-[2rem] overflow-hidden" id="faq-2">
                    <button class="hs-accordion-toggle hs-accordion-active:text-indigo-600 inline-flex justify-between items-center w-full font-bold text-slate-800 py-6 px-8 hover:bg-slate-50 transition-all">
                        Comment recruter des stagiaires ? 
                        <svg class="hs-accordion-active:rotate-180 size-5 transition-transform" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m6 9 6 6 6-6" /></svg>
                    </button>
                    <div class="hs-accordion-content hidden w-full overflow-hidden transition-[height] duration-300">
                        <div class="pb-6 px-8 text-sm text-slate-500">Inscrivez votre entreprise et publiez vos offres en quelques minutes. Vous pourrez ensuite gérer les candidatures directement depuis votre tableau de bord.</div>
                    </div>
                </div>
                <div class="hs-accordion bg-white border border-slate-200 rounded-[2rem] overflow-hidden" id="faq-3">
                    <button class="hs-accordion-toggle hs-accordion-active:text-indigo-600 inline-flex justify-between items-center w-full font-bold text-slate-800 py-6 px-8 hover:bg-slate-50 transition-all">
                        Puis-je filtrer les candidats ?
                        <svg class="hs-accordion-active:rotate-180 size-5 transition-transform" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m6 9 6 6 6-6" /></svg>
                    </button>
                    <div class="hs-accordion-content hidden w-full overflow-hidden transition-[height] duration-300">
                        <div class="pb-6 px-8 text-sm text-slate-500">Oui, notre algorithme de matching vous propose les profils les plus adaptés à vos besoins. Vous pouvez également filtrer par écoles, technologies ou durée de stage.</div>
                    </div>
                </div>
                <div class="hs-accordion bg-white border border-slate-200 rounded-[2rem] overflow-hidden" id="faq-4">
                    <button class="hs-accordion-toggle hs-accordion-active:text-indigo-600 inline-flex justify-between items-center w-full font-bold text-slate-800 py-6 px-8 hover:bg-slate-50 transition-all">
                        Est-ce que la plateforme est gratuite ?
                        <svg class="hs-accordion-active:rotate-180 size-5 transition-transform" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m6 9 6 6 6-6" /></svg>
                    </button>
                    <div class="hs-accordion-content hidden w-full overflow-hidden transition-[height] duration-300">
                        <div class="pb-6 px-8 text-sm text-slate-500">Oui, StageFlow est totalement gratuit pour tous les étudiants et stagiaires au Maroc. Pour les entreprises, des options premium existent pour booster la visibilité.</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="py-24 px-4 overflow-hidden" data-aos="fade-up">
        <div class="max-w-4xl mx-auto relative bg-indigo-600 rounded-[3rem] p-12 lg:p-20 text-center shadow-2xl shadow-indigo-200 overflow-hidden">
            <h2 class="text-3xl lg:text-5xl font-black font-heading text-white mb-10 leading-tight">Prêt à décrocher votre futur stage ?</h2>
            <button class="py-5 px-12 bg-white text-indigo-600 font-bold rounded-2xl shadow-xl hover:bg-slate-50 hover:shadow-2xl transition-all hover:scale-105 active:scale-95 leading-none">
                Créer mon compte maintenant
            </button>
            <div class="absolute top-0 right-0 -translate-y-1/2 translate-x-1/2 size-64 bg-white/10 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 left-0 translate-y-1/2 -translate-x-1/2 size-64 bg-indigo-400/20 rounded-full blur-3xl"></div>
        </div>
    </section>
@endsection
