<div class="mb-10 flex items-center gap-6" x-data="photoUpload('{{ $etudiant->photo ? asset('storage/'.$etudiant->photo) : '' }}')">
    <div class="relative group">
        <div class="size-24 rounded-full bg-indigo-50 border-4 border-white shadow-md flex items-center justify-center overflow-hidden transition-transform group-hover:scale-105">
            <template x-if="photoUrl">
                <img :src="photoUrl" class="size-full object-cover">
            </template>
            <template x-if="!photoUrl">
                <span class="text-indigo-600 font-black text-2xl uppercase font-heading">{{ substr($etudiant->user->prenom, 0, 1) }}{{ substr($etudiant->user->nom, 0, 1) }}</span>
            </template>
        </div>
        <label for="profile-photo" class="absolute bottom-0 right-0 size-8 bg-indigo-600 text-white rounded-full flex items-center justify-center shadow-lg cursor-pointer transform hover:scale-110 active:scale-95 transition-all">
            <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            <input id="profile-photo" name="photo" type="file" accept="image/*" class="sr-only" 
                @change="updatePhoto($event)">
        </label>
    </div>
    <div>
        <span class="block text-sm font-black text-gray-800">Photo de profil</span>
        <span class="block text-xs text-gray-400 mt-1">JPG, PNG (Max. 2MB)</span>
    </div>
</div>
