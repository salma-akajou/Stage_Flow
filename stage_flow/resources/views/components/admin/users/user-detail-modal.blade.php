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
                    <div id="modal-banner" class="h-24 bg-gradient-to-r from-indigo-600 to-violet-600 w-full"></div>
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

<script>
function openUserDetailModal(userId) {
    const wrapper = document.getElementById('user-detail-modal-wrapper');
    const card = document.getElementById('user-detail-modal-card');
    
    fetch(`/admin/users/${userId}`, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
    .then(res => res.json())
    .then(user => {
        // Basic Info
        document.getElementById('modal-user-name').textContent = user.role === 'entreprise' ? user.entreprise.nom_entreprise : `${user.prenom} ${user.nom}`;
        document.getElementById('modal-user-email').textContent = user.email;
        document.getElementById('modal-user-photo').src = user.avatar_url ? `/storage/${user.avatar_url}` : `https://ui-avatars.com/api/?name=${user.prenom}+${user.nom}&background=random`;
        
        // Role & Status
        const role = user.role ? user.role.toUpperCase() : 'UTILISATEUR';
        document.getElementById('modal-user-role-badge').textContent = role;
        document.getElementById('modal-user-status-badge').textContent = (user.statut || 'ACTIF').toUpperCase();
        document.getElementById('modal-user-status-badge').className = `py-1 px-3 ${user.statut === 'actif' ? 'bg-emerald-500' : 'bg-rose-500'} text-white text-[10px] font-black uppercase tracking-widest rounded-full shadow-sm`;
        
        document.getElementById('modal-user-bio').textContent = user.etudiant?.bio || user.entreprise?.bio || 'Aucune description fournie.';
        
        const banner = document.getElementById('modal-banner');
        banner.className = `h-24 bg-gradient-to-r ${user.role === 'etudiant' ? 'from-blue-600 to-indigo-600' : 'from-indigo-600 to-violet-600'} w-full`;

        // Infos Grid
        const grid = document.getElementById('modal-info-grid');
        grid.innerHTML = '';
        const addInfo = (icon, label, value, color) => {
            grid.innerHTML += `
                <div class="p-4 bg-white rounded-[1.5rem] border border-gray-100 flex items-center gap-4 shadow-sm">
                    <div class="size-10 bg-${color}-50 rounded-2xl flex items-center justify-center text-${color}-600 shrink-0">
                        ${icon}
                    </div>
                    <div class="min-w-0">
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">${label}</p>
                        <p class="text-xs font-black text-gray-800 truncate">${value || 'N/A'}</p>
                    </div>
                </div>`;
        };

        if(user.role === 'etudiant') {
            addInfo('<svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M12 14l9-5-9-5-9 5 9 5z"/><path d="M12 14v7"/></svg>', 'École', user.etudiant.etablissement, 'blue');
            addInfo('<svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M12 14l9-5-9-5-9 5 9 5z"/><path d="M12 14v7"/></svg>', 'Niveau', user.etudiant.niveau_etudes, 'emerald');
            addInfo('<svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>', 'Ville', user.etudiant.ville?.nom, 'amber');
            addInfo('<svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>', 'Vues', user.etudiant.vues, 'rose');
        } else if(user.role === 'entreprise') {
            addInfo('<svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5"/></svg>', 'Secteur', user.entreprise.secteur, 'indigo');
            addInfo('<svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M17 20h5v-2a3 3 0 00-5.356-1.857"/></svg>', 'Taille', user.entreprise.taille, 'blue');
            addInfo('<svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>', 'Adresse', user.entreprise.adresse, 'amber');
            addInfo('<svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>', 'Vues', user.entreprise.vues, 'rose');
        }

        // Activity with Descriptions
        const activityList = document.getElementById('modal-activity-list');
        const activityEmpty = document.getElementById('modal-activity-empty');
        const activityTitle = document.getElementById('modal-activity-title');
        activityList.innerHTML = '';
        
        if(user.role === 'etudiant') {
            activityTitle.innerHTML = '<span class="size-2 bg-blue-500 rounded-full animate-pulse"></span> Candidatures Récentes';
            if(user.etudiant.candidatures.length > 0) {
                activityEmpty.style.display = 'none';
                user.etudiant.candidatures.forEach(can => {
                    activityList.innerHTML += `
                        <div class="p-4 bg-white rounded-2xl border border-gray-100 shadow-sm">
                            <div class="flex items-center justify-between mb-2">
                                <p class="text-sm font-bold text-gray-900 truncate">${can.offre.titre}</p>
                                <span class="py-1 px-2.5 bg-gray-50 text-gray-600 text-[10px] font-black uppercase rounded-lg border border-gray-100">${can.statut}</span>
                            </div>
                            <p class="text-xs text-gray-500 line-clamp-1 italic font-medium leading-relaxed">${can.offre.description || ''}</p>
                        </div>`;
                });
            } else activityEmpty.style.display = 'block';
        } else {
            activityTitle.innerHTML = '<span class="size-2 bg-violet-500 rounded-full animate-pulse"></span> Dernières Offres';
            if(user.entreprise.offres.length > 0) {
                activityEmpty.style.display = 'none';
                user.entreprise.offres.forEach(offre => {
                    activityList.innerHTML += `
                        <div class="p-4 bg-white rounded-2xl border border-gray-100 shadow-sm">
                            <div class="flex items-center justify-between mb-2">
                                <p class="text-sm font-bold text-gray-900 truncate">${offre.titre}</p>
                                <span class="py-1 px-2.5 bg-indigo-50 text-indigo-600 text-[10px] font-black uppercase rounded-lg border border-indigo-100/50">${offre.candidatures_count} postul.</span>
                            </div>
                            <p class="text-xs text-gray-500 line-clamp-1 italic font-medium leading-relaxed">${offre.description || ''}</p>
                        </div>`;
                });
            } else activityEmpty.style.display = 'block';
        }

        // Feedbacks
        const feedbacksList = document.getElementById('modal-feedbacks-list');
        const feedbacksEmpty = document.getElementById('modal-feedbacks-empty');
        feedbacksList.innerHTML = '';
        if(user.feedbacks.length > 0) {
            feedbacksEmpty.style.display = 'none';
            user.feedbacks.forEach(fb => {
                feedbacksList.innerHTML += `
                    <div class="p-4 bg-white rounded-2xl border border-gray-100 shadow-sm">
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex gap-0.5">${Array(fb.note).fill('<svg class="size-3 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>').join('')}</div>
                            <span class="text-[9px] text-gray-400 font-bold uppercase tracking-widest">${fb.valide ? 'Publié' : 'Attente'}</span>
                        </div>
                        <p class="text-xs text-gray-600 leading-relaxed font-medium italic">"${fb.texte}"</p>
                    </div>`;
            });
        } else feedbacksEmpty.style.display = 'block';

        // Blur everything
        const layoutWrapper = document.getElementById('admin-layout-wrapper');
        if(layoutWrapper) layoutWrapper.classList.add('blur-[6px]', 'scale-[0.99]');

        wrapper.style.display = 'block';
        setTimeout(() => { wrapper.classList.remove('opacity-0'); card.classList.remove('scale-95'); }, 10);
    });
}

function closeUserDetailModal() {
    const wrapper = document.getElementById('user-detail-modal-wrapper');
    const card = document.getElementById('user-detail-modal-card');
    const layoutWrapper = document.getElementById('admin-layout-wrapper');
    if(layoutWrapper) layoutWrapper.classList.remove('blur-[6px]', 'scale-[0.99]');
    wrapper.classList.add('opacity-0'); card.classList.add('scale-95');
    setTimeout(() => { wrapper.style.display = 'none'; }, 300);
}
</script>
