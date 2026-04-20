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
