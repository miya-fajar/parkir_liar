<x-layouts.app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <!-- Donut Chart Motor vs Mobil -->
            <div
                class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <div class="p-4 text-sm">
                    <h4 class="font-semibold mb-2">Parking Violation Detection Test:</h4>
                    <ul class="list-disc list-inside space-y-1">
                        <li>Car (12 cases)</li>
                        <li>Motorcycle (8 cases)</li>
                    </ul>
                    <h4 class="font-semibold mt-4 mb-2">Location of Parking Violation Detection Test:</h4>
                    <p>Jl. Siliwangi, Pelabuhan Ratu, Sukabumi</p>
                    <h4 class="font-semibold mt-4 mb-2">Violation Detection Test Hours:</h4>
                    <p>09:00 AM - 08:00 PM (WIB)</p>
                </div>
            </div>

            <div
                class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
            </div>


            <div
                class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
            </div>
        </div>

        <!-- Chart Perbandingan Motor vs Mobil -->
        <div class="flex w-full flex-col gap-4">
            <!-- Grid 2 kolom untuk 2 chart utama -->
            <div class="grid gap-4 md:grid-cols-2">
                <!-- Card Donut Chart Jenis Kendaraan -->
                <div
                    class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                    <div id="chartMotorMobil" class="absolute inset-0"></div>
                </div>
                <!-- Card Grafik Pelanggaran 30 Hari Terakhir -->
                <div
                    class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                    <div id="chartDaily" class="absolute inset-0"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- ApexCharts JS -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Konfigurasi Donut Chart (Jenis Kendaraan)
            var optionsDonut = {
                chart: {
                    type: 'donut'
                },
                labels: @json($labelsJenis), // label jenis kendaraan (contoh: ["Motor","Mobil"])
                series: @json($dataJenis) // data jumlah per jenis (contoh: [120, 80])
            };
            var chartDonut = new ApexCharts(document.querySelector("#chartMotorMobil"), optionsDonut);
            chartDonut.render();

            // Konfigurasi Line/Bar Chart (Pelanggaran 30 Hari Terakhir)
            var optionsLine = {
                chart: {
                    type: 'line'
                }, // bisa diganti 'bar' jika ingin grafik batang
                series: [{
                    name: 'Pelanggaran',
                    data: @json($dataDates) // data jumlah pelanggaran per hari (array angka)
                }],
                xaxis: {
                    categories: @json($labelsDates) // kategori sumbu-X: tanggal (array string "YYYY-MM-DD")
                }
            };
            var chartLine = new ApexCharts(document.querySelector("#chartDaily"), optionsLine);
            chartLine.render();
        });
    </script>
</x-layouts.app>
