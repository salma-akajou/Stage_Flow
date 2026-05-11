<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8" data-aos="fade-down">
    <div>
        <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900">Profil <span class="text-indigo-600">Entreprise</span></h1>
        <p class="text-sm text-gray-500 mt-1 font-medium">Gérez les informations publiques de votre entreprise</p>
    </div>
    <div class="flex items-center gap-2 text-xs font-bold bg-white border border-gray-200 px-4 py-2 rounded-xl shadow-sm">
        <span class="size-2 bg-emerald-500 rounded-full"></span>
        Profil vérifié
    </div>
</div>

@if(session('success'))
    <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl p-4 shadow-sm" role="alert" data-aos="fade-in">
        <div class="flex items-center gap-x-3">
            <svg class="size-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
            <p class="text-sm font-bold">{{ session('success') }}</p>
        </div>
    </div>
@endif
