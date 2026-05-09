<div class="bg-white border border-gray-200 rounded-2xl p-4 shadow-sm flex flex-wrap gap-3 items-center mb-8" 
     x-data="{ 
    search: '', 
    valide: '',
    updateTable() {
        fetch(`{{ route('admin.feedbacks.index') }}?search=${this.search}&valide=${this.valide}`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(res => res.text())
        .then(html => {
            document.getElementById('feedbacks-table-container').innerHTML = html;
        });
    }
}" data-aos="fade-up" data-aos-delay="75">
    <!-- Recherche -->
    <div class="relative flex-1 min-w-[200px] group">
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-indigo-600 transition-colors">
            <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8" /><path d="m21 21-4.3-4.3" /></svg>
        </div>
        <input type="text" x-model="search" @input.debounce.300ms="updateTable()" 
               placeholder="Rechercher un feedback..." 
               class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl text-sm font-medium focus:border-indigo-500 focus:ring-indigo-500 transition-all">
    </div>

    <!-- Filtre Rôle (Dropdown style maquette) -->
    <div class="relative min-w-[150px]" x-data="{ open: false, options: { '': 'Tous les rôles', 'etudiant': 'Étudiant', 'entreprise': 'Entreprise' } }">
        <button @click="open = !open" @click.away="open = false" type="button" 
                class="py-2.5 px-4 w-full flex items-center justify-between gap-4 bg-white border border-gray-200 rounded-xl text-sm font-medium hover:border-indigo-500 transition-all">
            <span x-text="options[valide] || 'Tous les rôles'"></span>
            <svg :class="{ 'rotate-180': open }" class="size-4 text-gray-400 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
        </button>
        <div x-show="open" x-transition.opacity style="display: none;" class="absolute top-full right-0 mt-2 z-[50] w-full bg-white shadow-xl rounded-xl p-2 border border-gray-100">
            <template x-for="(label, value) in options">
                <button @click="valide = value; open = false; updateTable()" 
                        class="flex items-center w-full py-2 px-3 rounded-lg text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition font-medium mb-0.5"
                        :class="valide === value ? 'bg-indigo-50 text-indigo-700' : ''"
                        x-text="label"></button>
            </template>
        </div>
    </div>
</div>
