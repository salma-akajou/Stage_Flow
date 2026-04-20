<div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-6 sm:p-8" data-aos="fade-up" data-aos-delay="100">
    <h3 class="text-lg font-black text-gray-800 mb-8 flex items-center gap-2 font-heading">
        <svg class="size-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/></svg>
        Parcours Académique
    </h3>
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
        <div class="space-y-2">
            <label class="block text-sm font-bold text-gray-700">École / Université</label>
            <select name="etablissement" class="py-2.5 px-4 pe-9 block w-full border-gray-200 rounded-xl text-sm focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                @foreach(['Solicode', 'Faculté', 'ISTA', 'EMSI', 'ENSI', 'BTS', 'Autre'] as $inst)
                    <option value="{{ $inst }}" {{ $etudiant->etablissement == $inst ? 'selected' : '' }}>{{ $inst }}</option>
                @endforeach
            </select>
        </div>
        <div class="space-y-2">
            <label class="block text-sm font-bold text-gray-700">Niveau d'études</label>
            <select name="niveau_etudes" class="py-2.5 px-4 pe-9 block w-full border-gray-200 rounded-xl text-sm focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                @foreach(['Bac+2', 'Bac+3', 'Master', 'Doctorat', 'Autre'] as $niv)
                    <option value="{{ $niv }}" {{ $etudiant->niveau_etudes == $niv ? 'selected' : '' }}>{{ $niv }}</option>
                @endforeach
            </select>
        </div>
        <div class="space-y-2 sm:col-span-2">
            <label class="block text-sm font-bold text-gray-700">Filière</label>
            <input type="text" name="filiere" value="{{ $etudiant->filiere }}"
                class="py-2.5 px-4 block w-full border-gray-200 rounded-xl text-sm focus:border-indigo-500 focus:ring-indigo-500 transition shadow-sm"
                placeholder="Ex: Développement Fullstack">
        </div>
    </div>
</div>
