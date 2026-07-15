<x-filament::section wire:poll.15s>
    <x-slot name="heading">
        Notifikasi singkat
    </x-slot>

    <x-slot name="description">
        Jadwal keluar hari ini dan kurang dari 7 hari ke depan (diperbarui otomatis setiap 15 detik).
    </x-slot>

    @php
        $ringkasan = $this->ringkasan;
    @endphp

    <div class="rounded-xl border border-white/10 bg-white/5 p-4 text-sm text-gray-200">
        <div class="space-y-2">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span class="inline-flex items-center rounded-md bg-red-500/15 px-2 py-1 text-xs font-semibold text-red-300 ring-1 ring-inset ring-red-500/20">
                        Keluar hari ini
                    </span>
                    <span class="text-sm text-gray-300">: {{ $ringkasan['keluar_hari_ini'] ?? 0 }} orang</span>
                </div>
            </div>

            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span class="inline-flex items-center rounded-md bg-amber-500/15 px-2 py-1 text-xs font-semibold text-amber-300 ring-1 ring-inset ring-amber-500/20">
                        Keluar kurang dari 7 hari
                    </span>
                    <span class="text-sm text-gray-300">: {{ $ringkasan['keluar_kurang_7_hari'] ?? 0 }} orang</span>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-4">
        <a href="{{ url('/admin/notifikasis') }}" class="inline-flex items-center gap-2 rounded-lg bg-primary-600 px-3 py-2 text-sm font-semibold text-white hover:bg-primary-500">
            Lihat semua notifikasi
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                <path d="M5 12h14" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                <path d="m13 6 6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </a>
    </div>
</x-filament::section>
