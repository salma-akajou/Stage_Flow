@extends('layouts.entreprise')

@section('content')
<div class="space-y-8 max-w-[1400px]">
    
    @include('components.entreprise.dashboard.alerts')

    @include('components.entreprise.dashboard.header', ['entreprise' => $entreprise])

    @include('components.entreprise.dashboard.stats', ['stats' => $stats])

    <div class="grid lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            @include('components.entreprise.dashboard.candidatures', ['candidatures_recentes' => $candidatures_recentes])
            @include('components.entreprise.dashboard.activites', ['activites' => $activites])
        </div>

        <div class="space-y-6">
            @include('components.entreprise.dashboard.offres', ['offres_actives' => $offres_actives])
            @include('components.entreprise.dashboard.feedback')
        </div>
    </div>
</div>

@push('modals')
    @include('components.entreprise.offres.modal-form')
    @include('components.entreprise.candidatures.detail-candidature-modal')
@endpush

@push('scripts')
<script>
    async function openOfferModal() {
        const wrapper = document.getElementById('offer-modal-wrapper');
        const card = document.getElementById('offer-modal-card');
        if (wrapper && wrapper.parentElement !== document.body) document.body.appendChild(wrapper);
        wrapper.style.display = 'block';
        document.body.style.overflow = 'hidden';
        setTimeout(() => {
            wrapper.classList.replace('opacity-0', 'opacity-100');
            card.classList.replace('scale-95', 'scale-100');
        }, 10);
    }

    function closeOfferModal() {
        const wrapper = document.getElementById('offer-modal-wrapper');
        const card = document.getElementById('offer-modal-card');
        wrapper.classList.replace('opacity-100', 'opacity-0');
        card.classList.replace('scale-100', 'scale-95');
        setTimeout(() => { wrapper.style.display = 'none'; document.body.style.overflow = ''; }, 300);
    }

    async function openDetailModal(id) {
        const wrapper = document.getElementById('candidature-detail-modal-wrapper');
        const card = document.getElementById('candidature-detail-card');
        if (wrapper.parentElement !== document.body) document.body.appendChild(wrapper);
        wrapper.style.display = 'block';
        document.body.style.overflow = 'hidden';
        setTimeout(() => {
            wrapper.classList.replace('opacity-0', 'opacity-100');
            card.classList.replace('scale-95', 'scale-100');
        }, 10);

        document.getElementById('det-nom').innerText = 'Chargement...';
        try {
            const response = await fetch(`/entreprise/candidatures/details/${id}`);
            const result = await response.json();
            if (result.success) {
                const data = result.data;
                document.getElementById('det-nom').innerText = data.nom_complet;
                document.getElementById('det-photo').src = data.photo;
                document.getElementById('det-bio').innerText = data.bio;
                document.getElementById('det-tel').innerText = data.telephone || '-- -- --';
                document.getElementById('det-motivation').innerText = data.motivation;
                document.getElementById('det-status-badge').innerText = data.statut;
                const cvLink = document.getElementById('det-cv-link');
                if (data.cv_url) { cvLink.href = data.cv_url; cvLink.style.display = 'inline-flex'; } else { cvLink.style.display = 'none'; }
                const portLink = document.getElementById('det-portfolio-link');
                if (data.portfolio) { portLink.href = data.portfolio; portLink.parentElement.parentElement.style.display = 'flex'; }
                else { portLink.parentElement.parentElement.style.display = 'none'; }
            }
        } catch (error) { console.error(error); }
    }

    function closeDetailModal() {
        const wrapper = document.getElementById('candidature-detail-modal-wrapper');
        const card = document.getElementById('candidature-detail-card');
        wrapper.classList.replace('opacity-100', 'opacity-0');
        card.classList.replace('scale-100', 'scale-95');
        setTimeout(() => { wrapper.style.display = 'none'; document.body.style.overflow = ''; }, 300);
    }

    // Student profile modal is now global in layouts.entreprise.blade.php
</script>
@endpush
@endsection
