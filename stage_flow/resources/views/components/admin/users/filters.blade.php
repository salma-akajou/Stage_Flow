<div class="bg-white border border-gray-200 rounded-2xl p-4 sm:p-6 shadow-sm mb-6" data-aos="fade-up">
    <form id="filters-form" action="{{ route('admin.users.index') }}" method="GET" class="flex flex-col lg:flex-row items-center gap-4"
          x-data="{ 
            search: '{{ request('search') }}',
            role: '{{ request('role') }}',
            statut: '{{ request('statut') }}',
            loading: false,
            submit() {
                this.loading = true;
                const params = new URLSearchParams({
                    search: this.search,
                    role: this.role,
                    statut: this.statut
                });
                
                fetch('{{ route('admin.users.index') }}?' + params.toString(), {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                .then(res => res.text())
                .then(html => {
                    document.getElementById('users-table-container').innerHTML = html;
                    this.loading = false;
                    // Re-init AOS if needed, though usually partials don't need it if not using aos on inner elements
                });
            }
          }">
        
        <div class="relative w-full lg:flex-1">
            <div class="absolute inset-y-0 start-0 flex items-center ps-4 pointer-events-none">
                <svg class="size-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
            </div>
            <input type="text" name="search" x-model="search" @input.debounce.500ms="submit()"
                class="py-3 ps-11 pe-4 block w-full border-gray-200 rounded-xl text-sm focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" 
                placeholder="Rechercher un utilisateur (nom, email)...">
        </div>

        <div class="flex flex-col sm:flex-row items-center gap-3 w-full lg:w-auto">
            <!-- Dropdown Role -->
            <div x-data="{ open: false }" class="relative w-full sm:w-48">
                <button @click="open = !open" @click.away="open = false" type="button" 
                    class="py-3 px-4 w-full flex items-center justify-between gap-x-2 text-sm font-bold rounded-xl border border-gray-200 bg-white text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none transition">
                    <span class="truncate" x-text="role === '' ? 'Tous les rôles' : role.charAt(0).toUpperCase() + role.slice(1)">Tous les rôles</span>
                    <svg :class="{ 'rotate-180': open }" class="size-4 text-gray-400 shrink-0 transition-transform" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="m6 9 6 6 6-6"/></svg>
                </button>
                <div x-show="open" x-transition.opacity style="display: none;" class="absolute top-full left-0 right-0 mt-2 z-[100] bg-white shadow-2xl rounded-2xl p-2 border border-gray-100 min-w-full">
                    <button @click="role = ''; open = false; submit()" type="button" class="w-full flex items-center py-2.5 px-4 rounded-xl text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition font-bold mb-1" :class="role === '' ? 'bg-indigo-50 text-indigo-700' : ''">
                        Tous les rôles
                    </button>
                    <button @click="role = 'etudiant'; open = false; submit()" type="button" class="w-full flex items-center py-2.5 px-4 rounded-xl text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition font-bold mb-1" :class="role === 'etudiant' ? 'bg-indigo-50 text-indigo-700' : ''">Étudiant</button>
                    <button @click="role = 'entreprise'; open = false; submit()" type="button" class="w-full flex items-center py-2.5 px-4 rounded-xl text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition font-bold mb-1" :class="role === 'entreprise' ? 'bg-indigo-50 text-indigo-700' : ''">Entreprise</button>
                    <button @click="role = 'admin'; open = false; submit()" type="button" class="w-full flex items-center py-2.5 px-4 rounded-xl text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition font-bold mb-1" :class="role === 'admin' ? 'bg-indigo-50 text-indigo-700' : ''">Admin</button>
                </div>
            </div>

            <!-- Dropdown Statut -->
            <div x-data="{ open: false }" class="relative w-full sm:w-48">
                <button @click="open = !open" @click.away="open = false" type="button" 
                    class="py-3 px-4 w-full flex items-center justify-between gap-x-2 text-sm font-bold rounded-xl border border-gray-200 bg-white text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none transition">
                    <span class="truncate" x-text="statut === '' ? 'Tous les statuts' : statut.charAt(0).toUpperCase() + statut.slice(1)">Tous les statuts</span>
                    <svg :class="{ 'rotate-180': open }" class="size-4 text-gray-400 shrink-0 transition-transform" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="m6 9 6 6 6-6"/></svg>
                </button>
                <div x-show="open" x-transition.opacity style="display: none;" class="absolute top-full left-0 right-0 mt-2 z-[100] bg-white shadow-2xl rounded-2xl p-2 border border-gray-100 min-w-full">
                    <button @click="statut = ''; open = false; submit()" type="button" class="w-full flex items-center py-2.5 px-4 rounded-xl text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition font-bold mb-1" :class="statut === '' ? 'bg-indigo-50 text-indigo-700' : ''">
                        Tous les statuts
                    </button>
                    <button @click="statut = 'actif'; open = false; submit()" type="button" class="w-full flex items-center py-2.5 px-4 rounded-xl text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition font-bold mb-1" :class="statut === 'actif' ? 'bg-indigo-50 text-indigo-700' : ''">Actif</button>
                    <button @click="statut = 'suspendu'; open = false; submit()" type="button" class="w-full flex items-center py-2.5 px-4 rounded-xl text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition font-bold mb-1" :class="statut === 'suspendu' ? 'bg-indigo-50 text-indigo-700' : ''">Suspendu</button>
                </div>
            </div>
        </div>
    </form>
</div>
