<?php

namespace App\Http\Controllers;

use App\Models\Kamar;
use App\Models\Penyewa;
use Illuminate\Http\Request;

class PenyewaController extends Controller
{
    public function index()
    {
        $penyewas = Penyewa::with([
            'kamar',
            'pembayaranTerakhir'
        ])->latest()->get();

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
        ]);

        $ktp = $request->file('ktp')->store('ktp', 'public');

        Penyewa::create([
            'nama' => $request->nama,
            'no_hp' => $request->no_hp,
            'ktp' => $ktp,
            'id_kamar' => $request->id_kamar,
        ]);

        Kamar::where('id_kamar', $request->id_kamar)
            ->update([
                'status' => 'Terisi'
            ]);

        return redirect()->route('penyewa.index');
    }

    public function edit($id)
    {
        $penyewa = Penyewa::findOrFail($id);

        $kamars = Kamar::all();

        return view('pages.penyewa.edit', compact('penyewa', 'kamars'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'no_hp' => 'required',
            'id_kamar' => 'required',
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
}