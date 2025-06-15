<x-layouts.app :title="__('History Violation Motorcycle')">
    <div class="flex h-full w-full flex-1 flex-col rounded-xl">
        <div class="relative flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 p-6">
            <h3 class="text-lg font-semibold mb-2 text-neutral-700 dark:text-neutral-200">Motorcycle Violations</h3>
            <div class="grid auto-rows-min gap-4 md:grid-cols-2">
                @foreach ($motorViolations as $violation)
                    <div
                        class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 shadow-lg group">
                        <!-- Violation Image -->
                        <img src="{{ asset('storage/' . $violation->image) }}" alt="Motorcycle Violation"
                            class="absolute inset-0 w-full h-full object-cover transition-transform duration-300 ease-out group-hover:scale-105" />
                        <!-- Info overlay -->
                        <div class="absolute bottom-0 w-full bg-black bg-opacity-50 text-white p-2 text-sm">
                            <p class="font-semibold">
                                @php
                                    $label = $violation->jenis_kendaraan;
                                    if (strtolower($label) === 'motor') {
                                        $label = 'Motorcycle';
                                    }
                                    if (strtolower($label) === 'mobil') {
                                        $label = 'Car';
                                    }
                                @endphp
                                {{ $label }}
                            </p>
                            <p>{{ \Carbon\Carbon::parse($violation->waktu_pelanggaran)->format('M d, Y H:i') }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
            {{ $motorViolations->links() }} <!-- Pagination controls for Motorcycle section -->
        </div>
    </div>
</x-layouts.app>
