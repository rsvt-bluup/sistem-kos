<?php

namespace App\Http\Controllers;

use App\Models\Kamar;
use App\Models\Pembayaran;
use App\Models\Penyewa;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PenyewaController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');

        $penyewas = Penyewa::with([
            'kamar',
            'pembayaranTerakhir'
        ])->latest();

        if ($search) {
            $penyewas->where(function ($query) use ($search) {
                $query->where('nama', 'like', "%{$search}%")
                    ->orWhere('no_hp', 'like', "%{$search}%")
                    ->orWhereHas('kamar', function ($query) use ($search) {
                        $query->where('nomor_kamar', 'like', "%{$search}%")
                              ->orWhere('tipe', 'like', "%{$search}%");
                    });
            });
        }

        $penyewas = $penyewas->paginate(10)->withQueryString();

        return view('pages.penyewa.index', compact('penyewas'));
    }

    public function create()
    {
        $kamars = Kamar::where('status', 'Kosong')->get();

        return view('pages.penyewa.tambah', compact('kamars'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'no_hp' => 'required',
            'ktp' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'id_kamar' => 'required',
            'bulan' => 'nullable|date_format:Y-m',
        ]);

        $ktp = $request->file('ktp')->store('ktp', 'public');

        $penyewa = Penyewa::create([
            'nama' => $request->nama,
            'no_hp' => $request->no_hp,
            'ktp' => $ktp,
            'id_kamar' => $request->id_kamar,
        ]);

        $kamar = Kamar::find($request->id_kamar);

        Kamar::where('id_kamar', $request->id_kamar)
            ->update([
                'status' => 'Terisi'
            ]);

        $bulanLabel = $request->bulan ? Carbon::createFromFormat('Y-m', $request->bulan)->locale('id')->translatedFormat('F Y') : Carbon::now()->locale('id')->translatedFormat('F Y');

        Pembayaran::create([
            'id_penyewa' => $penyewa->id_penyewa,
            'id_kamar' => $request->id_kamar,
            'tanggal_bayar' => Carbon::now()->format('Y-m-d'),
            'jumlah_bayar' => $kamar ? $kamar->harga : 0,
            'bukti_bayar' => '',
            'bulan' => $bulanLabel,
            'status' => 'Belum Lunas',
        ]);

        return redirect()->route('penyewa.index');
    }

    public function edit($id)
    {
        $penyewa = Penyewa::with('pembayaranTerakhir')->findOrFail($id);

        $kamars = Kamar::all();

        return view('pages.penyewa.edit', compact('penyewa', 'kamars'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'no_hp' => 'required',
            'id_kamar' => 'required',
            'bulan' => 'nullable|date_format:Y-m',
        ]);

        $penyewa = Penyewa::findOrFail($id);

        $idKamarLama = $penyewa->id_kamar;

        $data = [
            'nama' => $request->nama,
            'no_hp' => $request->no_hp,
            'id_kamar' => $request->id_kamar,
        ];

        if ($request->hasFile('ktp')) {

            $request->validate([
                'ktp' => 'image|mimes:jpg,jpeg,png|max:2048'
            ]);

            $data['ktp'] = $request->file('ktp')
                                   ->store('ktp', 'public');
        }

        $penyewa->update($data);

        if($idKamarLama != $request->id_kamar){

            Kamar::where('id_kamar', $idKamarLama)
                ->update([
                    'status' => 'Kosong'
                ]);

            Kamar::where('id_kamar', $request->id_kamar)
                ->update([
                    'status' => 'Terisi'
                ]);
        }

        if ($request->bulan) {
            $bulanLabel = Carbon::createFromFormat('Y-m', $request->bulan)->locale('id')->translatedFormat('F Y');
            $latestPembayaran = $penyewa->pembayaranTerakhir;
            if ($latestPembayaran) {
                $latestPembayaran->update(['bulan' => $bulanLabel]);
            }
        }

        return redirect()->route('penyewa.index');
    }

    public function destroy($id)
    {
        $penyewa = Penyewa::findOrFail($id);

        Kamar::where('id_kamar', $penyewa->id_kamar)
            ->update([
                'status' => 'Kosong'
            ]);

        $penyewa->delete();

        return redirect()->route('penyewa.index');
    }

    public function bulkDestroy(Request $request)
    {
        $ids = array_filter(explode(',', $request->ids));

        if (!empty($ids)) {
            $penyewas = Penyewa::whereIn('id_penyewa', $ids)->get();

            foreach ($penyewas as $penyewa) {
                Kamar::where('id_kamar', $penyewa->id_kamar)
                    ->update(['status' => 'Kosong']);
            }

            Penyewa::whereIn('id_penyewa', $ids)->delete();
        }

        return redirect()->route('penyewa.index');
    }
}