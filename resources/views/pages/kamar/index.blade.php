@extends('layouts.app')

@section('title', 'Data Kamar')

@section('content')

<style>
    .card { border-radius: 20px; border: 1px solid rgba(40, 85, 125, 0.12); box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04); }
    .table thead { background-color: #f8fafc; color: #28557d; }
    .btn-action { padding: 5px 12px; border-radius: 8px; }
</style>

<div class="container-fluid">
    <div class="card p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold" style="color: #28557d;">Data Kamar</h4>
            <a href="{{ route('kamar.create') }}" class="btn btn-primary" style="background-color: #28557d; border:none;">
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
                    @foreach($kamars as $kamar)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $kamar->nomor_kamar }}</td>
                        <td>{{ $kamar->tipe }}</td>
                        <td>Rp {{ number_format($kamar->harga, 0, ',', '.') }}</td>
                        <td>
                            <span class="badge {{ $kamar->status == 'Kosong' ? 'bg-success' : 'bg-warning' }}">
                                {{ $kamar->status }}
                            </span>
                        </td>
                        <td class="text-center">
                            <a href="{{ route('kamar.edit', $kamar->id_kamar) }}" class="btn btn-sm btn-info btn-action text-white">
                                <i class="ti ti-pencil"></i>
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
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection