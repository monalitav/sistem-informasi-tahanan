<x-filament::section>
    <x-slot name="heading">
        Alur Sistem
    </x-slot>

    <x-slot name="description">
        Input data → tersimpan di database → dicek otomatis (sequential search) → notifikasi muncul → rekap bisa di-export.
    </x-slot>

    <div class="grid gap-4 lg:grid-cols-5">
        <div class="rounded-xl border border-white/10 bg-white/5 p-4">
            <div class="text-sm text-gray-400">1. Input</div>
            <div class="mt-1 text-base font-semibold text-gray-100">Tambah / Edit Data Tahanan</div>
            <div class="mt-2 text-sm text-gray-400">Menu: Data Tahanan, Tambah Data</div>
        </div>

        <div class="hidden items-center justify-center lg:flex">
            <svg class="h-6 w-6 text-gray-400" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                <path d="M5 12h14" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                <path d="m13 6 6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </div>

        <div class="rounded-xl border border-white/10 bg-white/5 p-4 lg:col-start-2">
            <div class="text-sm text-gray-400">2. Database</div>
            <div class="mt-1 text-base font-semibold text-gray-100">MySQL (XAMPP)</div>
            <div class="mt-2 text-sm text-gray-400">Semua data tersimpan aman & rapi</div>
        </div>

        <div class="hidden items-center justify-center lg:flex">
            <svg class="h-6 w-6 text-gray-400" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                <path d="M5 12h14" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                <path d="m13 6 6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </div>

        <div class="rounded-xl border border-white/10 bg-white/5 p-4 lg:col-start-3">
            <div class="text-sm text-gray-400">3. Pengecekan</div>
            <div class="mt-1 text-base font-semibold text-gray-100">Sequential Search</div>
            <div class="mt-2 text-sm text-gray-400">Cek keluar hari ini s/d kurang dari 7 hari ke depan</div>
        </div>

        <div class="hidden items-center justify-center lg:flex">
            <svg class="h-6 w-6 text-gray-400" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                <path d="M5 12h14" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                <path d="m13 6 6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </div>

        <div class="rounded-xl border border-white/10 bg-white/5 p-4 lg:col-start-4">
            <div class="text-sm text-gray-400">4. Notifikasi</div>
            <div class="mt-1 text-base font-semibold text-gray-100">Muncul Otomatis</div>
            <div class="mt-2 text-sm text-gray-400">Menu: Notifikasi</div>
        </div>

        <div class="hidden items-center justify-center lg:flex">
            <svg class="h-6 w-6 text-gray-400" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                <path d="M5 12h14" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                <path d="m13 6 6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </div>

        <div class="rounded-xl border border-white/10 bg-white/5 p-4 lg:col-start-5">
            <div class="text-sm text-gray-400">5. Rekap</div>
            <div class="mt-1 text-base font-semibold text-gray-100">Laporan & Export Excel</div>
            <div class="mt-2 text-sm text-gray-400">Menu: Laporan</div>
        </div>
    </div>

    <div class="mt-4 flex flex-wrap gap-2">
        <a href="{{ url('/admin/tahanans') }}" class="rounded-lg bg-primary-600 px-3 py-2 text-sm font-semibold text-white hover:bg-primary-500">
            Buka Data Tahanan
        </a>
        <a href="{{ url('/admin/notifikasis') }}" class="rounded-lg bg-white/10 px-3 py-2 text-sm font-semibold text-gray-100 hover:bg-white/15">
            Buka Notifikasi
        </a>
        <a href="{{ url('/admin/laporan') }}" class="rounded-lg bg-white/10 px-3 py-2 text-sm font-semibold text-gray-100 hover:bg-white/15">
            Buka Laporan
        </a>
    </div>
</x-filament::section>
