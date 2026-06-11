<section class="py-32 bg-slate-50 relative overflow-hidden">
    <div class="absolute top-0 right-0 p-20 opacity-5 text-9xl">💡</div>
    <div class="max-w-[85rem] mx-auto px-4 relative z-10">
        <div class="text-center mb-20" data-aos="fade-up">
            <h2 class="text-4xl font-black font-heading text-slate-900 mb-6">Ils nous font confiance</h2>
        </div>

        <div class="grid md:grid-cols-3 gap-8">
            @forelse($feedbacks as $feedback)
            <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100 flex flex-col items-center text-center md:items-start md:text-left h-full" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                <div class="flex gap-1 text-amber-400 mb-4 justify-center md:justify-start">
                    @for($i = 0; $i < 5; $i++)
                        @if($i < $feedback->note) ★ @else ☆ @endif
                    @endfor
                </div>
                <p class="text-slate-600 italic mb-8 flex-1">"{{ $feedback->texte }}"</p>
                <div class="flex flex-col items-center gap-4 md:flex-row md:items-center">
                    <div class="size-12 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold overflow-hidden border border-slate-100 uppercase">
                        @if($feedback->auteur->etudiant && $feedback->auteur->etudiant->photo)
                            <img src="{{ asset('storage/'.$feedback->auteur->etudiant->photo) }}" class="size-full object-cover">
                        @elseif($feedback->auteur->entreprise && $feedback->auteur->entreprise->logo)
                            <img src="{{ asset('storage/'.$feedback->auteur->entreprise->logo) }}" class="size-full object-cover">
                        @else
                            {{ substr($feedback->auteur->prenom ?? 'U', 0, 1) }}{{ substr($feedback->auteur->nom ?? '', 0, 1) }}
                        @endif
                    </div>
                    <div class="text-center md:text-left">
                        <h4 class="font-bold text-slate-900 text-sm">{{ $feedback->auteur->prenom ?? '' }} {{ $feedback->auteur->nom ?? 'Utilisateur' }}</h4>
                        <p class="text-[10px] text-slate-400 font-black uppercase tracking-widest leading-none mt-1">
                            @if($feedback->auteur->etudiant)
                                Étudiant - {{ $feedback->auteur->etudiant->filiere?->nom ?? '' }}
                            @elseif($feedback->auteur->entreprise)
                                Entreprise - {{ $feedback->auteur->entreprise->nom_entreprise }}
                            @else
                                Utilisateur
                            @endif
                        </p>
                    </div>
                </div>
            </div>
            @empty
            <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100 flex flex-col items-center text-center md:items-start md:text-left h-full" data-aos="fade-up">
                <div class="flex gap-1 text-amber-400 mb-4 justify-center md:justify-start">★★★★★</div>
                <p class="text-slate-600 italic mb-8 flex-1">"StageFlow m'a permis de décrocher mon stage de fin d'études chez OCP en moins de deux semaines. Une expérience fluide et premium !"</p>
                <div class="flex flex-col items-center gap-4 md:flex-row md:items-center">
                    <img class="size-12 rounded-full object-cover" src="https://images.unsplash.com/photo-1531927557220-a9e23c1e4794?auto=format&fit=facearea&facepad=2&w=300&h=300&q=80" alt="Student">
                    <div class="text-center md:text-left">
                        <h4 class="font-bold text-slate-900 text-sm">Amine Bennani</h4>
                        <p class="text-xs text-slate-400 font-bold uppercase tracking-widest">Étudiant - EMI</p>
                    </div>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</section>
