<div id="user-detail-modal-wrapper" style="display:none;" class="fixed inset-0 z-[110] transition-opacity duration-300 opacity-0">
    <!-- Backdrop avec flou intense -->
    <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm" onclick="closeUserDetailModal()"></div>

    <div class="absolute inset-0 flex flex-col items-center justify-center p-4 z-10 overflow-hidden pointer-events-none">
        <div id="user-detail-modal-card" class="bg-white w-full max-w-lg rounded-[2.5rem] shadow-2xl flex flex-col max-h-[90vh] pointer-events-auto transform scale-95 transition-all duration-300 my-auto overflow-hidden border border-gray-100 relative">
            
            <div class="absolute top-5 right-5 z-[100]">
                <button type="button" onclick="closeUserDetailModal()" class="text-gray-400 hover:text-gray-900 transition-all bg-white/80 hover:bg-white backdrop-blur-md rounded-full p-2.5 shadow-lg border border-gray-100">
                    <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <div class="flex-1 overflow-y-auto scrollbar-none">
                <!-- Header -->
                <div class="relative mb-14">
                    <div id="modal-banner" class="h-24 bg-white border-b border-gray-100 w-full"></div>
                    <div class="absolute -bottom-10 left-8">
                        <div class="size-24 rounded-3xl overflow-hidden border-[4px] border-white shadow-xl bg-gray-50 flex items-center justify-center ring-1 ring-black/5">
                            <img id="modal-user-photo" src="" class="size-full object-cover">
                        </div>
                    </div>
                    <div class="absolute -bottom-6 left-36 flex flex-wrap items-center gap-2">
                        <span id="modal-user-role-badge" class="py-1 px-3 bg-white/90 backdrop-blur-sm text-[10px] font-black uppercase tracking-widest rounded-full shadow-sm border border-gray-100">...</span>
                        <span id="modal-user-status-badge" class="py-1 px-3 text-white text-[10px] font-black uppercase tracking-widest rounded-full shadow-sm">...</span>
                    </div>
                </div>

                <div class="px-10 pb-10">
                    <div class="mb-8">
                        <h3 id="modal-user-name" class="text-2xl font-black text-gray-900 mb-1 font-heading tracking-tight leading-none">...</h3>
                        <p id="modal-user-email" class="text-sm font-bold text-indigo-500/70 tracking-tight mb-4">...</p>
                        
                        <div class="bg-gray-50/50 rounded-2xl p-5 border border-gray-100/50 italic text-sm text-gray-600 font-medium leading-relaxed" id="modal-user-bio">
                            ...
                        </div>
                    </div>

                    <!-- Infos Grille -->
                    <div class="grid grid-cols-2 gap-4 mb-10" id="modal-info-grid"></div>

                    <!-- Activity Sections -->
                    <div class="space-y-8">
                        <div class="bg-gray-50/50 rounded-[2.2rem] p-6 border border-gray-100/50">
                            <h4 id="modal-activity-title" class="text-xs font-black text-gray-900 uppercase tracking-[0.2em] flex items-center gap-2 mb-5">
                                <span class="size-2 bg-indigo-500 rounded-full animate-pulse"></span>
                                Activité
                            </h4>
                            <div id="modal-activity-list" class="space-y-4"></div>
                            <div id="modal-activity-empty" style="display:none;" class="py-6 text-center italic text-xs text-gray-400 font-bold uppercase tracking-widest">
                                Aucune activité
                            </div>
                        </div>

                        <div class="bg-gray-50/50 rounded-[2.2rem] p-6 border border-gray-100/50">
                            <h4 class="text-xs font-black text-gray-900 uppercase tracking-[0.2em] flex items-center gap-2 mb-5">
                                <span class="size-2 bg-amber-500 rounded-full animate-pulse"></span>
                                Derniers Feedbacks
                            </h4>
                            <div id="modal-feedbacks-list" class="space-y-4"></div>
                            <div id="modal-feedbacks-empty" style="display:none;" class="py-6 text-center italic text-xs text-gray-400 font-bold uppercase tracking-widest">
                                Aucun feedback
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


