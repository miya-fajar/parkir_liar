import ApexCharts from 'apexcharts';

// Gunakan export agar bisa dipanggil di mana pun
export function renderDonutChart(dataJenis, labelsJenisRaw) {
    const chartContainer = document.getElementById("chartMotorMobil");
    if (!chartContainer || typeof ApexCharts === 'undefined') return;

    // Hancurkan chart lama (kalau ada)
    if (window.donutChart) {
        window.donutChart.destroy();
    }

    const labelColor = window.matchMedia('(prefers-color-scheme: dark)').matches ? '#fff' : '#222';
    const labelsJenis = labelsJenisRaw.map(label => {
        if (label.toLowerCase() === 'motor') return 'Motorcycle';
        if (label.toLowerCase() === 'mobil') return 'Car';
        return label;
    });

    window.donutChart = new ApexCharts(chartContainer, {
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
    });

    window.donutChart.render();
}
