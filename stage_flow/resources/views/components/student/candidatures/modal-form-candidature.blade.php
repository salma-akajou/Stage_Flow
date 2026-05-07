<div id="candidature-modal-wrapper" style="display:none;" class="fixed inset-0 z-[100] transition-opacity duration-300 opacity-0">
    <div id="candidature-modal-backdrop" class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="closeCandidatureModal()"></div>

    <div id="candidature-modal-panel" class="absolute inset-0 flex flex-col items-center justify-center p-4 sm:p-6 pointer-events-none z-10 overflow-y-auto w-full">
        <div id="candidature-modal-card" class="bg-white w-full max-w-xl mx-auto rounded-2xl shadow-xl flex flex-col max-h-[90vh] min-h-[50vh] pointer-events-auto transform scale-95 transition-all duration-300 my-auto">
            
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 shrink-0">
                <div>
                    <h3 class="text-lg font-black text-gray-900 font-heading" id="modal-candidature-title">Formulaire de candidature</h3>
                    <p class="text-[11px] text-gray-500 font-bold uppercase tracking-widest mt-0.5">Offre : {{ $offre->titre }}</p>
                </div>
                <button onclick="closeCandidatureModal()" class="text-gray-400 hover:text-gray-700 bg-gray-50 hover:bg-gray-100 rounded-full p-2 transition focus:outline-none">
                    <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <div class="flex-1 overflow-y-auto p-6 sm:p-8 relative">
                <form id="candidature-form" action="{{ route('student.candidatures.store', $offre->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="offre_id" value="{{ $offre->id }}">
                    <div class="space-y-8">

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

                        <div>
                            <label class="block text-sm font-bold mb-2 text-gray-800">Lettre de motivation <span class="text-rose-500">*</span></label>
                            <textarea name="message_motivation" rows="4"
                                class="py-3.5 px-4 block w-full border-gray-200 rounded-xl text-sm focus:border-indigo-500 focus:ring-indigo-500 transition shadow-sm @error('message_motivation') border-rose-300 focus:border-rose-500 focus:ring-rose-500 @enderror"
                                placeholder="Présentez brièvement vos atouts pour ce poste, vos motivations...">{{ old('message_motivation') }}</textarea>
                            @error('message_motivation')
                                <p class="text-sm text-rose-600 font-semibold mt-1">{{ $message }}</p>
                            @enderror
                        </div>

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
            
            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50 rounded-b-2xl flex justify-end shrink-0 gap-3">
                 <button onclick="closeCandidatureModal()" class="px-5 py-2.5 bg-white border border-gray-200 text-gray-700 rounded-xl text-sm font-bold shadow-sm hover:bg-gray-50 transition focus:outline-none">Annuler</button>
                 <button onclick="document.getElementById('candidature-form').submit()" class="px-5 py-2.5 bg-indigo-600 border border-transparent text-white rounded-xl text-sm font-bold shadow-md shadow-indigo-200 hover:bg-indigo-700 transition focus:outline-none">Soumettre</button>
            </div>
        </div>
    </div>
</div>
