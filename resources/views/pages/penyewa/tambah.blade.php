@extends('layouts.app')

@section('title', 'Tambah Penyewa')

@section('content')

<!-- Background content preview (blurred by modal) -->
<div class="container-fluid opacity-40 pe-none">
    <div class="card p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold m-0" style="color: #28557d;">Data Penyewa</h4>
            <button class="btn btn-primary" disabled>Tambah Penyewa</button>
        </div>
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Penyewa</th>
                        <th>No HP</th>
                        <th>Kamar</th>
                        <th>Dokumen KTP</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Budi Santoso</td>
                        <td>081234567890</td>
                        <td>A1-01</td>
                        <td>-</td>
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
                <i class="ti ti-user-plus fs-5 text-primary"></i>
                <span>Tambah Penyewa Baru</span>
            </h5>
            <a href="{{ route('penyewa.index') }}" class="modal-close-btn"><i class="ti ti-x"></i></a>
        </div>
        <div class="modal-card-body">
            <form action="{{ route('penyewa.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Nama Penyewa</label>
                    <input type="text" name="nama" class="form-control" placeholder="Nama Lengkap" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Nomor Handphone</label>
                    <input type="text" name="no_hp" class="form-control" placeholder="Contoh: 0812xxxxxxxx" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Pilih Kamar Kosong</label>
                    <select name="id_kamar" class="form-select" required>
                        <option value="" disabled selected>-- Pilih Kamar --</option>
                        @foreach($kamars as $kamar)
                            <option value="{{ $kamar->id_kamar }}">
                                {{ $kamar->nomor_kamar }} ({{ $kamar->tipe }} - Rp {{ number_format($kamar->harga, 0, ',', '.') }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label class="form-label">Foto / Scan KTP (Max 2MB)</label>
                    <input type="file" name="ktp" class="form-control" accept="image/*" required>
                </div>
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('penyewa.index') }}" class="btn btn-light-custom">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan Penyewa</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
