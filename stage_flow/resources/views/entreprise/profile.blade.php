@extends('layouts.entreprise')

@section('title', 'Profil Entreprise - StageFlow')
@section('breadcrumb', 'Profil Entreprise')

@section('content')
    <div class="max-w-4xl mx-auto">
        
        @include('components.entreprise.profile.header')

        <form action="{{ route('entreprise.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8" data-aos="fade-up">
            @csrf
            @method('PUT')

            @include('components.entreprise.profile.form-basic')

            @include('components.entreprise.profile.form-legal')

            @include('components.entreprise.profile.actions')
        </form>
    </div>
@endsection

@push('scripts')
<script>
    function previewImage(event) {
        const input = event.target;
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('logo-preview').src = e.target.result;
                document.getElementById('logo-preview').classList.remove('hidden');
                if (document.getElementById('logo-placeholder')) {
                    document.getElementById('logo-placeholder').classList.add('hidden');
                }
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush
