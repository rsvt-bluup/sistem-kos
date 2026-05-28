<?php

namespace App\Http\Controllers;

use App\Models\Kamar;
use App\Models\Penyewa;
use App\Models\Pembayaran;

class DashboardController extends Controller
{
    public function index()
    {
        $totalKamar = Kamar::count();

        $totalPenyewa = Penyewa::count();

        $sudahBayar = Pembayaran::where('status', 'Lunas')
                                ->count();

        $belumBayar = Pembayaran::where('status', 'Belum Lunas')
                                ->count();

        return view('pages.dashboard', compact(
            'totalKamar',
            'totalPenyewa',
            'sudahBayar',
            'belumBayar'
        ));
    }
}