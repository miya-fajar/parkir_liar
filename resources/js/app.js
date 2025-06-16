/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allow your team to quickly build robust real-time web applications.
 */

import "./echo";
import { renderDonutChart } from './donut-chart.js'; // jika dipecah file


            document.addEventListener('livewire:navigated', renderChart);
            document.addEventListener('wire:navigated', renderChart);

            
window.addEventListener('livewire:load', function() {
    window.livewire.hook('message.processed', () => {
        if (window.dataJenis && window.labelsJenisRaw) {
            renderDonutChart(window.dataJenis, window.labelsJenisRaw);
        }
    });
});
