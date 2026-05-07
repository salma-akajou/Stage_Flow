@extends('layouts.entreprise')

@section('title', 'Mes Offres - StageFlow')

@section('content')
<div class="p-4 sm:p-6 lg:p-8 max-w-[1400px] mx-auto space-y-6 relative min-h-screen" x-data="offreManager()">
    <div class="fixed inset-0 pointer-events-none overflow-hidden z-[-1] opacity-[0.04]">
        <div class="absolute top-20 left-10 animate-bounce duration-[10s]">
            <svg class="size-44 text-indigo-600" fill="currentColor" viewBox="0 0 24 24"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z" /><polyline points="14 2 14 8 20 8" /></svg>
        </div>
        <div class="absolute top-[40%] right-10 animate-pulse duration-[15s]">
            <svg class="size-32 text-blue-500" fill="currentColor" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8" /><path d="m21 21-4.3-4.3" /></svg>
        </div>
        <div class="absolute bottom-20 left-[20%] animate-bounce duration-[12s]">
            <svg class="size-24 text-indigo-400" fill="currentColor" viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" /></svg>
        </div>
    </div>

    <div class="fixed top-0 right-0 w-[500px] h-[500px] bg-indigo-300/10 rounded-full blur-[120px] pointer-events-none z-[-2]"></div>
    <div class="fixed bottom-0 left-64 w-[500px] h-[500px] bg-blue-200/10 rounded-full blur-[120px] pointer-events-none z-[-2]"></div>

    @if(session('success'))
        <div class="p-5 bg-emerald-50 border border-emerald-100 rounded-[1.5rem] flex items-center gap-4 animate-in fade-in slide-in-from-top-4 duration-500 shadow-xl shadow-emerald-500/5">
            <div class="size-12 bg-emerald-500 text-white rounded-2xl flex items-center justify-center shrink-0 shadow-lg shadow-emerald-200 text-sm">
                <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
            </div>
            <div>
                <p class="text-sm font-black text-emerald-900">Opération réussie</p>
                <p class="text-xs font-bold text-emerald-600/80">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    @include('components.entreprise.offres.header')

    @include('components.entreprise.offres.filters')

    <div id="table-container" class="relative group">
        <div id="table-content">
            @include('components.entreprise.offres.table')
        </div>
    </div>
</div>

@push('modals')
    @include('components.entreprise.offres.modal-form')
@endpush

@push('scripts')
<script>
    function offreManager() {
        return {
            init() {
                document.addEventListener('click', (e) => {
                    const link = e.target.closest('#table-container nav a');
                    if (link) {
                        e.preventDefault();
                        fetchOffers(link.href);
                    }
                });
            }
        }
    }

    function fetchOffers(url = null) {
        const container = document.getElementById('table-content');
        const form = document.getElementById('search-form');
        
        const fetchUrl = url || `${form.action}?${new URLSearchParams(new FormData(form)).toString()}`;

        fetch(fetchUrl, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(res => res.text())
        .then(html => {
            container.innerHTML = html;
            if (typeof AOS !== 'undefined') AOS.refresh();
        });
    }

    function openOfferModal(isNew = true) {
        if (isNew) {
            window.dispatchEvent(new CustomEvent('reset-modal'));
        }
        const wrapper = document.getElementById('offer-modal-wrapper');
        const card = document.getElementById('offer-modal-card');
        wrapper.style.display = 'block';
        setTimeout(() => {
            wrapper.classList.replace('opacity-0', 'opacity-100');
            card.classList.replace('scale-95', 'scale-100');
        }, 10);
        document.body.style.overflow = 'hidden';
    }

    function openEditModal(id) {
        window.dispatchEvent(new CustomEvent('open-modal', { detail: id }));
    }

    function closeOfferModal() {
        const wrapper = document.getElementById('offer-modal-wrapper');
        const card = document.getElementById('offer-modal-card');
        wrapper.classList.replace('opacity-100', 'opacity-0');
        card.classList.replace('scale-100', 'scale-95');
        setTimeout(() => {
            wrapper.style.display = 'none';
            document.body.style.overflow = '';
        }, 300);
    }

    @if($errors->any())
        document.addEventListener('DOMContentLoaded', () => {
            openOfferModal(false);
        });
    @endif
</script>
@endpush
@endsection
