<div id="student-profile-modal-wrapper" style="display:none;" class="fixed inset-0 z-[110] transition-opacity duration-300 opacity-0">
    <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-md" onclick="closeStudentProfileModal()"></div>

    <div class="absolute inset-0 flex flex-col items-center justify-center p-4 z-10 overflow-hidden">
        <div id="student-profile-modal-card" class="bg-white w-full max-w-lg rounded-[2.5rem] shadow-2xl flex flex-col max-h-[90vh] pointer-events-auto transform scale-95 transition-all duration-300 my-auto overflow-hidden border border-gray-100 relative">
            
            <div class="flex items-center justify-between px-4 sm:px-8 py-5 border-b border-gray-50 shrink-0 bg-white z-20">
                <h3 class="text-[10px] font-black text-indigo-500 uppercase tracking-[0.4em]">Fiche Profil</h3>
                <button type="button" onclick="closeStudentProfileModal()" class="text-gray-400 hover:text-gray-900 transition-all bg-gray-50 hover:bg-gray-100 rounded-full p-2 shadow-sm border border-gray-100">
                    <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <div class="flex-1 overflow-y-auto scrollbar-thin scrollbar-thumb-gray-100">
                
                <div class="relative mb-16">
                    <div class="h-32 bg-gray-50/50 w-full border-b border-gray-100"></div>
                    <div class="absolute -bottom-12 left-1/2 -translate-x-1/2">
                        <div class="size-28 rounded-3xl overflow-hidden border-[5px] border-white shadow-xl bg-gray-50 flex items-center justify-center ring-1 ring-black/5">
                            <img id="stu-photo" src="" class="size-full object-cover">
                        </div>
                    </div>
                </div>

                <div class="px-4 pb-8 sm:px-10 sm:pb-10">
                    
                    <div class="text-center mb-10 pt-4">
                        <h3 id="stu-nom-complet" class="text-2xl sm:text-3xl font-black text-gray-900 mb-2 font-heading tracking-tight leading-none">...</h3>
                        <p id="stu-email-text" class="text-[10px] sm:text-xs font-bold text-indigo-500/70 tracking-widest uppercase mb-6 break-all">...</p>
                        
                        <div class="max-w-md mx-auto">
                            <p id="stu-bio" class="text-sm text-gray-500 italic leading-relaxed font-medium px-4">...</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-10">
                        <div class="p-5 bg-gray-50/50 rounded-3xl border border-gray-100 flex flex-col items-center text-center gap-2">
                            <div class="size-11 bg-white rounded-2xl flex items-center justify-center text-indigo-500 shadow-sm border border-gray-50">
                                <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M12 14l9-5-9-5-9 5 9 5z"/><path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 14v7"/></svg>
                            </div>
                            <div>
                                <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest">Établissement</p>
                                <p id="stu-etablissement" class="text-xs font-black text-gray-800 mt-1">...</p>
                            </div>
                        </div>
                        <div class="p-5 bg-gray-50/50 rounded-3xl border border-gray-100 flex flex-col items-center text-center gap-2">
                            <div class="size-11 bg-white rounded-2xl flex items-center justify-center text-emerald-500 shadow-sm border border-gray-50">
                                <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </div>
                            <div>
                                <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest">Localisation</p>
                                <p id="stu-ville" class="text-xs font-black text-gray-800 mt-1">...</p>
                            </div>
                        </div>
                        <div class="p-5 bg-gray-50/50 rounded-3xl border border-gray-100 flex flex-col items-center text-center gap-2">
                            <div class="size-11 bg-white rounded-2xl flex items-center justify-center text-amber-500 shadow-sm border border-gray-50">
                                <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            </div>
                            <div>
                                <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest">Filière</p>
                                <p id="stu-filiere-badge" class="text-xs font-black text-gray-800 mt-1">...</p>
                            </div>
                        </div>
                        <div class="p-5 bg-gray-50/50 rounded-3xl border border-gray-100 flex flex-col items-center text-center gap-2">
                            <div class="size-11 bg-white rounded-2xl flex items-center justify-center text-rose-500 shadow-sm border border-gray-50">
                                <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>
                            </div>
                            <div>
                                <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest">Niveau</p>
                                <p id="stu-niveau-badge" class="text-xs font-black text-gray-800 mt-1">...</p>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-3 mb-12">
                        <a id="stu-email" href="#" class="flex-1 inline-flex items-center justify-center gap-3 py-4 px-6 bg-indigo-600 text-white text-[11px] font-black uppercase tracking-widest rounded-2xl hover:bg-indigo-700 transition shadow-lg shadow-indigo-100">
                            <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            Envoyer un Message
                        </a>
                        <div class="flex gap-2 justify-center sm:justify-start w-full sm:w-auto">
                            <a id="stu-github" href="#" target="_blank" class="size-14 bg-gray-50 rounded-2xl flex items-center justify-center text-gray-500 hover:text-gray-900 border border-gray-100 transition-all">
                                <svg class="size-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 .297c-6.63 0-12 5.373-12 12 0 5.303 3.438 9.8 8.205 11.385.6.113.82-.258.82-.577 0-.285-.01-1.04-.015-2.04-3.338.724-4.042-1.61-4.042-1.61C4.422 18.07 3.633 17.7 3.633 17.7c-1.087-.744.084-.729.084-.729 1.205.084 1.838 1.236 1.838 1.236 1.07 1.835 2.809 1.305 3.495.998.108-.776.417-1.305.76-1.605-2.665-.3-5.466-1.332-5.466-5.93 0-1.31.465-2.38 1.235-3.22-.135-.303-.54-1.523.105-3.176 0 0 1.005-.322 3.3 1.23.96-.267 1.98-.399 3-.405 1.02.006 2.04.138 3 .405 2.28-1.552 3.285-1.23 3.285-1.23.645 1.653.24 2.873.12 3.176.765.84 1.23 1.91 1.23 3.22 0 4.61-2.805 5.625-5.475 5.92.42.36.81 1.096.81 2.22 0 1.606-.015 2.896-.015 3.286 0 .315.21.69.825.57C20.565 22.092 24 17.592 24 12.297c0-6.627-5.373-12-12-12"/></svg>
                            </a>
                            <a id="stu-linkedin" href="#" target="_blank" class="size-14 bg-gray-50 rounded-2xl flex items-center justify-center text-gray-500 hover:text-[#0077b5] border border-gray-100 transition-all">
                                <svg class="size-6" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                            </a>
                        </div>
                    </div>

                    <div class="bg-gray-50/50 rounded-[2.5rem] p-4 sm:p-7 border border-gray-100/50">
                        <h4 class="text-xs font-black text-gray-900 uppercase tracking-[0.2em] flex items-center gap-2 mb-8">
                            <span class="size-2 bg-indigo-500 rounded-full animate-pulse"></span>
                            Postulations Récentes
                        </h4>
                        <div id="stu-candidatures-list" class="space-y-4"></div>
                        <div id="stu-candidatures-empty" style="display:none;" class="py-10 text-center italic text-xs text-gray-400 font-bold uppercase tracking-widest leading-relaxed">
                            Aucune postulation récente
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-gray-50 px-4 sm:px-8 py-4 border-t border-gray-100 flex items-center justify-center shrink-0">
                <span class="text-[9px] font-black text-gray-400 uppercase tracking-widest"><span id="stu-vues">0</span> vues profil au total</span>
            </div>
        </div>
    </div>
</div>
