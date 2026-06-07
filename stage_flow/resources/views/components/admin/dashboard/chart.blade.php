<div class="lg:col-span-2 bg-white border border-gray-200 rounded-2xl p-6 shadow-sm"
     x-data="adminChart(@js($chartData['series']), @js($chartData['categories']))">
    <div class="flex flex-wrap justify-between items-center gap-2 mb-4">
        <div>
            <h2 class="text-sm text-gray-500">
                Activité des 7 derniers jours
            </h2>
            <p class="text-xl sm:text-2xl font-bold text-gray-900">
                {{ number_format($chartData['total']) }} actions
            </p>
        </div>
    </div>
    
    <div id="hs-single-area-chart" class="min-h-[240px]"></div>
</div>

