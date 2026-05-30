@extends('layouts.app')

@section('title', 'Data Pembayaran')

@section('content')

<div class="container-fluid">

    <div class="card p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold m-0" style="color: #28557d;">Data Pembayaran</h4>
            <a href="{{ route('pembayaran.create') }}" class="btn btn-primary">
                <i class="ti ti-plus"></i> Tambah Pembayaran
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Penyewa</th>
                        <th>Kamar</th>
                        <th>Bulan</th>
                        <th>Jumlah Bayar</th>
                        <th>Tanggal Bayar</th>
                        <th>Status</th>
                        <th>Bukti</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pembayarans as $pembayaran)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="fw-semibold">{{ $pembayaran->penyewa->nama ?? '-' }}</td>
                        <td>
                            <span class="badge bg-info">
                                {{ $pembayaran->kamar->nomor_kamar ?? '-' }}
                            </span>
                        </td>
                        <td>{{ $pembayaran->bulan }}</td>
                        <td class="fw-semibold">Rp {{ number_format($pembayaran->jumlah_bayar, 0, ',', '.') }}</td>
                        <td>{{ \Carbon\Carbon::parse($pembayaran->tanggal_bayar)->format('d-m-Y') }}</td>
                        <td>
                            <span class="badge {{ $pembayaran->status == 'Lunas' ? 'bg-success' : 'bg-warning' }}">
                                {{ $pembayaran->status }}
                            </span>
                        </td>
                        <td>
                            @if($pembayaran->bukti_bayar)
                                <a href="{{ asset('storage/' . $pembayaran->bukti_bayar) }}" target="_blank" class="btn btn-sm btn-outline-primary py-1 px-2 d-inline-flex align-items-center gap-1">
                                    <i class="ti ti-file-text fs-5"></i> Bukti
                                </a>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <a href="{{ route('pembayaran.edit', $pembayaran->id_bayar) }}" class="btn btn-sm btn-info text-white btn-action">
                                <i class="ti ti-pencil"></i>
                            </a>
                            <form action="{{ route('pembayaran.destroy', $pembayaran->id_bayar) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger btn-action" onclick="return confirm('Yakin ingin menghapus?')">
                                    <i class="ti ti-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center text-muted py-4">Belum ada data pembayaran.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

@endsection