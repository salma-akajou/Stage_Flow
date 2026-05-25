@extends('layouts.student')

@section('title', 'Catalogue des Offres - StageFlow')
@section('breadcrumb', 'Catalogue des Offres')

@section('content')
<div class="space-y-10" x-data="offresCatalog('{{ addslashes(request('titre')) }}', '{{ request('ville_id') }}', '{{ addslashes(request('secteur')) }}')">

    <div class="text-center max-w-2xl mx-auto" data-aos="fade-down">
                <h2 class="text-2xl sm:text-3xl font-bold text-gray-800">Offres de stages</h2>
                <p class="mt-3 text-sm sm:text-base text-gray-600">Découvrez notre sélection de stages adaptés à votre
                   profil. Que vous cherchiez un stage technique, un PFE ou une expérience d'observation, filtrez et
                    trouvez l'opportunité idéale pour lancer votre carrière.</p>
            </div>
    @include('components.student.offres.filters')

    @include('components.student.offres.grid')
</div>
@endsection
