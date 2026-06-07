export default (series = [], categories = []) => ({
    series,
    categories,
    init() {
        const options = {
            series: [{
                name: 'Activité (Inscriptions, Offres, Candidatures)',
                data: this.series
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
                categories: this.categories,
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

        const chartContainer = this.$el.querySelector('#hs-single-area-chart') || this.$el;
        if (chartContainer) {
            const chart = new ApexCharts(chartContainer, options);
            chart.render();
        }
    }
});

