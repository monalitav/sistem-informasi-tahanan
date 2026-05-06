<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tahanan;
use Illuminate\Http\RedirectResponse;

class TahananDestroyController
{
    public function __invoke(Tahanan $tahanan): RedirectResponse
    {
        $tahanan->delete();

        return redirect()
            ->to(url('/admin/tahanans'))
            ->with('status', 'Data tahanan berhasil dihapus.');
    }
}
