<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Penyewa;
use App\Models\Kamar;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    public function index()
    {
        $pembayarans = Pembayaran::with([
            'penyewa',
            'kamar'
        ])->latest()->get();

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
            'bulan' => 'required',
            'status' => 'required',
            'bukti_bayar' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $bukti = $request->file('bukti_bayar')
            ->store('bukti_bayar', 'public');

        Pembayaran::create([
            'id_penyewa' => $request->id_penyewa,
            'id_kamar' => $request->id_kamar,
            'tanggal_bayar' => $request->tanggal_bayar,
            'jumlah_bayar' => $request->jumlah_bayar,
            'bukti_bayar' => $bukti,
            'bulan' => $request->bulan,
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
            'bulan' => 'required',
            'status' => 'required',
            'bukti_bayar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $pembayaran = Pembayaran::findOrFail($id);

        $data = [
            'id_penyewa' => $request->id_penyewa,
            'id_kamar' => $request->id_kamar,
            'tanggal_bayar' => $request->tanggal_bayar,
            'jumlah_bayar' => $request->jumlah_bayar,
            'bulan' => $request->bulan,
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
}
