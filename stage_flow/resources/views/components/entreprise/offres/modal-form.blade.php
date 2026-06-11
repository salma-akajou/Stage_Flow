<div id="offer-modal-wrapper" style="display:none;" class="fixed inset-0 z-[100] transition-opacity duration-300 opacity-0" 
    x-data="{ 
        isEdit: false,
        offerId: null,
        formData: {
            titre: '',
            description: '',
            status: 'Active',
            type_stage: '',
            format: '',
            remuneration: '',
            duree: '',
            ville_id: '',
            ville_nom: '',
            date_debut: '',
            date_fin: '',
            responsabilites: '',
            profil_recherche: '',
            competences_techniques: []
        },
        newTag: '',
        showSuggestions: false,
        villes: {{ $villes->map(fn($v) => ['id' => $v->id, 'nom' => $v->nom])->toJson() }},
        types: ['PFE', 'Technique', 'Observation'],
        remuns: ['Payé', 'Non-payé'],
        formats: ['Hybride', 'Télétravail', 'Présentiel'],
        statuses: ['Active', 'Expirée'],
        existingCompetences: {{ $existingCompetences->pluck('nom')->toJson() }},

        resetForm() {
            this.isEdit = false;
            this.offerId = null;
            this.formData = {
                titre: '', description: '', status: 'Active', type_stage: '',
                format: '', remuneration: '', duree: '', ville_id: '',
                ville_nom: '', date_debut: '', date_fin: '',
                responsabilites: '', profil_recherche: '', competences_techniques: []
            };
            this.newTag = '';
            document.getElementById('offer-form').action = '{{ route('entreprise.offres.store') }}';
            document.getElementById('method-field').value = 'POST';
        },

        loadOffer(id) {
            fetch(`/entreprise/offres/${id}/edit`)
                .then(res => res.json())
                .then(data => {
                    this.isEdit = true;
                    this.offerId = id;
                    this.formData = {
                        titre: data.titre,
                        description: data.description,
                        status: data.status,
                        type_stage: data.type_stage,
                        format: data.format,
                        remuneration: data.remuneration,
                        duree: data.duree,
                        ville_id: data.ville_id,
                        ville_nom: this.villes.find(v => v.id == data.ville_id)?.nom || '',
                        date_debut: data.date_debut ? data.date_debut.split('T')[0] : '',
                        date_fin: data.date_fin ? data.date_fin.split('T')[0] : '',
                        responsabilites: data.responsabilites,
                        profil_recherche: data.profil_recherche,
                        competences_techniques: Array.isArray(data.competences_techniques) ? data.competences_techniques : JSON.parse(data.competences_techniques || '[]')
                    };
                    document.getElementById('offer-form').action = `/entreprise/offres/${id}`;
                    document.getElementById('method-field').value = 'PUT';
                    openOfferModal(false);
                });
        },

        addTag(tag) {
            if (tag && !this.formData.competences_techniques.includes(tag)) {
                this.formData.competences_techniques.push(tag);
            }
            this.newTag = '';
            this.showSuggestions = false;
        }
    }"
    @open-modal.window="loadOffer($event.detail)"
    @reset-modal.window="resetForm()">
    
    <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-xl" onclick="closeOfferModal()"></div>

    <div class="absolute inset-0 flex flex-col items-center justify-center p-4 pointer-events-none z-10 overflow-y-auto">
        <div id="offer-modal-card" class="bg-white w-full max-w-xl rounded-[2.5rem] shadow-2xl flex flex-col max-h-[90vh] pointer-events-auto transform scale-95 transition-all duration-300 my-auto relative overflow-hidden border border-white/20">
            
            <button type="button" onclick="closeOfferModal()" 
                class="absolute top-6 right-6 z-20 p-2 bg-gray-50/50 hover:bg-rose-50 text-gray-400 hover:text-rose-500 rounded-full transition-all duration-300">
                <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path d="M6 18L18 6M6 6l12 12"/></svg>
            </button>

            <div class="px-10 pt-10 pb-4 shrink-0">
                <h3 class="text-2xl font-black text-gray-900 font-heading" x-text="isEdit ? 'Modifier l\'offre' : 'Nouvelle Offre'"></h3>
                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-[0.2em] mt-1" x-text="isEdit ? 'Mise à jour des informations' : 'Publication Rapide'"></p>
            </div>

            <div class="flex-1 overflow-y-auto px-10 py-4 space-y-8 scrollbar-hide">
                <form action="{{ route('entreprise.offres.store') }}" method="POST" id="offer-form" class="space-y-6 pb-6">
                    @csrf
                    <input type="hidden" name="_method" id="method-field" value="POST">

                    <div class="space-y-5">
                        <div class="relative">
                            <label class="block text-[11px] font-black text-gray-400 uppercase tracking-wider mb-2 ms-1">Titre de l'annonce</label>
                            <input type="text" name="titre" x-model="formData.titre" required
                                class="w-full px-6 py-4 bg-gray-50 border-gray-100 rounded-2xl text-sm font-bold focus:bg-white focus:ring-4 focus:ring-indigo-100 transition-all shadow-sm border"
                                placeholder="Tappez le titre de poste...">
                            @error('titre') <span class="inline-block px-3 py-1 bg-rose-50 text-rose-600 text-[9px] font-black rounded-xl border border-rose-100 mt-2 ms-1 uppercase shadow-sm animate-in fade-in slide-in-from-top-1">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-[11px] font-black text-gray-400 uppercase tracking-wider mb-2 ms-1">Description</label>
                            <textarea name="description" x-model="formData.description" rows="3" required
                                class="w-full px-6 py-4 bg-gray-50 border-gray-100 rounded-2xl text-sm font-medium focus:bg-white focus:ring-4 focus:ring-indigo-100 transition-all shadow-sm border"
                                placeholder="Décrivez brièvement le poste en quelques lignes..."></textarea>
                            @error('description') <span class="inline-block px-3 py-1 bg-rose-50 text-rose-600 text-[9px] font-black rounded-xl border border-rose-100 mt-2 ms-1 uppercase shadow-sm animate-in fade-in slide-in-from-top-1">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-5">
                        <div x-data="{ open: false }">
                            <label class="block text-[11px] font-black text-gray-400 uppercase tracking-wider mb-2 ms-1">Statut</label>
                            <div class="relative">
                                <button @click="open = !open" @click.away="open = false" type="button" 
                                    class="w-full px-6 py-4 bg-gray-50 border-gray-100 rounded-2xl text-left text-sm font-bold focus:ring-4 focus:ring-indigo-100 transition-all flex items-center justify-between border shadow-sm">
                                    <span :class="formData.status == 'Active' ? 'text-emerald-600' : 'text-rose-600'" x-text="formData.status"></span>
                                    </button>
                                <div x-show="open" x-transition class="absolute z-50 w-full mt-2 bg-white border border-gray-100 rounded-2xl shadow-2xl py-1 overflow-hidden">
                                    <template x-for="s in statuses">
                                        <button type="button" @click="formData.status = s; open = false" 
                                            class="w-full px-6 py-3 text-left text-sm font-bold hover:bg-gray-50"
                                            :class="formData.status == s ? (s == 'Active' ? 'text-emerald-600 bg-emerald-50/50' : 'text-rose-600 bg-rose-50/50') : 'text-gray-600'"
                                            x-text="s"></button>
                                    </template>
                                </div>
                                <input type="hidden" name="status" :value="formData.status">
                                @error('status') <span class="inline-block px-3 py-1 bg-rose-50 text-rose-600 text-[9px] font-black rounded-xl border border-rose-100 mt-2 ms-1 uppercase shadow-sm animate-in fade-in slide-in-from-top-1">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div x-data="{ open: false }">
                            <label class="block text-[11px] font-black text-gray-400 uppercase tracking-wider mb-2 ms-1">Type de stage</label>
                            <div class="relative">
                                <button @click="open = !open" @click.away="open = false" type="button" 
                                    class="w-full px-6 py-4 bg-gray-50 border-gray-100 rounded-2xl text-left text-sm font-bold focus:ring-4 focus:ring-indigo-100 transition-all flex items-center justify-between border shadow-sm">
                                    <span :class="formData.type_stage ? 'text-gray-900' : 'text-gray-400'" x-text="formData.type_stage || 'Choisir...'"></span>
                                    </button>
                                <div x-show="open" x-transition class="absolute z-50 w-full mt-2 bg-white border border-gray-100 rounded-2xl shadow-2xl py-1 overflow-hidden">
                                    <template x-for="t in types">
                                        <button type="button" @click="formData.type_stage = t; open = false" class="w-full px-6 py-3 text-left text-sm font-bold hover:bg-indigo-50 hover:text-indigo-600 transition-colors" x-text="t"></button>
                                    </template>
                                </div>
                                <input type="hidden" name="type_stage" :value="formData.type_stage" required>
                                @error('type_stage') <span class="inline-block px-3 py-1 bg-rose-50 text-rose-600 text-[9px] font-black rounded-xl border border-rose-100 mt-2 ms-1 uppercase shadow-sm animate-in fade-in slide-in-from-top-1">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-5">
                        <div x-data="{ open: false }">
                            <label class="block text-[11px] font-black text-gray-400 uppercase tracking-wider mb-2 ms-1">Format</label>
                            <div class="relative">
                                <button @click="open = !open" @click.away="open = false" type="button" 
                                    class="w-full px-6 py-4 bg-gray-50 border-gray-100 rounded-2xl text-left text-sm font-bold border shadow-sm flex items-center justify-between transition-all focus:ring-4 focus:ring-indigo-100">
                                    <span :class="formData.format ? 'text-gray-900' : 'text-gray-400'" x-text="formData.format || 'Choisir...'"></span>
                                    <svg :class="{ 'rotate-180': open }" class="size-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="m19 9-7 7-7-7"/></svg>
                                </button>
                                <div x-show="open" x-transition class="absolute z-50 w-full mt-2 bg-white border border-gray-100 rounded-2xl shadow-2xl py-1 overflow-hidden">
                                    <template x-for="f in formats">
                                        <button type="button" @click="formData.format = f; open = false" class="w-full px-6 py-3 text-left text-sm font-bold hover:bg-indigo-50 hover:text-indigo-600 transition-colors" x-text="f"></button>
                                    </template>
                                </div>
                                <input type="hidden" name="format" :value="formData.format" required>
                                @error('format') <span class="inline-block px-3 py-1 bg-rose-50 text-rose-600 text-[9px] font-black rounded-xl border border-rose-100 mt-2 ms-1 uppercase shadow-sm animate-in fade-in slide-in-from-top-1">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div x-data="{ open: false }">
                            <label class="block text-[11px] font-black text-gray-400 uppercase tracking-wider mb-2 ms-1">Rémunération</label>
                            <div class="relative">
                                <button @click="open = !open" @click.away="open = false" type="button" 
                                    class="w-full px-6 py-4 bg-gray-50 border-gray-100 rounded-2xl text-left text-sm font-bold border shadow-sm flex items-center justify-between transition-all focus:ring-4 focus:ring-indigo-100">
                                    <span :class="formData.remuneration ? 'text-gray-900' : 'text-gray-400'" x-text="formData.remuneration || 'Choisir...'"></span>
                                    <svg :class="{ 'rotate-180': open }" class="size-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="m19 9-7 7-7-7"/></svg>
                                </button>
                                <div x-show="open" x-transition class="absolute z-50 w-full mt-2 bg-white border border-gray-100 rounded-2xl shadow-2xl py-1 overflow-hidden">
                                    <template x-for="r in remuns">
                                        <button type="button" @click="formData.remuneration = r; open = false" class="w-full px-6 py-3 text-left text-sm font-bold hover:bg-indigo-50 hover:text-indigo-600 transition-colors" x-text="r"></button>
                                    </template>
                                </div>
                                <input type="hidden" name="remuneration" :value="formData.remuneration" required>
                                @error('remuneration') <span class="inline-block px-3 py-1 bg-rose-50 text-rose-600 text-[9px] font-black rounded-xl border border-rose-100 mt-2 ms-1 uppercase shadow-sm animate-in fade-in slide-in-from-top-1">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    <div x-data="{ open: false }">
                        <label class="block text-[11px] font-black text-gray-400 uppercase tracking-wider mb-2 ms-1">Ville du stage</label>
                        <div class="relative">
                            <button @click="open = !open" @click.away="open = false" type="button" 
                                class="w-full px-6 py-4 bg-gray-50 border-gray-100 rounded-2xl text-left text-sm font-bold border shadow-sm flex items-center justify-between transition-all focus:ring-4 focus:ring-indigo-100">
                                <span :class="formData.ville_nom ? 'text-gray-900' : 'text-gray-400'" x-text="formData.ville_nom || 'Choisir la ville...'"></span>
                                <svg class="size-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="m19 9-7 7-7-7"/></svg>
                            </button>
                            <div x-show="open" x-transition class="absolute z-50 w-full mt-2 bg-white border border-gray-100 rounded-2xl shadow-2xl py-2 max-h-48 overflow-y-auto">
                                <template x-for="v in villes">
                                    <button type="button" @click="formData.ville_id = v.id; formData.ville_nom = v.nom; open = false" class="w-full px-6 py-3 text-left text-sm font-bold hover:bg-indigo-50 hover:text-indigo-600 transition-colors" x-text="v.nom"></button>
                                </template>
                            </div>
                            <input type="hidden" name="ville_id" :value="formData.ville_id" required>
                            @error('ville_id') <span class="inline-block px-3 py-1 bg-rose-50 text-rose-600 text-[9px] font-black rounded-xl border border-rose-100 mt-2 ms-1 uppercase shadow-sm animate-in fade-in slide-in-from-top-1">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-4">
                        <div class="col-span-1">
                            <label class="block text-[11px] font-black text-gray-400 uppercase tracking-wider mb-2 ms-1">Durée</label>
                            <input type="text" name="duree" x-model="formData.duree" required
                                class="w-full px-6 py-4 bg-gray-50 border-gray-100 rounded-2xl text-sm font-bold focus:bg-white focus:ring-4 focus:ring-indigo-100 transition-all border"
                                placeholder="Ex: 3 mois">
                            @error('duree') <span class="inline-block px-3 py-1 bg-rose-50 text-rose-600 text-[9px] font-black rounded-xl border border-rose-100 mt-2 ms-1 uppercase shadow-sm animate-in fade-in slide-in-from-top-1">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-span-1">
                            <label class="block text-[11px] font-black text-gray-400 uppercase tracking-wider mb-2 ms-1">Début</label>
                            <input type="date" name="date_debut" x-model="formData.date_debut" required
                                class="w-full px-6 py-4 bg-gray-50 border-gray-100 rounded-2xl text-sm font-bold focus:bg-white focus:ring-4 focus:ring-indigo-100 transition-all border">
                            @error('date_debut') <span class="inline-block px-3 py-1 bg-rose-50 text-rose-600 text-[9px] font-black rounded-xl border border-rose-100 mt-2 ms-1 uppercase shadow-sm animate-in fade-in slide-in-from-top-1">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-span-1">
                            <label class="block text-[11px] font-black text-gray-400 uppercase tracking-wider mb-2 ms-1">Fin</label>
                            <input type="date" name="date_fin" x-model="formData.date_fin" required
                                class="w-full px-6 py-4 bg-gray-50 border-gray-100 rounded-2xl text-sm font-bold focus:bg-white focus:ring-4 focus:ring-indigo-100 transition-all border">
                            @error('date_fin') <span class="inline-block px-3 py-1 bg-rose-50 text-rose-600 text-[9px] font-black rounded-xl border border-rose-100 mt-2 ms-1 uppercase shadow-sm animate-in fade-in slide-in-from-top-1">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-[11px] font-black text-gray-400 uppercase tracking-wider mb-2 ms-1">Responsabilités</label>
                        <textarea name="responsabilites" x-model="formData.responsabilites" rows="4" required
                            class="w-full px-6 py-4 bg-gray-50 border-gray-100 rounded-2xl text-sm font-medium leading-relaxed focus:bg-white focus:ring-4 focus:ring-indigo-100 border transition-all"
                            placeholder="Listez les tâches du stagiaire (ex : - Développement d'APIs - Rédaction de spécifications - Tests unitaires)"></textarea>
                        @error('responsabilites') <span class="inline-block px-3 py-1 bg-rose-50 text-rose-600 text-[9px] font-black rounded-xl border border-rose-100 mt-2 ms-1 uppercase shadow-sm animate-in fade-in slide-in-from-top-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-[11px] font-black text-gray-400 uppercase tracking-wider mb-2 ms-1">Profil recherché</label>
                        <textarea name="profil_recherche" x-model="formData.profil_recherche" rows="4" required
                            class="w-full px-6 py-4 bg-gray-50 border-gray-100 rounded-2xl text-sm font-medium leading-relaxed focus:bg-white focus:ring-4 focus:ring-indigo-100 border transition-all"
                            placeholder="Listez le profil recherché (ex : - Étudiant Bac+3/5 en informatique - Maîtrise de Laravel - Esprit d'équipe)"></textarea>
                        @error('profil_recherche') <span class="inline-block px-3 py-1 bg-rose-50 text-rose-600 text-[9px] font-black rounded-xl border border-rose-100 mt-2 ms-1 uppercase shadow-sm animate-in fade-in slide-in-from-top-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="relative">
                        <label class="block text-[11px] font-black text-gray-400 uppercase tracking-wider mb-3 ms-1">Compétences clés</label>
                        <div class="p-4 bg-gray-50 border-gray-100 rounded-2xl flex flex-wrap gap-2 items-center focus-within:bg-white focus-within:ring-4 focus-within:ring-indigo-100 border transition-all">
                            <template x-for="tag in formData.competences_techniques" :key="tag">
                                <span class="inline-flex items-center gap-1.5 py-1.5 px-3 bg-white text-indigo-700 rounded-xl text-xs font-black border shadow-sm">
                                    <span x-text="tag"></span>
                                    <button type="button" @click="formData.competences_techniques = formData.competences_techniques.filter(t => t !== tag)" class="text-gray-400 hover:text-rose-500 transition-colors">
                                        <svg class="size-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path d="M6 18L18 6M6 6l12 12"/></svg>
                                    </button>
                                </span>
                            </template>
                            <input type="text" 
                                x-model="newTag"
                                @focus="showSuggestions = true"
                                @keydown.enter.prevent="if(newTag) addTag(newTag)"
                                class="flex-1 min-w-[120px] bg-transparent border-none focus:ring-0 p-1 text-sm font-bold placeholder-gray-300"
                                placeholder="Ajouter + Entrée">
                        </div>

                        <div x-show="showSuggestions && newTag" x-transition style="display: none;" class="absolute z-50 w-full mt-2 bg-white border border-gray-100 rounded-2xl shadow-2xl py-2 max-h-40 overflow-y-auto">
                            <template x-for="opt in existingCompetences.filter(o => o.toLowerCase().includes(newTag.toLowerCase()))" :key="opt">
                                <button type="button" @click="addTag(opt)" class="w-full px-6 py-2.5 text-left text-xs font-bold hover:bg-indigo-50 text-gray-700 transition-colors" x-text="opt"></button>
                            </template>
                        </div>
                        <input type="hidden" name="competences_techniques" :value="JSON.stringify(formData.competences_techniques)">
                    </div>
                </form>
            </div>

            <div class="p-10 bg-white border-t border-gray-50 flex items-center justify-end gap-3 shrink-0">
                <button type="button" onclick="closeOfferModal()" 
                    class="px-8 py-4 bg-gray-50 text-gray-500 rounded-2xl text-sm font-black hover:bg-gray-100 transition-all">
                    Annuler
                </button>
                <button type="button" onclick="document.getElementById('offer-form').submit()" 
                    class="px-12 py-4 bg-indigo-600 text-white rounded-2xl text-sm font-black shadow-xl shadow-indigo-100 hover:bg-indigo-700 transition-all transform hover:-translate-y-1 active:scale-95"
                    x-text="isEdit ? 'Mettre à jour' : 'Publier l\'offre'"></button>
            </div>
        </div>
    </div>
</div>
