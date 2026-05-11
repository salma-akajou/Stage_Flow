@extends('layouts.entreprise')

@section('title', 'Candidatures Reçues - StageFlow')

@section('content')
<div class="relative min-h-screen space-y-10" x-data="candidatureManager()" x-init="initPagination()">
    <div class="fixed inset-0 pointer-events-none overflow-hidden z-[-1] opacity-[0.06]">
        <div class="absolute top-20 left-10 animate-bounce duration-[10s]">
            <svg class="size-64 text-indigo-200" fill="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/></svg>
        </div>
        <div class="absolute bottom-20 right-20 animate-pulse duration-[8s]">
            <svg class="size-80 text-blue-100" fill="currentColor" viewBox="0 0 24 24"><rect width="20" height="20" x="2" y="2" rx="5"/></svg>
        </div>
        <div class="absolute top-1/2 left-1/4 animate-spin duration-[20s]">
            <svg class="size-48 text-indigo-50" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5z"/></svg>
        </div>
    </div>

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4" data-aos="fade-down">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900">Candidatures <span class="text-indigo-600">Récentes</span></h1>
            <p class="text-sm text-gray-500 mt-1 font-medium">Analysez les profils et sélectionnez vos futurs stagiaires</p>
        </div>
        <div class="flex items-center gap-2 text-xs font-bold bg-white border border-gray-200 px-4 py-2 rounded-xl shadow-sm">
            <span class="size-2 bg-indigo-500 rounded-full animate-pulse"></span>
            Total : <span x-text="totalCount">{{ $candidatures->total() }}</span> candidatures
        </div>
    </div>

    @include('components.entreprise.candidatures.filters')

    <div id="table-content" class="relative mt-10" data-aos="fade-up" data-aos-delay="100">
        @include('components.entreprise.candidatures.table')
    </div>

    @push('modals')
        @include('components.entreprise.candidatures.detail-candidature-modal')
    @endpush
</div>

@push('scripts')
<script>
    function candidatureManager() {
        return {
            init() {
                window.candidatureApp = this;
            },
            search: '',
            status: '',
            offreId: '',
            offreTitre: '',
            totalCount: {{ $candidatures->total() }},

            showToast(message, type = 'success') {
                Alpine.store('toast').display(message, type);
            },
            
            statusLabel() {
                return this.status || 'Tous les statuts';
            },
            
            offreLabel() {
                return this.offreId ? this.offreTitre : 'Toutes les offres';
            },

            fetchCandidatures(url = '{{ route("entreprise.candidatures.index") }}') {
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
        }
    }

    function openCandidatureDetails(btn, id) {
        const wrapper = document.getElementById('candidature-detail-modal-wrapper');
        const card = document.getElementById('candidature-detail-card');
        const row = btn.closest('tr');
        
        const name = row.querySelector('p.font-semibold').innerText;
        const status = row.querySelector('[id^="status-badge"]').innerText;

        document.getElementById('det-nom').innerHTML = name;
        document.getElementById('det-bio').innerHTML = '<span class="bg-gray-100 animate-pulse h-3 w-32 rounded inline-block"></span>';
        
        document.getElementById('det-photo').src = '';
        document.getElementById('det-photo').classList.add('opacity-0');
        document.getElementById('det-photo-skeleton').style.display = 'block';
        
        document.getElementById('det-status-badge').innerText = status;
        document.getElementById('det-tel').innerText = '-- -- --';
        document.getElementById('det-motivation').style.display = 'none';
        document.getElementById('det-motivation-skeleton').style.display = 'block';
        
        document.body.style.overflow = 'hidden'; 
        wrapper.style.display = 'block';
        setTimeout(() => {
            wrapper.classList.remove('opacity-0');
            card.classList.remove('scale-95');
        }, 10);

        fetch(`/entreprise/candidatures/details/${id}`)
            .then(res => res.json())
            .then(res => {
                const d = res.data;
                document.getElementById('det-photo').src = d.photo;
                document.getElementById('det-nom').innerText = d.nom_complet;
                document.getElementById('det-bio').innerText = d.specialite;
                document.getElementById('det-tel').innerText = d.telephone;
                document.getElementById('det-motivation').innerText = d.motivation || 'Pas de message de motivation.';
                document.getElementById('det-motivation').style.display = 'block';
                document.getElementById('det-motivation-skeleton').style.display = 'none';
                document.getElementById('det-status-badge').innerText = d.statut;
                
                const cvLink = document.getElementById('det-cv-link');
                if (d.cv_url) {
                    cvLink.href = d.cv_url;
                    cvLink.style.display = 'inline-flex';
                } else {
                    cvLink.style.display = 'none';
                }

                const portfolioLink = document.getElementById('det-portfolio-link');
                if (d.portfolio) {
                    portfolioLink.href = d.portfolio;
                    portfolioLink.parentElement.parentElement.style.display = 'flex';
                } else {
                    portfolioLink.parentElement.parentElement.style.display = 'none';
                }
            });
    }

    function closeDetailModal() {
        const wrapper = document.getElementById('candidature-detail-modal-wrapper');
        const card = document.getElementById('candidature-detail-card');
        
        wrapper.classList.add('opacity-0');
        card.classList.add('scale-95');
        
        setTimeout(() => {
            wrapper.style.display = 'none';
            document.body.style.overflow = '';
        }, 300);
    }

    function updateStatus(id, newStatus) {
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
                    window.candidatureApp.showToast(newStatus === 'Accepté' ? 'Candidature acceptée avec succès !' : 'Candidature refusée.');
                    window.candidatureApp.fetchCandidatures();
                }
            })
            .catch(err => {
                console.error(err);
                window.candidatureApp.showToast('Une erreur est survenue.', 'error');
            });
        });
    }
</script>
@endpush
@endsection
