@extends('layouts.app')

@section('title', 'Tambah Kamar')

@section('content')

<!-- Background content preview (blurred by modal) -->
<div class="container-fluid opacity-40 pe-none">
    <div class="card p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold m-0" style="color: #28557d;">Data Kamar</h4>
            <button class="btn btn-primary" disabled>Tambah Kamar</button>
        </div>
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nomor Kamar</th>
                        <th>Tipe</th>
                        <th>Harga</th>
                        <th>Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>A1-01</td>
                        <td>Standard</td>
                        <td>Rp 800.000</td>
                        <td><span class="badge bg-success">Kosong</span></td>
                        <td class="text-center">-</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Glassmorphic Centered Modal Form -->
<div class="modal-backdrop-blur">
    <div class="modal-card">
        <div class="modal-card-header">
            <h5 class="modal-card-title d-flex align-items-center gap-2">
                <i class="ti ti-door fs-5 text-primary"></i>
                <span>Tambah Kamar Baru</span>
            </h5>
            <a href="{{ route('kamar.index') }}" class="modal-close-btn"><i class="ti ti-x"></i></a>
        </div>
        <div class="modal-card-body">
            <form action="{{ route('kamar.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Nomor Kamar</label>
                    <input type="text" name="nomor_kamar" class="form-control" placeholder="Contoh: A1-01" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Tipe Kamar</label>
                    <select name="tipe" class="form-select" required>
                        <option value="Standard">Standard</option>
                        <option value="Deluxe">Deluxe</option>
                        <option value="Suite">Suite</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Harga Sewa per Bulan</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0">Rp</span>
                        <input type="number" name="harga" class="form-control" placeholder="Contoh: 800000" required>
                    </div>
                </div>
                <div class="mb-4">
                    <label class="form-label">Status Awal</label>
                    <select name="status" class="form-select" required>
                        <option value="Kosong">Kosong</option>
                        <option value="Terisi">Terisi</option>
                    </select>
                </div>
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('kamar.index') }}" class="btn btn-light-custom">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan Kamar</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
