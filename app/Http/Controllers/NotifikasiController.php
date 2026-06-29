<?php

namespace App\Http\Controllers;

use App\Models\Notifikasi;
use Illuminate\Http\Request;

class NotifikasiController extends Controller
{
    public function tandaiDibaca($id)
    {
        $notifikasi = Notifikasi::findOrFail($id);
        $notifikasi->update(['terbaca_at' => now()]);
        
        return response()->json(['success' => true]);
    }
}
