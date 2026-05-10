<div id="entreprise-modal-wrapper" style="display:none;" class="fixed inset-0 z-[100] transition-opacity duration-300 opacity-0">
    <div id="entreprise-modal-backdrop" class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="closeEntrepriseModal()"></div>

    <div id="entreprise-modal-panel" class="absolute inset-0 flex flex-col items-center justify-center p-4 sm:p-6 pointer-events-none z-10 overflow-y-auto">
        <div id="entreprise-modal-card" class="bg-white w-full max-w-xl rounded-2xl shadow-xl flex flex-col max-h-[90vh] pointer-events-auto transform scale-95 transition-all duration-300 my-auto overflow-hidden">
            
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 shrink-0">
                <h3 class="text-base font-bold text-gray-900" id="modal-header-title">Profil d'entreprise</h3>
                <button onclick="closeEntrepriseModal()" class="text-gray-400 hover:text-gray-700 bg-gray-50 hover:bg-gray-100 rounded-full p-1.5 transition focus:outline-none">
                    <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <div class="flex-1 overflow-y-auto p-6 pb-10 relative">
                <div id="modal-loading-spinner" class="absolute inset-0 bg-white/90 z-20 flex flex-col items-center justify-center">
                    <div class="animate-spin size-8 border-4 border-indigo-100 border-t-indigo-600 rounded-full mb-3"></div>
                    <p class="text-sm font-semibold text-gray-500 tracking-wide">Chargement...</p>
                </div>

                <div id="modal-content-container" class="opacity-0 transition-opacity duration-300">
                    
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

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                        <div id="modal-contact-rc" class="hidden bg-gray-50/80 p-4 rounded-xl border border-gray-100 flex flex-col items-center text-center gap-2 transition hover:bg-white hover:shadow-sm">
                            <div class="p-2.5 rounded-full shadow-sm text-amber-500 bg-white border border-amber-50">
                                <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wide">Registre Commerce</p>
                                <p id="modal-rc-text" class="text-xs font-bold text-gray-800 break-all"></p>
                            </div>
                        </div>

                        <div id="modal-contact-adresse" class="hidden bg-gray-50/80 p-4 rounded-xl border border-gray-100 flex flex-col items-center text-center gap-2 transition hover:bg-white hover:shadow-sm">
                            <div class="p-2.5 rounded-full shadow-sm text-emerald-500 bg-white border border-emerald-50">
                                <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.242-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wide">Adresse</p>
                                <p id="modal-adresse-text" class="text-xs font-bold text-gray-800 leading-snug"></p>
                            </div>
                        </div>

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

                    <div class="mb-8" id="modal-section-bio">
                        <h5 class="text-sm font-bold text-gray-900 mb-3 border-b border-gray-100 pb-2">À propos</h5>
                        <p id="modal-entreprise-bio" class="text-sm text-gray-600 leading-relaxed"></p>
                    </div>

                    <div class="mb-2">
                        <h5 class="text-sm font-bold text-gray-900 mb-4 border-b border-gray-100 pb-2">Opportunités actuelles</h5>
                        <div id="modal-offres-list" class="space-y-3"></div>
                        <div id="modal-offres-empty" class="hidden text-center py-6 bg-gray-50 rounded-xl border border-dashed border-gray-200">
                            <p class="text-xs font-semibold text-gray-500 mt-2">Aucune offre disponible.</p>
                        </div>
                    </div>

                </div>
            </div>
            <div class="h-1.5 w-full bg-gradient-to-r from-indigo-500 to-purple-600 shrink-0"></div>
        </div>
    </div>
</div>
