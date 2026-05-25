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

@endsection
