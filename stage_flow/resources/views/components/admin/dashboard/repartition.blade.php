@php
    $total = $repartition['etudiants'] + $repartition['entreprises'];
    // Avoid division by zero
    $totalUsers = $total > 0 ? $total : 1; 
    
    // We add a hypothetical 10% for Admins just like the mockup, or calculate real admins if we had Spatie setup.
    // For now, let's just use etudiants and entreprises, and mock 1 admin.
    $total = $total + 1; // 1 admin
    $totalUsers = $total;

    $pctEtudiants = round(($repartition['etudiants'] / $totalUsers) * 100);
    $pctEntreprises = round(($repartition['entreprises'] / $totalUsers) * 100);
    $pctAdmins = round((1 / $totalUsers) * 100);
@endphp

<div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
    <h3 class="text-lg font-bold text-gray-900 mb-4">Répartition</h3>
    <div class="space-y-4">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-2">
                <div class="size-3 rounded-full bg-indigo-500"></div>
                <span class="text-sm text-gray-600">Étudiants</span>
            </div>
            <span class="text-sm font-semibold text-gray-900">{{ $pctEtudiants }}%</span>
        </div>
        <div class="w-full bg-gray-100 rounded-full h-2">
            <div class="bg-indigo-500 h-2 rounded-full" style="width: {{ $pctEtudiants }}%"></div>
        </div>

        <div class="flex items-center justify-between">
            <div class="flex items-center gap-2">
                <div class="size-3 rounded-full bg-indigo-300"></div>
                <span class="text-sm text-gray-600">Entreprises</span>
            </div>
            <span class="text-sm font-semibold text-gray-900">{{ $pctEntreprises }}%</span>
        </div>
        <div class="w-full bg-gray-100 rounded-full h-2">
            <div class="bg-indigo-300 h-2 rounded-full" style="width: {{ $pctEntreprises }}%"></div>
        </div>

        <div class="flex items-center justify-between">
            <div class="flex items-center gap-2">
                <div class="size-3 rounded-full bg-gray-400"></div>
                <span class="text-sm text-gray-600">Admins</span>
            </div>
            <span class="text-sm font-semibold text-gray-900">{{ $pctAdmins }}%</span>
        </div>
        <div class="w-full bg-gray-100 rounded-full h-2">
            <div class="bg-gray-400 h-2 rounded-full" style="width: {{ $pctAdmins }}%"></div>
        </div>
    </div>
</div>

