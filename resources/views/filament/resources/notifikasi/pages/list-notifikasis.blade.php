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
                            placeholder="Nama, No. Registrasi, Pesan..."
                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white sm:text-sm"
                        />
                    </div>

                    {{-- Status Baca Filter --}}
                    <div>
                        <label for="is_terbaca" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Status Baca
                        </label>
                        <select 
                            id="is_terbaca"
                            wire:model.live="is_terbaca"
                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white sm:text-sm"
                        >
                            <option value="">Semua</option>
                            <option value="false">Belum Dibaca</option>
                            <option value="true">Sudah Dibaca</option>
                        </select>
                    </div>

                    {{-- Jenis Filter --}}
                    <div>
                        <label for="jenis" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Jenis Notifikasi
                        </label>
                        <select 
                            id="jenis"
                            wire:model.live="jenis"
                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white sm:text-sm"
                        >
                            <option value="">Semua Jenis</option>
                            <option value="keluar_hari_ini">Keluar hari ini</option>
                            <option value="keluar_7_hari">Keluar kurang dari 7 hari</option>
                        </select>
                    </div>

                    {{-- Clear Filters --}}
                    <div>
                        <label class="block text-sm font-medium mb-1 invisible">Action</label>
                        <button 
                            wire:click="clearFilters"
                            type="button"
                            style="background-color: #fee2e2; border-color: #f87171; color: #b91c1c;"
                            class="inline-flex items-center justify-center h-[38px] px-4 rounded-lg border-2 text-sm font-semibold shadow-sm hover:brightness-95 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-all"
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
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                No. Registrasi
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                Nama
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                Jenis
                            </th>
                            <th wire:click="sortBy('tanggal_target')" class="cursor-pointer px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400 hover:bg-gray-100/50 dark:hover:bg-gray-700/50 transition-colors">
                                <div class="flex items-center space-x-1">
                                    <span>Tanggal</span>
                                    @if($sort === 'tanggal_target')
                                        <svg class="w-4 h-4 {{ $order === 'asc' ? '' : 'rotate-180' }}" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                        </svg>
                                    @endif
                                </div>
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                Sisa Hari
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                Pesan
                            </th>
                            <th class="px-4 py-3 text-center text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                Status
                            </th>
                            <th wire:click="sortBy('terbaca_at')" class="cursor-pointer px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400 hover:bg-gray-100/50 dark:hover:bg-gray-700/50 transition-colors">
                                <div class="flex items-center space-x-1">
                                    <span>Waktu Terbaca</span>
                                    @if($sort === 'terbaca_at')
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
                            @php
                                $diffDays = $record->tanggal_target ? now()->startOfDay()->diffInDays($record->tanggal_target, false) : null;
                                $jenisLabel = $record->jenis === 'keluar_hari_ini' 
                                    ? 'Keluar hari ini' 
                                    : ($diffDays !== null ? "Keluar kurang " . max(1, (int)$diffDays) . " hari" : 'Keluar kurang dari 7 hari');
                            @endphp
                            <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-800/50 transition-colors">
                                <td class="whitespace-nowrap px-4 py-3 text-sm font-bold text-gray-900 dark:text-gray-100">
                                    {{ $record->tahanan->nomor_registrasi }}
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 text-sm text-gray-900 dark:text-gray-100">
                                    {{ $record->tahanan->nama }}
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 text-sm">
                                    <span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset
                                        {{ $record->jenis === 'keluar_hari_ini' ? 'bg-red-50 text-red-700 ring-red-600/20 dark:bg-red-500/10 dark:text-red-400 dark:ring-red-500/20' : 'bg-amber-50 text-amber-700 ring-amber-600/20 dark:bg-amber-500/10 dark:text-amber-400 dark:ring-amber-500/20' }}">
                                        {{ $jenisLabel }}
                                    </span>
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 text-sm text-gray-900 dark:text-gray-100">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        {{ $record->tanggal_target?->format('d-m-Y') ?? '-' }}
                                        @if($record->tanggal_target?->isToday())
                                            <span class="text-xs text-red-600 dark:text-red-400 font-medium">(Hari ini)</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 text-sm">
                                    @if($diffDays !== null)
                                        <span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset
                                            {{ $diffDays <= 0 ? 'bg-red-50 text-red-700 ring-red-600/20 dark:bg-red-500/10 dark:text-red-400 dark:ring-red-500/20' : 
                                               ($diffDays <= 2 ? 'bg-amber-50 text-amber-700 ring-amber-600/20 dark:bg-amber-500/10 dark:text-amber-400 dark:ring-amber-500/20' : 
                                               'bg-green-50 text-green-700 ring-green-600/20 dark:bg-green-500/10 dark:text-green-400 dark:ring-green-500/20') }}">
                                            @if($diffDays == 0)
                                                Hari ini
                                            @elseif($diffDays < 0)
                                                Lewat {{ abs($diffDays) }} hari
                                            @else
                                                {{ $diffDays }} hari lagi
                                            @endif
                                        </span>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-900 dark:text-gray-100" style="min-width: 300px; max-width: 400px;">
                                    <div class="line-clamp-2" title="{{ $record->pesan }}">
                                        {{ $record->pesan }}
                                    </div>
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 text-sm text-center">
                                    @if($record->terbaca_at)
                                        <svg class="w-6 h-6 text-green-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    @else
                                        <svg class="w-6 h-6 text-amber-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                        </svg>
                                    @endif
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 text-sm text-gray-900 dark:text-gray-100">
                                    {{ $record->terbaca_at?->format('d-m-Y H:i') ?? '-' }}
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 text-right text-sm">
                                    <div class="flex items-center justify-end gap-2">
                                        <a
                                            href="{{ url('/admin/tahanans/' . $record->tahanan_id) }}"
                                            class="rounded-lg bg-gray-100 px-3 py-2 text-xs font-semibold text-gray-700 hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600 transition-colors"
                                        >
                                            Detail
                                        </a>
                                        @if(!$record->terbaca_at)
                                            <button
                                                wire:click="$dispatch('tandai-dibaca', { id: {{ $record->id }} })"
                                                onclick="fetch('{{ url('/admin/notifikasis/tandai-dibaca/' . $record->id) }}', { method: 'POST', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } }).then(() => window.location.reload())"
                                                class="rounded-lg bg-primary-600 px-3 py-2 text-xs font-semibold text-white hover:bg-primary-500 transition-colors"
                                            >
                                                Tandai dibaca
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="px-4 py-12 text-center text-sm text-gray-500 dark:text-gray-400">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-16 h-16 text-gray-300 dark:text-gray-600 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                                        </svg>
                                        <p class="font-semibold text-base text-gray-700 dark:text-gray-300">Belum ada notifikasi</p>
                                        <p class="text-sm mt-1 text-gray-500 dark:text-gray-400">Klik Refresh Data untuk mengecek tahanan yang keluar hari ini dan kurang dari 7 hari ke depan</p>
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
