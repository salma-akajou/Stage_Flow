<div class="lg:col-span-2 bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
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

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var options = {
            series: [{
                name: 'Activité (Inscriptions, Offres, Candidatures)',
                data: @json($chartData['series'])
            }],
            chart: {
                type: 'area',
                height: 240,
                toolbar: { show: false },
                zoom: { enabled: false }
            },
            colors: ['#6366f1'],
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.4,
                    opacityTo: 0.05,
                    stops: [0, 100]
                }
            },
            stroke: {
                curve: 'smooth',
                width: 3
            },
            dataLabels: { enabled: false },
            grid: {
                borderColor: '#f3f4f6',
                strokeDashArray: 4,
                padding: { top: 0, right: 0, bottom: 0, left: 10 }
            },
            xaxis: {
                categories: @json($chartData['categories']),
                axisBorder: { show: false },
                axisTicks: { show: false },
                labels: {
                    style: { colors: '#9ca3af', fontSize: '12px' }
                }
            },
            yaxis: {
                labels: {
                    style: { colors: '#9ca3af', fontSize: '12px' },
                    formatter: function (value) { return Math.round(value); }
                }
            },
            tooltip: {
                theme: 'light',
                y: {
                    formatter: function(value) {
                        return value + ' actions';
                    }
                }
            }
        };

        var chart = new ApexCharts(document.querySelector("#hs-single-area-chart"), options);
        chart.render();
    });
</script>
@endpush
