@extends('layouts.app')

@section('title', 'Data Kamar')

@section('content')

<div class="container-fluid">
    <div class="card p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold m-0" style="color: #28557d;">Data Kamar</h4>
            <a href="{{ route('kamar.create') }}" class="btn btn-primary">
                <i class="ti ti-plus"></i> Tambah Kamar
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
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
                    @forelse($kamars as $kamar)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="fw-semibold">{{ $kamar->nomor_kamar }}</td>
                        <td>{{ $kamar->tipe }}</td>
                        <td class="fw-semibold">Rp {{ number_format($kamar->harga, 0, ',', '.') }}</td>
                        <td>
                            <span class="badge {{ $kamar->status == 'Kosong' ? 'bg-success' : 'bg-warning' }}">
                                {{ $kamar->status }}
                            </span>
                        </td>
                        <td class="text-center">
                            <a href="{{ route('kamar.edit', $kamar->id_kamar) }}" class="btn btn-info btn-sm text-white">
                                <i class="ti ti-pencil"></i> Edit
                            </a>

                            <form action="{{ route('kamar.destroy', $kamar->id_kamar) }}" method="POST" class="d-inline">
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
                        <td colspan="6" class="text-center text-muted py-4">Belum ada data kamar.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection