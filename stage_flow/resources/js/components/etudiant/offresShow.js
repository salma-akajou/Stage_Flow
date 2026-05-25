window.openEntrepriseModal = function(id) {
    const wrapper = document.getElementById('entreprise-modal-wrapper');
    const card    = document.getElementById('entreprise-modal-card');
    const content = document.getElementById('modal-content-container');
    const spinner = document.getElementById('modal-loading-spinner');

    if (wrapper.parentElement !== document.body) { 
        document.body.appendChild(wrapper); 
    }

    spinner.classList.remove('hidden');
    content.classList.replace('opacity-100', 'opacity-0');

    wrapper.style.display = 'block';
    document.body.style.overflow = 'hidden';

    setTimeout(() => {
        wrapper.classList.remove('opacity-0');
        wrapper.classList.add('opacity-100');
        card.classList.remove('scale-95');
        card.classList.add('scale-100');
    }, 10);

    fetch(`/student/entreprises/${id}/profile`)
        .then(r => r.json())
        .then(res => {
            if (!res.success) return;
            const { entreprise: ent, offres } = res.data;

            const logoImg  = document.getElementById('modal-entreprise-logo');
            const initSpan = document.getElementById('modal-entreprise-initial');
            if (ent.logoUrl) {
                logoImg.src = ent.logoUrl;
                logoImg.classList.remove('hidden');
                initSpan.classList.add('hidden');
            } else {
                initSpan.textContent = ent.lettreInitiale || (ent.nom_entreprise ? ent.nom_entreprise.charAt(0) : 'E');
                initSpan.classList.remove('hidden');
                logoImg.classList.add('hidden');
            }

            document.getElementById('modal-entreprise-name').textContent    = ent.nom_entreprise || 'Non renseigné';
            document.getElementById('modal-entreprise-secteur').textContent = ent.secteur || 'Non défini';
            document.getElementById('modal-entreprise-taille').textContent  = ent.taille || 'Non défini';
            document.getElementById('modal-entreprise-ville').textContent   = ent.ville ? ent.ville.nom : 'Non définie';

            const bioSection = document.getElementById('modal-section-bio');
            if (ent.bio && ent.bio.trim() !== '') {
                document.getElementById('modal-entreprise-bio').textContent = ent.bio;
                bioSection.classList.remove('hidden');
            } else {
                bioSection.classList.add('hidden');
            }

            const rcRow = document.getElementById('modal-contact-rc');
            if (ent.registre_commerce) { document.getElementById('modal-rc-text').textContent = ent.registre_commerce; rcRow.classList.remove('hidden'); }
            else { rcRow.classList.add('hidden'); }

            const adresseRow = document.getElementById('modal-contact-adresse');
            if (ent.adresse || (ent.ville && ent.ville.nom)) { 
                document.getElementById('modal-adresse-text').textContent = ent.adresse || ent.ville.nom; 
                adresseRow.classList.remove('hidden'); 
            } else { adresseRow.classList.add('hidden'); }

            const emailRow = document.getElementById('modal-contact-email');
            if (ent.email_contact) {
                const emailEl = document.getElementById('modal-email-text');
                emailEl.textContent = ent.email_contact;
                emailEl.href = `mailto:${ent.email_contact}`;
                emailRow.classList.remove('hidden');
            } else { emailRow.classList.add('hidden'); }

            const list  = document.getElementById('modal-offres-list');
            const empty = document.getElementById('modal-offres-empty');
            list.innerHTML = '';

            if (offres && offres.length > 0) {
                empty.classList.add('hidden');
                offres.forEach(offre => {
                    const descriptionShort = offre.description ? offre.description.substring(0, 180) + (offre.description.length > 180 ? '...' : '') : '';
                    list.innerHTML += `
                    <a href="/offres/${offre.id}" class="block bg-white border border-gray-100 rounded-xl p-4 hover:border-indigo-300 hover:shadow-md transition-all duration-300 group">
                        <h5 class="text-sm font-bold text-gray-900 group-hover:text-indigo-600 transition leading-snug mb-2.5">${offre.titre}</h5>
                        <div class="flex flex-wrap gap-2 mb-3">
                            ${offre.secteur ? `<span class="text-[10px] font-bold text-indigo-700 bg-indigo-50 border border-indigo-100 px-2 py-0.5 rounded-md">${offre.secteur}</span>` : ''}
                            ${offre.type_stage ? `<span class="text-[10px] font-bold text-gray-600 bg-gray-50 border border-gray-200 px-2 py-0.5 rounded-md">${offre.type_stage}</span>` : ''}
                            ${offre.duree ? `<span class="text-[10px] font-bold text-blue-700 bg-blue-50 border border-blue-100 px-2 py-0.5 rounded-md">${offre.duree}</span>` : ''}
                            ${offre.remuneration && offre.remuneration !== 'Non' && offre.remuneration !== 'Non rémunéré' ? `<span class="text-[10px] font-bold text-emerald-700 bg-emerald-50 border border-emerald-100 px-2 py-0.5 rounded-md">${offre.remuneration}</span>` : ''}
                        </div>
                        ${descriptionShort ? `<p class="text-[11px] text-gray-500 leading-relaxed mb-3 line-clamp-3">${descriptionShort}</p>` : ''}
                        <div class="flex justify-end mt-1">
                            <span class="inline-flex items-center gap-1 text-[10px] font-bold text-indigo-600 bg-indigo-50 px-2.5 py-1 rounded-lg group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                                Détails <svg class="size-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </span>
                        </div>
                    </a>`;
                });
            } else {
                empty.classList.remove('hidden');
            }

            setTimeout(() => {
                spinner.classList.add('hidden');
                content.classList.replace('opacity-0', 'opacity-100');
            }, 200);
        })
        .catch(() => {
            spinner.innerHTML = '<div class="bg-red-50 p-4 rounded-xl text-center"><p class="text-red-500 text-sm font-bold">Impossible de charger le profil.</p></div>';
        });
};

window.closeEntrepriseModal = function() {
    const wrapper = document.getElementById('entreprise-modal-wrapper');
    const card    = document.getElementById('entreprise-modal-card');

    wrapper.classList.remove('opacity-100');
    wrapper.classList.add('opacity-0');
    card.classList.remove('scale-100');
    card.classList.add('scale-95');

    setTimeout(() => {
        wrapper.style.display = 'none';
        document.body.style.overflow = '';
    }, 300);
};

window.openCandidatureModal = function() {
    const wrapper = document.getElementById('candidature-modal-wrapper');
    const card    = document.getElementById('candidature-modal-card');

    if (wrapper.parentElement !== document.body) { 
        document.body.appendChild(wrapper); 
    }

    wrapper.style.display = 'block';
    document.body.style.overflow = 'hidden';

    setTimeout(() => {
        wrapper.classList.remove('opacity-0');
        wrapper.classList.add('opacity-100');
        card.classList.remove('scale-95');
        card.classList.add('scale-100');
    }, 10);
};

window.closeCandidatureModal = function() {
    const wrapper = document.getElementById('candidature-modal-wrapper');
    const card    = document.getElementById('candidature-modal-card');

    wrapper.classList.remove('opacity-100');
    wrapper.classList.add('opacity-0');
    card.classList.remove('scale-100');
    card.classList.add('scale-95');

    setTimeout(() => {
        wrapper.style.display = 'none';
        document.body.style.overflow = '';
    }, 300);
};
