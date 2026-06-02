@extends('layouts.app')

@section('title', 'Edit Data Pembayaran')

@section('content')

<div class="container-fluid">
    <div class="card p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold m-0" style="color: #28557d;">Edit Data Pembayaran</h4>
            <a href="{{ route('pembayaran.index') }}" class="btn btn-secondary btn-sm">
                <i class="ti ti-arrow-left"></i> Kembali
            </a>
        </div>

        <form action="{{ route('pembayaran.update', $pembayaran->id_bayar) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- ERROR VALIDASI --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Nama Penyewa</label>
                    <select name="id_penyewa" id="id_penyewa" class="form-select" required>
                        @foreach($penyewas as $penyewa)
                            <option value="{{ $penyewa->id_penyewa }}"
                                data-kamar-id="{{ $penyewa->id_kamar }}"
                                {{ $pembayaran->id_penyewa == $penyewa->id_penyewa ? 'selected' : '' }}>
                                {{ $penyewa->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Kamar Kos</label>
                    <select name="id_kamar" id="id_kamar" class="form-select" required>
                        @foreach($kamars as $kamar)
                            <option value="{{ $kamar->id_kamar }}"
                                {{ $pembayaran->id_kamar == $kamar->id_kamar ? 'selected' : '' }}>
                                {{ $kamar->nomor_kamar }} ({{ $kamar->tipe }})
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Bulan / Tahun</label>
                    @php
                        $bulanValue = old('bulan');
                        if (!$bulanValue && $pembayaran->bulan) {
                            $months = [
                                'Januari' => '01', 'Februari' => '02', 'Maret' => '03', 'April' => '04',
                                'Mei' => '05', 'Juni' => '06', 'Juli' => '07', 'Agustus' => '08',
                                'September' => '09', 'Oktober' => '10', 'November' => '11', 'Desember' => '12',
                            ];
                            $parts = explode(' ', $pembayaran->bulan);
                            if (count($parts) === 2 && isset($months[$parts[0]])) {
                                $bulanValue = $parts[1] . '-' . $months[$parts[0]];
                            }
                        }
                    @endphp
                    <input type="month" class="form-control" name="bulan"
                           value="{{ $bulanValue ?? '' }}" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Jumlah Bayar</label>
                    <input type="number" class="form-control" name="jumlah_bayar"
                           value="{{ $pembayaran->jumlah_bayar }}" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Tanggal Bayar</label>
                    <input type="date" class="form-control" name="tanggal_bayar"
                           value="{{ date('Y-m-d', strtotime($pembayaran->tanggal_bayar)) }}" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Status</label>
                    <select name="status" class="form-select" required>
                        <option value="Lunas" {{ $pembayaran->status == 'Lunas' ? 'selected' : '' }}>Lunas</option>
                        <option value="Belum Lunas" {{ $pembayaran->status == 'Belum Lunas' ? 'selected' : '' }}>Belum Lunas</option>
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Bukti Pembayaran</label>

                @if($pembayaran->bukti_bayar)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $pembayaran->bukti_bayar) }}"
                             width="150"
                             class="rounded border">
                    </div>
                @endif

                <input type="file" class="form-control" name="bukti_bayar" accept="image/*">
                <small class="text-muted">Kosongkan jika tidak ingin mengganti bukti</small>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary" style="background-color:#28557d;border:none;">
                    Simpan Perubahan
                </button>
                <a href="{{ route('pembayaran.index') }}" class="btn btn-light border">Batal</a>
            </div>

        </form>
    </div>
</div>

<script>
document.getElementById('id_penyewa').addEventListener('change', function () {
    let kamarId = this.options[this.selectedIndex].getAttribute('data-kamar-id');
    if (kamarId) {
        document.getElementById('id_kamar').value = kamarId;
    }
});
</script>

@endsection
