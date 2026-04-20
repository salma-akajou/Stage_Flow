<div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6" data-aos="fade-up">
    <div class="flex flex-col bg-white border border-gray-200 shadow-sm rounded-xl p-5 hover:border-indigo-200 transition group">
        <div class="flex items-center justify-between mb-2">
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Candidatures</p>
            <div class="size-8 bg-indigo-50 text-indigo-600 rounded-lg flex items-center justify-center group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                <svg class="size-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </div>
        </div>
        <div class="flex items-center gap-x-2">
            <h3 class="text-3xl font-bold text-gray-800 tracking-tight">{{ sprintf('%02d', $stats['candidatures']) }}</h3>
            <span class="text-emerald-500 text-[10px] font-bold">+15%</span>
        </div>
    </div>
    <div class="flex flex-col bg-white border border-gray-200 shadow-sm rounded-xl p-5 hover:border-indigo-200 transition group">
        <div class="flex items-center justify-between mb-2">
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Vues Profil</p>
            <div class="size-8 bg-emerald-50 text-emerald-600 rounded-lg flex items-center justify-center group-hover:bg-emerald-600 group-hover:text-white transition-colors">
                <svg class="size-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
            </div>
        </div>
        <div class="font-bold text-3xl text-gray-800 tracking-tight">{{ sprintf('%02d', $stats['vues']) }}</div>
    </div>
    <div class="flex flex-col bg-white border border-gray-200 shadow-sm rounded-xl p-5 hover:border-indigo-200 transition group">
        <div class="flex items-center justify-between mb-2">
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Offres Retenues</p>
            <div class="size-8 bg-amber-50 text-amber-600 rounded-lg flex items-center justify-center group-hover:bg-amber-600 group-hover:text-white transition-colors">
                <svg class="size-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"/></svg>
            </div>
        </div>
        <div class="font-bold text-3xl text-gray-800 tracking-tight">{{ sprintf('%02d', $stats['retenues']) }}</div>
    </div>
    <div class="flex flex-col bg-white border border-gray-200 shadow-sm rounded-xl p-5 hover:border-indigo-200 transition group">
        <div class="flex items-center justify-between mb-2">
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Favoris</p>
            <div class="size-8 bg-rose-50 text-rose-600 rounded-lg flex items-center justify-center group-hover:bg-rose-600 group-hover:text-white transition-colors">
                <svg class="size-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
            </div>
        </div>
        <div class="font-bold text-3xl text-gray-800 tracking-tight">{{ sprintf('%02d', $stats['favoris']) }}</div>
    </div>
</div>
