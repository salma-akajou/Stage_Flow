window.openUserDetailModal = function(userId) {
    const wrapper = document.getElementById('user-detail-modal-wrapper');
    const card = document.getElementById('user-detail-modal-card');
    if (!wrapper || !card) return;
    
    fetch(`/admin/users/${userId}`, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
    .then(res => res.json())
    .then(user => {
        // Basic Info
        document.getElementById('modal-user-name').textContent = user.role === 'entreprise' ? user.entreprise.nom_entreprise : `${user.prenom} ${user.nom}`;
        document.getElementById('modal-user-email').textContent = user.email;
        document.getElementById('modal-user-photo').src = user.avatar_url ? `/storage/${user.avatar_url}` : `https://ui-avatars.com/api/?name=${user.prenom}+${user.nom}&background=random`;
        
        // Role
        const role = user.role ? user.role.toUpperCase() : 'UTILISATEUR';
        document.getElementById('modal-user-role-badge').textContent = role;
        
        document.getElementById('modal-user-bio').textContent = user.etudiant?.bio || user.entreprise?.bio || 'Aucune description fournie.';
        
        const banner = document.getElementById('modal-banner');
        if (banner) {
            banner.className = 'h-24 bg-white border-b border-gray-100 w-full';
        }

        // Infos Grid
        const grid = document.getElementById('modal-info-grid');
        if (grid) {
            grid.innerHTML = '';
            const addInfo = (icon, label, value, color) => {
                grid.innerHTML += `
                    <div class="p-4 bg-white rounded-[1.5rem] border border-gray-100 flex items-center gap-4 shadow-sm">
                        <div class="size-10 bg-${color}-50 rounded-2xl flex items-center justify-center text-${color}-600 shrink-0">
                            ${icon}
                        </div>
                        <div class="min-w-0">
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">${label}</p>
                            <p class="text-xs font-black text-gray-800 truncate">${value ?? 'N/A'}</p>
                        </div>
                    </div>`;
            };

            if(user.role === 'etudiant') {
                addInfo('<svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M12 14l9-5-9-5-9 5 9 5z"/><path d="M12 14v7"/></svg>', 'École', user.etudiant.etablissement?.nom, 'blue');
                addInfo('<svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M12 14l9-5-9-5-9 5 9 5z"/><path d="M12 14v7"/></svg>', 'Niveau', user.etudiant.niveau_etudes, 'emerald');
                addInfo('<svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>', 'Ville', user.etudiant.ville?.nom, 'amber');
                addInfo('<svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>', 'Vues', user.etudiant.vues ?? 0, 'rose');
            } else if(user.role === 'entreprise') {
                addInfo('<svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5"/></svg>', 'Secteur', user.entreprise.secteur?.nom, 'indigo');
                addInfo('<svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M17 20h5v-2a3 3 0 00-5.356-1.857"/></svg>', 'Taille', user.entreprise.taille, 'blue');
                addInfo('<svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>', 'Adresse', user.entreprise.adresse, 'amber');
                addInfo('<svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>', 'Vues', user.entreprise.vues ?? 0, 'rose');
            }
        }

        // Activity with Descriptions
        const activityList = document.getElementById('modal-activity-list');
        const activityEmpty = document.getElementById('modal-activity-empty');
        const activityTitle = document.getElementById('modal-activity-title');
        
        if (activityList) {
            activityList.innerHTML = '';
            
            if(user.role === 'etudiant') {
                if (activityTitle) activityTitle.innerHTML = '<span class="size-2 bg-blue-500 rounded-full animate-pulse"></span> Candidatures Récentes';
                if(user.etudiant.candidatures.length > 0) {
                    if (activityEmpty) activityEmpty.style.display = 'none';
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
                } else if (activityEmpty) activityEmpty.style.display = 'block';
            } else {
                if (activityTitle) activityTitle.innerHTML = '<span class="size-2 bg-violet-500 rounded-full animate-pulse"></span> Dernières Offres';
                if(user.entreprise.offres.length > 0) {
                    if (activityEmpty) activityEmpty.style.display = 'none';
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
                } else if (activityEmpty) activityEmpty.style.display = 'block';
            }
        }

        // Feedbacks
        const feedbacksList = document.getElementById('modal-feedbacks-list');
        const feedbacksEmpty = document.getElementById('modal-feedbacks-empty');
        if (feedbacksList) {
            feedbacksList.innerHTML = '';
            if(user.feedbacks.length > 0) {
                if (feedbacksEmpty) feedbacksEmpty.style.display = 'none';
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
            } else if (feedbacksEmpty) feedbacksEmpty.style.display = 'block';
        }

        // Blur everything
        const layoutWrapper = document.getElementById('admin-layout-wrapper');
        if(layoutWrapper) layoutWrapper.classList.add('blur-[6px]', 'scale-[0.99]');

        wrapper.style.display = 'block';
        setTimeout(() => { wrapper.classList.remove('opacity-0'); card.classList.remove('scale-95'); }, 10);
    });
};

window.closeUserDetailModal = function() {
    const wrapper = document.getElementById('user-detail-modal-wrapper');
    const card = document.getElementById('user-detail-modal-card');
    const layoutWrapper = document.getElementById('admin-layout-wrapper');
    if(layoutWrapper) layoutWrapper.classList.remove('blur-[6px]', 'scale-[0.99]');
    if (wrapper && card) {
        wrapper.classList.add('opacity-0'); 
        card.classList.add('scale-95');
        setTimeout(() => { wrapper.style.display = 'none'; }, 300);
    }
};

