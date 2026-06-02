@extends('layouts.app')

@section('title', 'Tambah Pembayaran')

@section('content')

<!-- Background content preview (blurred by modal) -->
<div class="container-fluid opacity-40 pe-none">
    <div class="card p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold m-0" style="color: #28557d;">Data Pembayaran</h4>
            <button class="btn btn-primary" disabled>Tambah Pembayaran</button>
        </div>
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Penyewa</th>
                        <th>Kamar</th>
                        <th>Bulan</th>
                        <th>Jumlah</th>
                        <th>Status</th>
                        <th>Tanggal Bayar</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Budi Santoso</td>
                        <td>A1-01</td>
                        <td>Mei 2026</td>
                        <td>Rp 800.000</td>
                        <td><span class="badge bg-success">Lunas</span></td>
                        <td>02-05-2026</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Glassmorphic Centered Modal Form -->
<div class="modal-backdrop-blur">
    <div class="modal-card" style="max-width: 550px;">
        <div class="modal-card-header">
            <h5 class="modal-card-title d-flex align-items-center gap-2">
                <i class="ti ti-credit-card fs-5 text-primary"></i>
                <span>Catat Pembayaran Baru</span>
            </h5>
            <a href="{{ route('pembayaran.index') }}" class="modal-close-btn"><i class="ti ti-x"></i></a>
        </div>
        <div class="modal-card-body">
            <form action="{{ route('pembayaran.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nama Penyewa</label>
                        <select name="id_penyewa" id="id_penyewa" class="form-select" required>
                            <option value="" disabled selected>-- Pilih Penyewa --</option>
                            @foreach($penyewas as $penyewa)
                                <option value="{{ $penyewa->id_penyewa }}" data-kamar-id="{{ $penyewa->id_kamar }}">
                                    {{ $penyewa->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Kamar Kos</label>
                        <select name="id_kamar" id="id_kamar" class="form-select" required>
                            <option value="" disabled selected>-- Pilih Kamar --</option>
                            @foreach($kamars as $kamar)
                                <option value="{{ $kamar->id_kamar }}">
                                    {{ $kamar->nomor_kamar }} ({{ $kamar->tipe }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Bulan Pembayaran</label>
                        <input type="month" name="bulan" class="form-control" value="{{ old('bulan', date('Y-m')) }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tanggal Bayar</label>
                        <input type="date" name="tanggal_bayar" class="form-control" required value="{{ date('Y-m-d') }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Jumlah Pembayaran</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0">Rp</span>
                            <input type="number" name="jumlah_bayar" class="form-control" placeholder="Contoh: 800000" required>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select" required>
                            <option value="Lunas">Lunas</option>
                            <option value="Belum Lunas">Belum Lunas</option>
                        </select>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label">Bukti Pembayaran (Foto/Scan - Max 2MB)</label>
                    <input type="file" name="bukti_bayar" class="form-control" accept="image/*" required>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('pembayaran.index') }}" class="btn btn-light-custom">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan Transaksi</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('id_penyewa').addEventListener('change', function() {
        let selectedOption = this.options[this.selectedIndex];
        let kamarId = selectedOption.getAttribute('data-kamar-id');
        if (kamarId) {
            document.getElementById('id_kamar').value = kamarId;
        }
    });
</script>

@endsection
