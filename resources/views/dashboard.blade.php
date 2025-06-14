<x-layouts.app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <!-- Donut Chart Motor vs Mobil -->
            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <div id="chartMotorMobil" class="absolute inset-0"></div>
            </div>

            <!-- Informasi Lokasi & Waktu Rawan -->
            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <div class="p-4 text-sm">
                    <h4 class="font-semibold mb-2">Lokasi Rawan Pelanggaran:</h4>
                    <ul class="list-disc list-inside space-y-1">
                        <li>Pasar Senen (12 kasus)</li>
                        <li>Tanah Abang (8 kasus)</li>
                        <li>Grogol (5 kasus)</li>
                    </ul>
                    <h4 class="font-semibold mt-4 mb-2">Waktu Puncak Pelanggaran:</h4>
                    <p>09:00 - 11:00 & 18:00 - 20:00 WIB</p>
                </div>
            </div>

            <!-- Jumlah Pelanggaran Hari Ini -->
            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <div class="flex h-full w-full flex-col items-center justify-center">
                    <span class="text-4xl font-bold">20</span>
                    <span class="text-sm text-gray-600">Pelanggaran Hari Ini</span>
                </div>
            </div>
        </div>

        <!-- Chart Perbandingan Motor vs Mobil -->
        <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
            <div id="chartComparison" class="absolute inset-0"></div>
        </div>
    </div>
        <!-- ApexCharts JS -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

        <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Donut Chart
    var optionsDonut = {
        chart: { type: 'donut' },
        series: [{{ $motorCount ?? 0 }}, {{ $mobilCount ?? 0 }}],
        labels: ['Motor', 'Mobil']
    };
    var chartDonut = new ApexCharts(document.querySelector("#chartMotorMobil"), optionsDonut);
    chartDonut.render();

            // Bar Chart
            var optionsBar = {
                chart: { type: 'bar' },
                series: [{
                    name: 'Pelanggaran',
                    data: [120, 80]
                }],
                xaxis: {
                    categories: ['Motor', 'Mobil']
                }
            };
            var chartBar = new ApexCharts(document.querySelector("#chartComparison"), optionsBar);
            chartBar.render();
        });
    </script>

</x-layouts.app>
