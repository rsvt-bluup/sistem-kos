<?php

namespace App\Http\Controllers;

use App\Models\Kamar;
use Illuminate\Http\Request;

class KamarController extends Controller
{
    public function index()
    {
        $kamars = Kamar::latest()->get();

        return view('pages.kamar.index', compact('kamars'));
    }

    public function create()
    {
        return view('pages.kamar.tambah');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nomor_kamar' => 'required',
            'tipe' => 'required',
            'harga' => 'required',
            'status' => 'required',
        ]);

        Kamar::create([
            'nomor_kamar' => $request->nomor_kamar,
            'tipe' => $request->tipe,
            'harga' => $request->harga,
            'status' => $request->status,
        ]);

        return redirect()->route('kamar.index');
    }

    public function edit($id)
    {
        $kamar = Kamar::findOrFail($id);

        return view('pages.kamar.edit', compact('kamar'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nomor_kamar' => 'required',
            'tipe' => 'required',
            'harga' => 'required',
            'status' => 'required',
        ]);

        $kamar = Kamar::findOrFail($id);

        $kamar->update([
            'nomor_kamar' => $request->nomor_kamar,
            'tipe' => $request->tipe,
            'harga' => $request->harga,
            'status' => $request->status,
        ]);

        return redirect()->route('kamar.index');
    }

    public function destroy($id)
    {
        $kamar = Kamar::findOrFail($id);

        $kamar->delete();

        return redirect()->route('kamar.index');
    }
}