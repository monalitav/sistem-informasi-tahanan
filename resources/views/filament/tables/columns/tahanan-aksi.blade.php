@php
    $record = $getRecord();
    $id = $record->getKey();
@endphp

<div class="flex items-center justify-end gap-2">
    <a
        href="{{ url('/admin/tahanans/' . $id) }}"
        class="rounded-lg bg-white/5 px-3 py-2 text-xs font-semibold text-gray-200 hover:bg-white/10"
    >
        Lihat
    </a>
    <a
        href="{{ url('/admin/tahanans/' . $id . '/edit') }}"
        class="rounded-lg bg-primary-600 px-3 py-2 text-xs font-semibold text-white hover:bg-primary-500"
    >
        Ubah
    </a>
    <form method="POST" action="{{ route('admin.tahanan.destroy', $record) }}">
        @csrf
        @method('DELETE')
        <button
            type="submit"
            class="rounded-lg bg-red-600 px-3 py-2 text-xs font-semibold text-white hover:bg-red-500"
            onclick="return confirm('Hapus data tahanan ini?')"
        >
            Hapus
        </button>
    </form>
</div>

