@extends('layouts.app')

@section('title', 'Edit Data Penyewa')

@section('content')

<div class="container-fluid">
    <div class="card p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold m-0" style="color: #28557d;">Edit Data Penyewa</h4>
            <a href="{{ route('penyewa.index') }}" class="btn btn-secondary btn-sm">
                <i class="ti ti-arrow-left"></i> Kembali
            </a>
        </div>

        <form action="{{ route('penyewa.update', $penyewa->id_penyewa) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="nama" class="form-label fw-semibold">Nama Penyewa</label>
                <input type="text" class="form-control" id="nama" name="nama" 
                       value="{{ $penyewa->nama ?? $penyewa->nama_penyewa }}" required>
            </div>

            <div class="mb-3">
                <label for="no_hp" class="form-label fw-semibold">No HP</label>
                <input type="text" class="form-control" id="no_hp" name="no_hp" value="{{ $penyewa->no_hp }}" required>
            </div>

            <div class="mb-3">
                <label for="id_kamar" class="form-label fw-semibold">Kamar</label>
                <select class="form-select" id="id_kamar" name="id_kamar" required>
                    @foreach($kamars as $kamar)
                        <option value="{{ $kamar->id_kamar }}" {{ $penyewa->id_kamar == $kamar->id_kamar ? 'selected' : '' }}>
                            {{ $kamar->nomor_kamar }} - ({{ $kamar->tipe }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="bulan" class="form-label fw-semibold">Bulan Pembayaran Terakhir</label>
                @php
                    $bulanValue = old('bulan');
                    if (!$bulanValue && optional($penyewa->pembayaranTerakhir)->bulan) {
                        $months = [
                            'Januari' => '01', 'Februari' => '02', 'Maret' => '03', 'April' => '04',
                            'Mei' => '05', 'Juni' => '06', 'Juli' => '07', 'Agustus' => '08',
                            'September' => '09', 'Oktober' => '10', 'November' => '11', 'Desember' => '12',
                        ];
                        $parts = explode(' ', optional($penyewa->pembayaranTerakhir)->bulan);
                        if (count($parts) === 2 && isset($months[$parts[0]])) {
                            $bulanValue = $parts[1] . '-' . $months[$parts[0]];
                        }
                    }
                @endphp
                <input type="month" class="form-control" id="bulan" name="bulan"
                       value="{{ $bulanValue ?? '' }}">
                <div class="form-text">Biarkan kosong jika tidak ingin mengubah bulan pembayaran terakhir.</div>
            </div>

            <div class="mb-4">
                <label class="form-label fw-semibold d-block">Dokumen KTP</label>

                @if($penyewa->ktp)

    <div class="card border-0 shadow-sm mb-3" style="max-width: 550px;">
        <div class="card-body">

            <div class="d-flex align-items-center gap-3">

                <img src="{{ asset('storage/' . $penyewa->ktp) }}"
                     alt="KTP"
                     class="rounded border"
                     style="width:180px;height:110px;object-fit:cover;">

                <div>
                    <h5 class="fw-bold mb-2 text-primary">
                        {{ $penyewa->nama ?? $penyewa->nama_penyewa }}
                    </h5>

                    <p class="mb-1">
                        <strong>No HP :</strong>
                        {{ $penyewa->no_hp }}
                    </p>

                    <p class="mb-2">
                        <strong>Kamar :</strong>
                        @foreach($kamars as $kamar)
                            @if($kamar->id_kamar == $penyewa->id_kamar)
                                {{ $kamar->nomor_kamar }} - {{ $kamar->tipe }}
                            @endif
                        @endforeach
                    </p>

                    
                </div>

            </div>

        </div>
    </div>

    @else

    <div class="alert alert-light border text-center">
        <i class="ti ti-image-off fs-4"></i>
        <br>
        Belum ada dokumen KTP
    </div>

    @endif
    <div class="form-text">
        Pilih file baru jika ingin mengganti KTP lama.
    </div>

    <input type="file"
           class="form-control"
           id="ktp"
           name="ktp"
           accept="image/*">

    
</div>

@if($penyewa->ktp)
<div class="modal fade" id="ktpModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">
                    Dokumen KTP -
                    {{ $penyewa->nama ?? $penyewa->nama_penyewa }}
                </h5>

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                </button>
            </div>

            <div class="modal-body text-center">
                <img src="{{ asset('storage/' . $penyewa->ktp) }}"
                     class="img-fluid rounded shadow">
            </div>

        </div>
    </div>
</div>
@endif
              
            </div>

            <hr class="text-muted mb-4">

            <div>
                <button type="submit" class="btn btn-primary" style="background-color: #28557d; border: none;">
                    <i class="ti ti-device-floppy"></i> Simpan Perubahan
                </button>
                <a href="{{ route('penyewa.index') }}" class="btn btn-light border">Batal</a>
            </div>
        </form>
    </div>
</div>

@endsection