<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Penyewa;
use App\Models\Kamar;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');

        $pembayarans = Pembayaran::with([
            'penyewa',
            'kamar'
        ])->latest();

        if ($search) {
            $pembayarans->where(function ($query) use ($search) {
                $query->where('bulan', 'like', "%{$search}%")
                    ->orWhere('status', 'like', "%{$search}%")
                    ->orWhereHas('penyewa', function ($query) use ($search) {
                        $query->where('nama', 'like', "%{$search}%")
                              ->orWhere('no_hp', 'like', "%{$search}%");
                    })
                    ->orWhereHas('kamar', function ($query) use ($search) {
                        $query->where('nomor_kamar', 'like', "%{$search}%")
                              ->orWhere('tipe', 'like', "%{$search}%");
                    });
            });
        }

        $pembayarans = $pembayarans->paginate(10)->withQueryString();

        return view('pages.pembayaran.index', compact('pembayarans'));
    }

    public function create()
    {
        $penyewas = Penyewa::all();
        $kamars = Kamar::all();

        return view('pages.pembayaran.tambah', compact('penyewas', 'kamars'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_penyewa' => 'required',
            'id_kamar' => 'required',
            'tanggal_bayar' => 'required',
            'jumlah_bayar' => 'required|numeric',
            'status' => 'required',
            'bukti_bayar' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $bukti = $request->file('bukti_bayar')
            ->store('bukti_bayar', 'public');

        $bulanLabel = Carbon::createFromFormat('Y-m', $request->bulan)->locale('id')->translatedFormat('F Y');

        Pembayaran::create([
            'id_penyewa' => $request->id_penyewa,
            'id_kamar' => $request->id_kamar,
            'tanggal_bayar' => $request->tanggal_bayar,
            'jumlah_bayar' => $request->jumlah_bayar,
            'bukti_bayar' => $bukti,
            'bulan' => $bulanLabel,
            'status' => $request->status,
        ]);

        return redirect()->route('pembayaran.index')
            ->with('success', 'Data pembayaran berhasil ditambahkan');
    }

    public function edit($id)
    {
        $pembayaran = Pembayaran::findOrFail($id);

        $penyewas = Penyewa::all();
        $kamars = Kamar::all();

        return view('pages.pembayaran.edit', compact(
            'pembayaran',
            'penyewas',
            'kamars'
        ));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_penyewa' => 'required',
            'id_kamar' => 'required',
            'tanggal_bayar' => 'required',
            'jumlah_bayar' => 'required|numeric',
            'bulan' => 'required|date_format:Y-m',
            'status' => 'required',
            'bukti_bayar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $pembayaran = Pembayaran::findOrFail($id);

        $bulanLabel = Carbon::createFromFormat('Y-m', $request->bulan)->locale('id')->translatedFormat('F Y');

        $data = [
            'id_penyewa' => $request->id_penyewa,
            'id_kamar' => $request->id_kamar,
            'tanggal_bayar' => $request->tanggal_bayar,
            'jumlah_bayar' => $request->jumlah_bayar,
            'bulan' => $bulanLabel,
            'status' => $request->status,
        ];

        if ($request->hasFile('bukti_bayar')) {
            $data['bukti_bayar'] = $request->file('bukti_bayar')
                ->store('bukti_bayar', 'public');
        }

        $pembayaran->update($data);

        return redirect()->route('pembayaran.index')
            ->with('success', 'Data pembayaran berhasil diperbarui');
    }

    public function destroy($id)
    {
        $pembayaran = Pembayaran::findOrFail($id);

        $pembayaran->delete();

        return redirect()->route('pembayaran.index')
            ->with('success', 'Data pembayaran berhasil dihapus');
    }

    public function bulkDestroy(Request $request)
    {
        $ids = array_filter(explode(',', $request->ids));

        if (!empty($ids)) {
            Pembayaran::whereIn('id_bayar', $ids)->delete();
        }

        return redirect()->route('pembayaran.index')
            ->with('success', 'Data pembayaran berhasil dihapus');
    }
}
