
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4" data-aos="fade-down">
    <div>
        <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900">Bienvenue, <span class="text-indigo-600">{{ $entreprise->nom_entreprise }}</span> 👋</h1>
        <p class="text-sm text-gray-500 mt-1">Voici un aperçu de votre activité sur StageFlow</p>
    </div>
    <button onclick="openOfferModal()" class="w-full sm:w-auto shrink-0 inline-flex items-center justify-center gap-x-2 py-3 px-5 text-sm font-bold rounded-xl bg-indigo-600 text-white hover:bg-indigo-700 shadow-lg shadow-indigo-200 transition transform hover:scale-[1.02]">
        <svg class="size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
            <path d="M12 5v14M5 12h14" />
        </svg>
        Publier une offre
    </button>
</div>
