window.openOfferModal = function(isNew = true) {
    if (isNew) {
        window.dispatchEvent(new CustomEvent('reset-modal'));
    }
    const wrapper = document.getElementById('offer-modal-wrapper');
    const card = document.getElementById('offer-modal-card');
    if (wrapper && wrapper.parentElement !== document.body) {
        document.body.appendChild(wrapper);
    }
    if (wrapper && card) {
        wrapper.style.display = 'block';
        setTimeout(() => {
            wrapper.classList.replace('opacity-0', 'opacity-100');
            card.classList.replace('scale-95', 'scale-100');
        }, 10);
        document.body.style.overflow = 'hidden';
    }
};

window.closeOfferModal = function() {
    const wrapper = document.getElementById('offer-modal-wrapper');
    const card = document.getElementById('offer-modal-card');
    if (wrapper && card) {
        wrapper.classList.replace('opacity-100', 'opacity-0');
        card.classList.replace('scale-100', 'scale-95');
        setTimeout(() => {
            wrapper.style.display = 'none';
            document.body.style.overflow = '';
        }, 300);
    }
};

window.openEditModal = function(id) {
    window.dispatchEvent(new CustomEvent('open-modal', { detail: id }));
};

window.openDetailModal = function(id, btn = null) {
    const wrapper = document.getElementById('candidature-detail-modal-wrapper');
    const card = document.getElementById('candidature-detail-card');
    if (wrapper.parentElement !== document.body) {
        document.body.appendChild(wrapper);
    }
    
    if (btn) {
        const row = btn.closest('tr');
        const name = row.querySelector('p.font-semibold')?.innerText || '';
        const status = row.querySelector('[id^="status-badge"]')?.innerText || '';
        document.getElementById('det-nom').innerHTML = name;
        document.getElementById('det-status-badge').innerText = status;
        document.getElementById('det-bio').innerHTML = '<span class="bg-gray-100 animate-pulse h-3 w-32 rounded inline-block"></span>';
        document.getElementById('det-photo').src = '';
        document.getElementById('det-photo').classList.add('opacity-0');
        document.getElementById('det-photo-skeleton').style.display = 'block';
        document.getElementById('det-tel').innerText = '-- -- --';
        document.getElementById('det-motivation').style.display = 'none';
        document.getElementById('det-motivation-skeleton').style.display = 'block';
    } else {
        document.getElementById('det-nom').innerText = 'Chargement...';
    }

    wrapper.style.display = 'block';
    document.body.style.overflow = 'hidden';
    setTimeout(() => {
        wrapper.classList.replace('opacity-0', 'opacity-100');
        card.classList.replace('scale-95', 'scale-100');
    }, 10);

    fetch(`/entreprise/candidatures/details/${id}`)
        .then(res => res.json())
        .then(res => {
            if (res.success) {
                const d = res.data;
                const photoEl = document.getElementById('det-photo');
                const photoSkeleton = document.getElementById('det-photo-skeleton');
                if (photoEl) {
                    photoEl.src = d.photo;
                    photoEl.classList.remove('opacity-0');
                }
                if (photoSkeleton) {
                    photoSkeleton.style.display = 'none';
                }
                document.getElementById('det-nom').innerText = d.nom_complet;
                document.getElementById('det-bio').innerText = d.specialite || d.bio || '';
                document.getElementById('det-tel').innerText = d.telephone || '-- -- --';
                
                const motEl = document.getElementById('det-motivation');
                const motSkel = document.getElementById('det-motivation-skeleton');
                if (motEl) {
                    motEl.innerText = d.motivation || 'Pas de message de motivation.';
                    motEl.style.display = 'block';
                }
                if (motSkel) {
                    motSkel.style.display = 'none';
                }
                
                document.getElementById('det-status-badge').innerText = d.statut;
                
                const cvLink = document.getElementById('det-cv-link');
                if (cvLink) {
                    if (d.cv_url) {
                        cvLink.href = d.cv_url;
                        cvLink.style.display = 'inline-flex';
                    } else {
                        cvLink.style.display = 'none';
                    }
                }

                const portfolioLink = document.getElementById('det-portfolio-link');
                if (portfolioLink) {
                    if (d.portfolio) {
                        portfolioLink.href = d.portfolio;
                        portfolioLink.parentElement.parentElement.style.display = 'flex';
                    } else {
                        portfolioLink.parentElement.parentElement.style.display = 'none';
                    }
                }
            }
        });
};

window.closeDetailModal = function() {
    const wrapper = document.getElementById('candidature-detail-modal-wrapper');
    const card = document.getElementById('candidature-detail-card');
    if (wrapper && card) {
        wrapper.classList.replace('opacity-100', 'opacity-0');
        card.classList.replace('scale-100', 'scale-95');
        setTimeout(() => {
            wrapper.style.display = 'none';
            document.body.style.overflow = '';
        }, 300);
    }
};
