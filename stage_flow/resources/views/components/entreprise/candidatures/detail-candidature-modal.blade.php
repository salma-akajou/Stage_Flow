<div id="candidature-detail-modal-wrapper" style="display:none;" class="fixed inset-0 z-[100] transition-opacity duration-300 opacity-0">
    <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-xl" onclick="closeDetailModal()"></div>

    <div class="absolute inset-0 flex flex-col items-center justify-center p-4 sm:p-6 pointer-events-none z-10 overflow-y-auto">
        <div id="candidature-detail-card" class="bg-white w-full max-w-lg rounded-[2.5rem] shadow-2xl flex flex-col max-h-[90vh] pointer-events-auto transform scale-95 transition-all duration-300 my-auto overflow-hidden border border-gray-100">
            
            <div class="px-8 pt-8 pb-4 shrink-0 text-center relative">
                <h3 class="text-[10px] font-black text-indigo-500 uppercase tracking-[0.3em] mb-1">Fiche Candidat</h3>
                <p class="text-xl font-black text-gray-900 font-heading">Consultation de profil</p>
                
                <button type="button" onclick="closeDetailModal()" class="absolute top-6 right-8 text-gray-400 hover:text-gray-900 transition-colors p-2 bg-gray-50 rounded-full">
                    <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path d="M18 6L6 18M6 6l12 12"/></svg>
                </button>
            </div>

            <div class="flex-1 overflow-y-auto px-8 py-6 space-y-10 scrollbar-thin scrollbar-thumb-gray-100">
                
                <div class="text-center">
                    <div class="inline-block relative mb-6">
                        <div id="det-photo-skeleton" class="size-28 rounded-full bg-gray-100 animate-pulse absolute inset-0 z-10"></div>
                        <img id="det-photo" src="" class="size-28 rounded-full border-4 border-white shadow-2xl object-cover bg-gray-50 ring-1 ring-gray-100 opacity-0 transition-opacity duration-300" onload="this.classList.remove('opacity-0'); document.getElementById('det-photo-skeleton').style.display='none'">
                        <div id="det-status-badge" class="absolute -bottom-2 -right-2 px-3 py-1 bg-white shadow-lg rounded-full text-[9px] font-black uppercase ring-1 ring-gray-100">--</div>
                    </div>
                    
                    <h4 id="det-nom" class="text-2xl font-black text-gray-900 font-heading min-h-[1.5em] flex items-center justify-center px-4">
                        <span class="bg-gray-100 animate-pulse h-8 w-48 rounded-lg"></span>
                    </h4>
                    
                    <div class="max-w-xs mx-auto mt-4 px-4 py-3 bg-gray-50/50 rounded-2xl border border-gray-100/50">
                        <p id="det-bio" class="text-xs text-gray-500 italic leading-relaxed font-medium min-h-[1em]">
                            <span class="bg-gray-100 animate-pulse h-3 w-32 rounded inline-block"></span>
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-gray-50/80 p-5 rounded-[2rem] text-center border border-gray-100 flex items-center gap-4">
                        <div class="size-10 bg-white rounded-xl flex items-center justify-center shrink-0 shadow-sm">
                            <svg class="size-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        </div>
                        <div class="text-left">
                            <p class="text-[9px] font-black text-gray-400 uppercase tracking-tighter">APPEL</p>
                            <p id="det-tel" class="text-[11px] font-black text-gray-800">-- -- --</p>
                        </div>
                    </div>

                    <div class="bg-gray-50/80 p-5 rounded-[2rem] text-center border border-gray-100 flex items-center gap-4">
                        <div class="size-10 bg-white rounded-xl flex items-center justify-center shrink-0 shadow-sm">
                            <svg class="size-5 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9-3-9m-9 9a9 9 0 019-9"/></svg>
                        </div>
                        <div class="text-left">
                            <p class="text-[9px] font-black text-gray-400 uppercase tracking-tighter">LIEN</p>
                            <a id="det-portfolio-link" href="#" target="_blank" class="text-[11px] font-black text-purple-600 underline">Portfolio</a>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-center pt-2">
                    <a id="det-cv-link" href="#" download class="group inline-flex items-center gap-3 px-8 py-4 bg-gray-900 text-white text-[10px] font-black rounded-2xl hover:bg-indigo-600 transition-all shadow-xl shadow-gray-200">
                        <svg class="size-4 group-hover:animate-bounce" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3"/></svg>
                        TÉLÉCHARGER LE CV (PDF)
                    </a>
                </div>

                <div class="space-y-4 pb-8 overflow-hidden">
                    <h5 class="text-[10px] font-black text-gray-300 uppercase tracking-[0.4em] text-center">Motivation</h5>
                    <div class="p-8 bg-gray-50/30 rounded-[2.5rem] border border-gray-100 leading-relaxed text-sm text-gray-600 font-medium italic text-center break-words overflow-hidden">
                        <div id="det-motivation-skeleton" class="space-y-2">
                            <div class="h-3 bg-gray-100 animate-pulse w-full rounded"></div>
                            <div class="h-3 bg-gray-100 animate-pulse w-5/6 mx-auto rounded"></div>
                            <div class="h-3 bg-gray-100 animate-pulse w-4/6 mx-auto rounded"></div>
                        </div>
                        <p id="det-motivation" style="display:none;" class="break-words"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
