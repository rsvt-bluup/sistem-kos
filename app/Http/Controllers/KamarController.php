<?php

namespace App\Http\Controllers;

use App\Models\Kamar;
use Illuminate\Http\Request;

class KamarController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');

        $kamars = Kamar::latest();

        if ($search) {
            $kamars->where(function ($query) use ($search) {
                $query->where('nomor_kamar', 'like', "%{$search}%")
                    ->orWhere('tipe', 'like', "%{$search}%")
                    ->orWhere('status', 'like', "%{$search}%");
            });
        }

        $kamars = $kamars->paginate(10)->withQueryString();

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

    public function edit($id_kamar)
    {
        $kamar = Kamar::findOrFail($id_kamar);

        return view('pages.kamar.edit', compact('kamar'));
    }

    public function update(Request $request, $id_kamar)
    {
        $request->validate([
            'nomor_kamar' => 'required',
            'tipe' => 'required',
            'harga' => 'required',
            'status' => 'required',
        ]);

        $kamar = Kamar::findOrFail($id_kamar);

        $kamar->update([
            'nomor_kamar' => $request->nomor_kamar,
            'tipe' => $request->tipe,
            'harga' => $request->harga,
            'status' => $request->status,
        ]);

        return redirect()->route('kamar.index');
    }

    public function destroy($id_kamar)
    {
        $kamar = Kamar::findOrFail($id_kamar);

        $kamar->delete();

        return redirect()->route('kamar.index');
    }

    public function bulkDestroy(Request $request)
    {
        $ids = array_filter(explode(',', $request->ids));

        if (!empty($ids)) {
            Kamar::whereIn('id_kamar', $ids)->delete();
        }

        return redirect()->route('kamar.index');
    }
}