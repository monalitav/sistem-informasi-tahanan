<x-filament-panels::page>
    <div class="space-y-4">
        {{-- Filter dan Search Bar --}}
        <div class="rounded-lg bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
            <div class="p-4">
                <div class="grid grid-cols-1 gap-4 md:grid-cols-4">
                    {{-- Search --}}
                    <div>
                        <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Cari
                        </label>
                        <input 
                            type="text" 
                            id="search"
                            wire:model.live.debounce.500ms="search"
                            placeholder="Nama, NIK, No. Registrasi..."
                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white sm:text-sm"
                        />
                    </div>

                    {{-- Status Filter --}}
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Status
                        </label>
                        <select 
                            id="status"
                            wire:model.live="status"
                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white sm:text-sm"
                        >
                            <option value="">Semua Status</option>
                            <option value="aktif">Aktif</option>
                            <option value="keluar">Keluar</option>
                        </select>
                    </div>

                    {{-- 7 Hari Filter --}}
                    <div>
                        <label for="keluar_7_hari" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Filter Cepat
                        </label>
                        <div class="flex items-center h-[38px]">
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input 
                                    type="checkbox" 
                                    wire:click="toggleKeluar7Hari"
                                    {{ $keluar_7_hari === 'true' ? 'checked' : '' }}
                                    class="h-4 w-4 rounded border-gray-300 text-primary-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:border-gray-700 dark:bg-gray-800"
                                />
                                <span class="text-sm text-gray-600 dark:text-gray-400">
                                    Keluar ≤ 7 hari
                                </span>
                            </label>
                        </div>
                    </div>

                    {{-- Clear Filters --}}
                    <div>
                        <button 
                            wire:click="clearFilters"
                            type="button"
                            style="background-color: #fee2e2; border-color: #f87171; color: #b91c1c;"
                            class="inline-flex items-center justify-center h-[38px] px-4 rounded-lg border-2 text-sm font-semibold shadow-sm hover:brightness-95 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-all dark:[background-color:#450a0a] dark:[border-color:#dc2626] dark:[color:#fca5a5]"
                            onmouseover="this.style.backgroundColor='#fecaca'"
                            onmouseout="this.style.backgroundColor='#fee2e2'"
                        >
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            Reset Filter
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Table --}}
        <div class="rounded-lg bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
            <div class="overflow-x-auto">
                <table class="w-full table-auto divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-800">
                        <tr>
                            <th wire:click="sortBy('nomor_registrasi')" class="cursor-pointer px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400 hover:bg-gray-100/50 dark:hover:bg-gray-700/50 transition-colors">
                                <div class="flex items-center space-x-1">
                                    <span>No. Registrasi</span>
                                    @if($sort === 'nomor_registrasi')
                                        <svg class="w-4 h-4 {{ $order === 'asc' ? '' : 'rotate-180' }}" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                        </svg>
                                    @endif
                                </div>
                            </th>
                            <th wire:click="sortBy('nama')" class="cursor-pointer px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400 hover:bg-gray-100/50 dark:hover:bg-gray-700/50 transition-colors">
                                <div class="flex items-center space-x-1">
                                    <span>Nama</span>
                                    @if($sort === 'nama')
                                        <svg class="w-4 h-4 {{ $order === 'asc' ? '' : 'rotate-180' }}" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                        </svg>
                                    @endif
                                </div>
                            </th>
                            <th wire:click="sortBy('tanggal_masuk')" class="cursor-pointer px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400 hover:bg-gray-100/50 dark:hover:bg-gray-700/50 transition-colors">
                                <div class="flex items-center space-x-1">
                                    <span>Masuk</span>
                                    @if($sort === 'tanggal_masuk')
                                        <svg class="w-4 h-4 {{ $order === 'asc' ? '' : 'rotate-180' }}" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                        </svg>
                                    @endif
                                </div>
                            </th>
                            <th wire:click="sortBy('tanggal_keluar')" class="cursor-pointer px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400 hover:bg-gray-100/50 dark:hover:bg-gray-700/50 transition-colors">
                                <div class="flex items-center space-x-1">
                                    <span>Keluar</span>
                                    @if($sort === 'tanggal_keluar')
                                        <svg class="w-4 h-4 {{ $order === 'asc' ? '' : 'rotate-180' }}" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                        </svg>
                                    @endif
                                </div>
                            </th>
                            <th wire:click="sortBy('status')" class="cursor-pointer px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400 hover:bg-gray-100/50 dark:hover:bg-gray-700/50 transition-colors">
                                <div class="flex items-center space-x-1">
                                    <span>Status</span>
                                    @if($sort === 'status')
                                        <svg class="w-4 h-4 {{ $order === 'asc' ? '' : 'rotate-180' }}" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                        </svg>
                                    @endif
                                </div>
                            </th>
                            <th class="px-4 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white dark:divide-gray-700 dark:bg-gray-900">
                        @forelse($this->getTableRecords() as $record)
                            <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-800/50 transition-colors">
                                <td class="whitespace-nowrap px-4 py-3 text-sm text-gray-900 dark:text-gray-100">
                                    {{ $record->nomor_registrasi }}
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 text-sm text-gray-900 dark:text-gray-100">
                                    {{ $record->nama }}
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 text-sm text-gray-900 dark:text-gray-100">
                                    {{ $record->tanggal_masuk?->format('d-m-Y') ?? '-' }}
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 text-sm text-gray-900 dark:text-gray-100">
                                    {{ $record->tanggal_keluar?->format('d-m-Y') ?? '-' }}
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 text-sm">
                                    <span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset
                                        {{ $record->status === 'aktif' ? 'bg-green-50 text-green-700 ring-green-600/20 dark:bg-green-500/10 dark:text-green-400 dark:ring-green-500/20' : 'bg-gray-50 text-gray-600 ring-gray-500/10 dark:bg-gray-400/10 dark:text-gray-400 dark:ring-gray-400/20' }}">
                                        {{ ucfirst($record->status) }}
                                    </span>
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 text-right text-sm">
                                    <div class="flex items-center justify-end gap-2">
                                        <a
                                            href="{{ url('/admin/tahanans/' . $record->id) }}"
                                            class="rounded-lg bg-gray-100 px-3 py-2 text-xs font-semibold text-gray-700 hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600 transition-colors"
                                        >
                                            Lihat
                                        </a>
                                        <a
                                            href="{{ url('/admin/tahanans/' . $record->id . '/edit') }}"
                                            class="rounded-lg bg-primary-600 px-3 py-2 text-xs font-semibold text-white hover:bg-primary-500 transition-colors"
                                        >
                                            Ubah
                                        </a>
                                        <form method="POST" action="{{ route('admin.tahanan.destroy', $record) }}" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button
                                                type="submit"
                                                class="rounded-lg bg-red-600 px-3 py-2 text-xs font-semibold text-white hover:bg-red-500 transition-colors"
                                                onclick="return confirm('Hapus data tahanan ini?')"
                                            >
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-12 text-center text-sm text-gray-500 dark:text-gray-400">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-12 h-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                        </svg>
                                        <p class="font-medium">Tidak ada data ditemukan</p>
                                        <p class="text-xs mt-1">Coba ubah filter atau tambah data tahanan baru</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="border-t border-gray-200 bg-white px-4 py-3 dark:border-gray-700 dark:bg-gray-900">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-3">
                    <div class="text-sm text-gray-700 dark:text-gray-300">
                        Showing 
                        <span class="font-medium">{{ $this->getTableRecords()->firstItem() ?? 0 }}</span>
                        to 
                        <span class="font-medium">{{ $this->getTableRecords()->lastItem() ?? 0 }}</span>
                        of 
                        <span class="font-medium">{{ $this->getTableRecords()->total() }}</span>
                        results
                    </div>
                    
                    <div>
                        <nav class="isolate inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">
                            {{-- Previous Button --}}
                            @if ($this->getTableRecords()->onFirstPage())
                                <span class="relative inline-flex items-center rounded-l-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 dark:ring-gray-700 cursor-not-allowed">
                                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M12.79 5.23a.75.75 0 01-.02 1.06L8.832 10l3.938 3.71a.75.75 0 11-1.04 1.08l-4.5-4.25a.75.75 0 010-1.08l4.5-4.25a.75.75 0 011.06.02z" clip-rule="evenodd" />
                                    </svg>
                                </span>
                            @else
                                <button wire:click="previousPage" class="relative inline-flex items-center rounded-l-md px-2 py-2 text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 dark:text-gray-100 dark:ring-gray-700 dark:hover:bg-gray-800">
                                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M12.79 5.23a.75.75 0 01-.02 1.06L8.832 10l3.938 3.71a.75.75 0 11-1.04 1.08l-4.5-4.25a.75.75 0 010-1.08l4.5-4.25a.75.75 0 011.06.02z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            @endif

                            {{-- Page Numbers --}}
                            @foreach(range(1, $this->getTableRecords()->lastPage()) as $pageNum)
                                @if($pageNum == $this->getTableRecords()->currentPage())
                                    <span class="relative z-10 inline-flex items-center bg-primary-600 px-4 py-2 text-sm font-semibold text-white focus:z-20">
                                        {{ $pageNum }}
                                    </span>
                                @else
                                    <button wire:click="gotoPage({{ $pageNum }})" class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 dark:text-gray-100 dark:ring-gray-700 dark:hover:bg-gray-800">
                                        {{ $pageNum }}
                                    </button>
                                @endif
                            @endforeach

                            {{-- Next Button --}}
                            @if ($this->getTableRecords()->hasMorePages())
                                <button wire:click="nextPage" class="relative inline-flex items-center rounded-r-md px-2 py-2 text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 dark:text-gray-100 dark:ring-gray-700 dark:hover:bg-gray-800">
                                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            @else
                                <span class="relative inline-flex items-center rounded-r-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 dark:ring-gray-700 cursor-not-allowed">
                                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                                    </svg>
                                </span>
                            @endif
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-filament-panels::page>
