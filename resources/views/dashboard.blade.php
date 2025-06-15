<x-layouts.app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <!-- Card Parking Violation Detection Test -->
            <div
                class="relative aspect-video overflow-hidden rounded-2xl border border-neutral-200 dark:border-neutral-700 shadow-lg bg-white dark:bg-neutral-900">
                <div class="p-6 flex flex-col justify-center h-full">
                    <h2 class="text-xl font-extrabold mb-4 text-neutral-800 dark:text-white tracking-tight">
                        Parking Violation Detection Test
                    </h2>
                    <ul class="list-disc pl-6 space-y-1 mb-6">
                        @foreach ($labelsJenis as $i => $jenis)
                        @php
                        $displayJenis = $jenis;
                        if (strtolower($jenis) === 'motor') {
                        $displayJenis = 'Motorcycle';
                        }
                        if (strtolower($jenis) === 'mobil') {
                        $displayJenis = 'Car';
                        }
                        @endphp
                        <li class="text-base text-neutral-600 dark:text-neutral-300 font-medium">
                            {{ $displayJenis }}
                            <span class="font-bold text-neutral-800 dark:text-white">
                                ({{ $dataJenis[$i] }} cases)
                            </span>
                        </li>
                        @endforeach
                    </ul>
                    <h3 class="text-base font-semibold mb-2 text-neutral-700 dark:text-neutral-200">Test
                        Location</h3>
                    <p class="text-neutral-600 dark:text-neutral-300 mb-4">Jl. Siliwangi, Pelabuhan
                        Ratu, Sukabumi</p>
                </div>
            </div>

            <!-- Latest Motorcycle Violation Card -->
            <div
                class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 group">
                <img src="{{ ('/storage/' . $latestMotor->image) }}" alt="Latest Motorcycle Violation"
                    class="absolute inset-0 w-full h-full object-cover transition-transform duration-300 ease-out group-hover:scale-105">
                <div class="absolute bottom-0 w-full bg-black bg-opacity-50 text-white p-2 text-sm">
                    <p class="font-semibold">
                        @php
                        $label = $latestMotor->jenis_kendaraan;
                        if (strtolower($label) === 'motor') {
                        $label = 'Motorcycle';
                        }
                        @endphp
                        {{ $label }}
                    </p>
                    <p>{{ \Carbon\Carbon::parse($latestMotor->waktu_pelanggaran)->format('M d, Y H:i') }}</p>
                </div>
            </div>

            <!-- Latest Car Violation Card -->
            <div
                class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 group">
                <img src="{{ ('/storage/' . $latestMobil->image) }}" alt="Latest Car Violation"
                    class="absolute inset-0 w-full h-full object-cover transition-transform duration-300 ease-out group-hover:scale-105">
                <div class="absolute bottom-0 w-full bg-black bg-opacity-50 text-white p-2 text-sm">
                    <p class="font-semibold">
                        @php
                        $label = $latestMobil->jenis_kendaraan;
                        if (strtolower($label) === 'mobil') {
                        $label = 'Car';
                        }
                        @endphp
                        {{ $label }}
                    </p>
                    <p>{{ \Carbon\Carbon::parse($latestMobil->waktu_pelanggaran)->format('M d, Y H:i') }}</p>
                </div>
            </div>
        </div>

        <!-- Chart Perbandingan Motor vs Mobil & Violation Activity -->
        <div class="flex w-full flex-col gap-4">
            <div class="grid gap-4 md:grid-cols-3">
                <!-- Donut Chart Jenis Kendaraan -->
                <div
                    class="relative aspect-video rounded-2xl border border-neutral-200 dark:border-neutral-700 shadow bg-white dark:bg-neutral-900 md:col-span-1 flex items-center">
                    <div class="w-full rounded-xl shadow-sm p-4">
                        <div class="flex justify-between">
                            <div class="flex justify-center items-center">
                                <h5 class="text-xl font-bold leading-none text-gray-900 dark:text-white pe-1">
                                    Parking Violations
                                </h5>
                            </div>
                        </div>
                        <div id="chartMotorMobil" class="mt-4"></div>
                        <div class="mt-6">
                            <ul id="jenisList" class="space-y-2">
                                <!-- Detail by JS -->
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- Daily Violation Bar Chart -->
                <div
                    class="relative aspect-video rounded-2xl border border-neutral-200 dark:border-neutral-700 shadow bg-white dark:bg-neutral-900 md:col-span-2 flex flex-col justify-between">
                    <div class="mb-4 flex items-center justify-between px-6 pt-6">
                        <div>
                            <h3 class="text-lg md:text-xl font-semibold text-gray-900 dark:text-white">
                                {{ __('Violation Activity') }}
                            </h3>
                            <p class="text-sm md:text-base text-gray-500 dark:text-gray-400">
                                {{ __('Violations detected over time') }}
                            </p>
                        </div>
                    </div>
                    <div id="activity-chart" class="h-80 w-full px-4 pb-6"></div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    @vite('resources/js/app.js')
    <script>
        const jenisList = document.getElementById('jenisList');
        let dataJenis = @json($dataJenis ?? []);
        const labelsJenisRaw = @json($labelsJenis ?? []);
        let donutChart = null;

        const getLabelColor = () =>
            window.matchMedia('(prefers-color-scheme: dark)').matches ? '#fff' : '#222';

        const getDonutChartOptions = () => {
            const labelColor = getLabelColor();
            const labelsJenis = labelsJenisRaw.map(label => {
                if (label.toLowerCase() === 'motor') return 'Motorcycle';
                if (label.toLowerCase() === 'mobil') return 'Car';
                return label;
            });

            return {
                series: dataJenis,
                labels: labelsJenis,
                colors: ["#6366f1", "#f59e42", "#10b981", "#f43f5e", "#64748b"],
                chart: {
                    height: 320,
                    width: "100%",
                    type: "donut",
                },
                stroke: {
                    colors: ["transparent"]
                },
                plotOptions: {
                    pie: {
                        donut: {
                            size: "80%",
                            labels: {
                                show: true,
                                name: {
                                    show: true,
                                    fontFamily: "Inter, sans-serif",
                                    offsetY: 20,
                                    color: labelColor
                                },
                                total: {
                                    showAlways: true,
                                    show: true,
                                    fontFamily: "Inter, sans-serif",
                                    label: "Total",
                                    color: labelColor,
                                    formatter: function(w) {
                                        const sum = w.globals.seriesTotals.reduce((a, b) => a + b, 0)
                                        return sum + " Violations"
                                    },
                                },
                                value: {
                                    show: true,
                                    fontFamily: "Inter, sans-serif",
                                    offsetY: -20,
                                    color: labelColor,
                                    formatter: function(value) {
                                        return value + " Violations"
                                    },
                                },
                            },
                        },
                    },
                },
                legend: {
                    position: "bottom",
                    fontFamily: "Inter, sans-serif",
                    labels: {
                        colors: labelColor
                    },
                },
                dataLabels: {
                    enabled: false
                },
            };
        };

        const renderChart = () => {
            const chartContainer = document.getElementById("chartMotorMobil");
            if (chartContainer && typeof ApexCharts !== 'undefined') {
                donutChart = new ApexCharts(chartContainer, getDonutChartOptions());
                donutChart.render();
            }
        };

        document.addEventListener('DOMContentLoaded', () => {
            renderChart();

            // Real-time update via Echo
            if (typeof window.Echo !== 'undefined') {
                window.Echo.channel("dashboard").listen(".data.created", (e) => {
                    if (e.jenis_kendaraan === 'motor') {
                        dataJenis[0]++;
                    } else if (e.jenis_kendaraan === 'mobil') {
                        dataJenis[1]++;
                    }

                    if (donutChart) {
                        donutChart.updateSeries([...dataJenis]); // important: update series dynamically
                    }
                });
            } else {
                console.warn("Echo is not defined");
            }
        });
    </script>
</x-layouts.app>