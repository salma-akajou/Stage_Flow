<div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-6 sm:p-8" data-aos="fade-up">
    <h3 class="text-lg font-black text-gray-800 mb-8 flex items-center gap-2 font-heading">
        <svg class="size-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
        Informations personnelles
    </h3>

    @include('components.student.profile.photo-upload')

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
        <div class="space-y-2">
            <label class="block text-sm font-bold text-gray-700">Prénom</label>
            <input type="text" name="prenom" value="{{ $etudiant->user->prenom }}"
                class="py-2.5 px-4 block w-full border-gray-200 rounded-xl text-sm focus:border-indigo-500 focus:ring-indigo-500 transition shadow-sm">
        </div>
        <div class="space-y-2">
            <label class="block text-sm font-bold text-gray-700">Nom</label>
            <input type="text" name="nom" value="{{ $etudiant->user->nom }}"
                class="py-2.5 px-4 block w-full border-gray-200 rounded-xl text-sm focus:border-indigo-500 focus:ring-indigo-500 transition shadow-sm">
        </div>
        <div class="space-y-2">
            <label class="block text-sm font-bold text-gray-700">Email (Non modifiable)</label>
            <input type="email" value="{{ $etudiant->user->email }}" readonly
                class="py-2.5 px-4 block w-full border-gray-200 rounded-xl text-sm bg-gray-50 text-gray-400 cursor-not-allowed">
        </div>
        <div class="space-y-2">
            <label class="block text-sm font-bold text-gray-700">Ville</label>
            <select name="ville_id" class="py-2.5 px-4 pe-9 block w-full border-gray-200 rounded-xl text-sm focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                @foreach($villes as $ville)
                    <option value="{{ $ville->id }}" {{ $etudiant->ville_id == $ville->id ? 'selected' : '' }}>{{ $ville->nom }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>
