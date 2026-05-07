<div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6" data-aos="fade-up" data-aos-delay="100">
    <div class="flex flex-col bg-white border border-gray-200 shadow-sm rounded-2xl p-4 sm:p-5">
        <p class="text-[10px] uppercase tracking-widest text-gray-400 font-bold">Total Candidatures</p>
        <h3 class="text-2xl font-black text-gray-800 mt-2">{{ $stats['total'] }}</h3>
    </div>
    <div class="flex flex-col bg-white border border-gray-200 shadow-sm rounded-2xl p-4 sm:p-5">
        <p class="text-[10px] uppercase tracking-widest text-amber-500 font-bold">En attente</p>
        <h3 class="text-2xl font-black text-gray-800 mt-2">{{ $stats['attente'] }}</h3>
    </div>
    <div class="flex flex-col bg-white border border-gray-200 shadow-sm rounded-2xl p-4 sm:p-5">
        <p class="text-[10px] uppercase tracking-widest text-emerald-500 font-bold">Acceptées</p>
        <h3 class="text-2xl font-black text-gray-800 mt-2">{{ $stats['accepte'] }}</h3>
    </div>
    <div class="flex flex-col bg-white border border-gray-200 shadow-sm rounded-2xl p-4 sm:p-5">
        <p class="text-[10px] uppercase tracking-widest text-rose-500 font-bold">Refusées</p>
        <h3 class="text-2xl font-black text-gray-800 mt-2">{{ $stats['refuse'] }}</h3>
    </div>
</div>
