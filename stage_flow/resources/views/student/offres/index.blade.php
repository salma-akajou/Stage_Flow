@extends('layouts.student')

@section('title', 'Catalogue des Offres - StageFlow')
@section('breadcrumb', 'Catalogue des Offres')

@section('content')
<div class="space-y-10" x-data="{ 
    search: '{{ addslashes(request('titre')) }}',
    ville: '{{ request('ville_id') }}',
    secteur: '{{ addslashes(request('secteur')) }}'
}">
    @include('components.student.offres.filters')

    @include('components.student.offres.grid')
</div>
@endsection
