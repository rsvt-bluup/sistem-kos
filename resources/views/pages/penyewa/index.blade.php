@extends('layouts.app')

@section('title', 'Data Penyewa')

@section('content')

<div class="container-fluid">

    <div class="card p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold m-0" style="color: #28557d;">Data Penyewa</h4>
            <a href="{{ route('penyewa.create') }}" class="btn btn-primary">
                <i class="ti ti-plus"></i> Tambah Penyewa
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
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
                    @forelse($penyewas as $penyewa)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="fw-semibold">{{ $penyewa->nama }}</td>
                        <td>{{ $penyewa->no_hp }}</td>
                        <td>
                            <span class="badge bg-info">
                                {{ $penyewa->kamar->nomor_kamar ?? '-' }}
                            </span>
                        </td>
                        <td>
                            @if($penyewa->ktp)
                                <a href="{{ asset('storage/' . $penyewa->ktp) }}" target="_blank" class="btn btn-sm btn-outline-primary py-1 px-2 d-inline-flex align-items-center gap-1">
                                    <i class="ti ti-id-badge fs-5"></i> Lihat KTP
                                </a>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <a href="{{ route('penyewa.edit', $penyewa->id_penyewa) }}" class="btn btn-sm btn-info text-white btn-action">
                                <i class="ti ti-pencil"></i>
                            </a>
                            <form action="{{ route('penyewa.destroy', $penyewa->id_penyewa) }}" method="POST" class="d-inline">
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
                        <td colspan="6" class="text-center text-muted py-4">Belum ada data penyewa.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

@endsection