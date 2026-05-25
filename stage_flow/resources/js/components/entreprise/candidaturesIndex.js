export default (routeIndex = '', initialTotal = 0) => ({
    init() {
        window.candidatureApp = this;
    },
    search: '',
    status: '',
    offreId: '',
    offreTitre: '',
    totalCount: initialTotal,

    showToast(message, type = 'success') {
        Alpine.store('toast').display(message, type);
    },
    
    statusLabel() {
        return this.status || 'Tous les statuts';
    },
    
    offreLabel() {
        return this.offreId ? this.offreTitre : 'Toutes les offres';
    },

    fetchCandidatures(url = routeIndex) {
        const params = new URLSearchParams();
        if (this.search) params.append('search', this.search);
        if (this.status) params.append('statut', this.status);
        if (this.offreId) params.append('offre_id', this.offreId);

        const finalUrl = `${url}${url.includes('?') ? '&' : '?'}${params.toString()}`;

        fetch(finalUrl, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(res => res.text())
        .then(html => {
            document.getElementById('table-content').innerHTML = html;
            this.initPagination();
        });
    },

    initPagination() {
        document.querySelectorAll('#table-content .pagination a').forEach(link => {
            link.addEventListener('click', (e) => {
                e.preventDefault();
                this.fetchCandidatures(link.href);
            });
        });
    }
});

window.updateStatus = function(id, newStatus) {
    const title = newStatus === 'Accepté' ? 'Accepter la candidature' : 'Refuser la candidature';
    const msg = `Souhaitez-vous vraiment modifier le statut de cette candidature en "${newStatus.toLowerCase()}" ?`;
    
    Alpine.store('confirm').open(title, msg, () => {
        fetch(`/entreprise/candidatures/${id}/status`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ status: newStatus })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                if (window.candidatureApp) {
                    window.candidatureApp.showToast(newStatus === 'Accepté' ? 'Candidature acceptée avec succès !' : 'Candidature refusée.');
                    window.candidatureApp.fetchCandidatures();
                } else {
                    Alpine.store('toast').display(newStatus === 'Accepté' ? 'Candidature acceptée avec succès !' : 'Candidature refusée.');
                    setTimeout(() => window.location.reload(), 1000);
                }
            }
        })
        .catch(err => {
            console.error(err);
            if (window.candidatureApp) {
                window.candidatureApp.showToast('Une erreur est survenue.', 'error');
            } else {
                Alpine.store('toast').display('Une erreur est survenue.', 'error');
            }
        });
    });
};
