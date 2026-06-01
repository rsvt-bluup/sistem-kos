@extends('layouts.app')

@section('title', 'Edit Data Kamar')

@section('content')

<div class="container-fluid">
    <div class="card p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold m-0" style="color: #28557d;">Edit Data Kamar</h4>
            <a href="{{ route('kamar.index') }}" class="btn btn-secondary btn-sm">
                <i class="ti ti-arrow-left"></i> Kembali
            </a>
        </div>

        <form action="{{ route('kamar.update', $kamar->id_kamar) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="nomor_kamar" class="form-label fw-semibold">Nomor Kamar</label>
                <input type="text" class="form-control" id="nomor_kamar" name="nomor_kamar" value="{{ $kamar->nomor_kamar }}" required>
            </div>

            <div class="mb-3">
                <label for="tipe" class="form-label fw-semibold">Tipe Kamar</label>
                <select class="form-select" id="tipe" name="tipe" required>
                    <option value="Deluxe" {{ $kamar->tipe == 'Deluxe' ? 'selected' : '' }}>Deluxe</option>
                    <option value="Suite" {{ $kamar->tipe == 'Suite' ? 'selected' : '' }}>Suite</option>
                    <option value="Standard" {{ $kamar->tipe == 'Standard' ? 'selected' : '' }}>Standard</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="harga" class="form-label fw-semibold">Harga</label>
                <input type="number" class="form-control" id="harga" name="harga" value="{{ $kamar->harga }}" required>
            </div>

            <div class="mb-4">
                <label for="status" class="form-label fw-semibold">Status</label>
                <select class="form-select" id="status" name="status" required>
                    <option value="Kosong" {{ $kamar->status == 'Kosong' ? 'selected' : '' }}>Kosong</option>
                    <option value="Terisi" {{ $kamar->status == 'Terisi' ? 'selected' : '' }}>Terisi</option>
                </select>
            </div>

            <div>
                <button type="submit" class="btn btn-primary">
                    <i class="ti ti-device-floppy"></i> Simpan Perubahan
                </button>
                <a href="{{ route('kamar.index') }}" class="btn btn-light border">Batal</a>
            </div>
        </form>
    </div>
</div>

@endsection