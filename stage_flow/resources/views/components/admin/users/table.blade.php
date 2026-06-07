<div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden" data-aos="fade-up">
    <div class="flex flex-col">
        <div class="-m-1.5 overflow-x-auto">
            <div class="p-1.5 min-w-full inline-block align-middle">
                <div class="overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-4 text-start text-xs font-semibold text-gray-500 uppercase tracking-wider">Utilisateur</th>
                                <th scope="col" class="px-6 py-4 text-start text-xs font-semibold text-gray-500 uppercase tracking-wider">Email</th>
                                <th scope="col" class="px-6 py-4 text-start text-xs font-semibold text-gray-500 uppercase tracking-wider">Rôle</th>

                                <th scope="col" class="px-6 py-4 text-start text-xs font-semibold text-gray-500 uppercase tracking-wider">Inscription</th>
                                <th scope="col" class="px-6 py-4 text-end text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($users as $user)
                            <tr class="hover:bg-gray-50/80 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-3 cursor-pointer group" onclick="openUserDetailModal({{ $user->id }})">
                                        <div class="size-9 rounded-xl overflow-hidden border border-gray-100 bg-gray-50 flex items-center justify-center shrink-0 shadow-sm group-hover:shadow transition-all group-hover:scale-105">
                                            @if($user->avatar_url)
                                                <img src="{{ asset('storage/' . $user->avatar_url) }}" class="size-full object-cover">
                                            @else
                                                <span class="text-xs font-black text-indigo-500">{{ substr($user->prenom, 0, 1) }}{{ substr($user->nom, 0, 1) }}</span>
                                            @endif
                                        </div>
                                        <div class="text-sm font-bold text-gray-800 group-hover:text-indigo-600 transition-colors">{{ $user->prenom }} {{ $user->nom }}</div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-600 font-medium">{{ $user->email }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $role = 'Utilisateur';
                                        if (method_exists($user, 'getRoleNames') && $user->getRoleNames()->isNotEmpty()) {
                                            $role = $user->getRoleNames()->first();
                                        } elseif ($user->etudiant) {
                                            $role = 'etudiant';
                                        } elseif ($user->entreprise) {
                                            $role = 'entreprise';
                                        } elseif ($user->id == 1) {
                                            $role = 'admin';
                                        }
                                    @endphp
                                    <span class="px-2.5 py-1 inline-flex items-center text-[10px] font-bold uppercase tracking-wider rounded-lg bg-gray-100 text-gray-600 border border-gray-200">
                                        {{ $role }}
                                    </span>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-medium">
                                    {{ $user->created_at->translatedFormat('d M Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium">
                                    <div class="flex items-center justify-end gap-x-1">
                                        @can('gerer-utilisateurs')

                                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline" onsubmit="return confirm('Supprimer définitivement cet utilisateur ?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-2 inline-flex justify-center items-center rounded-lg text-gray-400 hover:text-rose-600 hover:bg-rose-50 transition" title="Supprimer">
                                                    <svg class="size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
                                                </button>
                                            </form>
                                        @endcan
                                        @cannot('gerer-utilisateurs')
                                            <button type="button" disabled class="p-2 inline-flex justify-center items-center rounded-lg text-gray-200 cursor-not-allowed" title="Action non autorisée">
                                                <svg class="size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
                                            </button>
                                        @endcannot
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center gap-3">
                                        <div class="size-12 rounded-full bg-gray-50 flex items-center justify-center border border-gray-100">
                                            <svg class="size-6 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                                        </div>
                                        <p class="text-gray-500 font-medium">Aucun utilisateur trouvé pour ces critères.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    @if($users->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $users->links('components.pagination') }}
        </div>
    @endif
</div>

