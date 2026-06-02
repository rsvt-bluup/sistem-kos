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

        <form action="{{ route('kamar.index') }}" method="GET" class="mb-3">
            <div class="input-group" style="max-width: 420px;">
                <input type="text" name="search" class="form-control" placeholder="Cari nomor kamar, tipe, atau status..." value="{{ request('search') }}">
                <button class="btn btn-outline-secondary" type="submit">Cari</button>
                @if(request('search'))
                <a href="{{ route('kamar.index') }}" class="btn btn-light">Reset</a>
                @endif
            </div>
        </form>

        <div class="mb-3 d-flex gap-2">
            <button type="button" class="btn btn-outline-primary btn-sm" onclick="toggleMultiSelect('kamar')">Pilih Beberapa</button>
            <button id="bulk-delete-btn-kamar" type="button" class="btn btn-danger btn-sm d-none" onclick="submitBulkDelete('kamar')">Hapus Terpilih</button>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th class="select-column select-column-kamar d-none"><input type="checkbox" id="select-all-kamar" onclick="toggleSelectAll('kamar', this.checked)"></th>
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
                        <td class="select-column select-column-kamar d-none">
                            <input type="checkbox" class="row-checkbox-kamar" value="{{ $kamar->id_kamar }}">
                        </td>
                        <td>{{ $kamars->firstItem() + $loop->index }}</td>
                        <td class="fw-semibold">{{ $kamar->nomor_kamar }}</td>
                        <td>{{ $kamar->tipe }}</td>
                        <td class="fw-semibold">Rp {{ number_format($kamar->harga, 0, ',', '.') }}</td>
                        <td>
                            <span class="badge {{ $kamar->status == 'Kosong' ? 'bg-warning' : 'bg-success' }}">
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
                        <td colspan="7" class="text-center text-muted py-4">Belum ada data kamar.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($kamars->hasPages())
        <div class="mt-3 d-flex justify-content-end">
            {{ $kamars->links('pagination::bootstrap-5') }}
        </div>
        @endif

        <form id="bulk-delete-form-kamar" action="{{ route('kamar.bulkDestroy') }}" method="POST" style="display:none;">
            @csrf
            <input type="hidden" name="ids" id="bulk-ids-kamar" value="">
        </form>

        <script>
            function toggleMultiSelect(resource) {
                const show = document.getElementById('bulk-delete-btn-' + resource).classList.toggle('d-none') === false;
                document.querySelectorAll('.select-column-' + resource).forEach(el => {
                    el.classList.toggle('d-none', !show);
                });
                if (!show) {
                    document.querySelectorAll('.row-checkbox-' + resource).forEach(cb => cb.checked = false);
                    document.getElementById('select-all-' + resource).checked = false;
                }
            }

            function toggleSelectAll(resource, checked) {
                document.querySelectorAll('.row-checkbox-' + resource).forEach(cb => cb.checked = checked);
            }

            function submitBulkDelete(resource) {
                const checkboxes = document.querySelectorAll('.row-checkbox-' + resource + ':checked');
                if (checkboxes.length === 0) {
                    alert('Pilih minimal satu data.');
                    return;
                }

                if (!confirm('Yakin ingin menghapus data terpilih?')) return;

                const ids = Array.from(checkboxes).map(cb => cb.value);
                document.getElementById('bulk-ids-' + resource).value = ids.join(',');
                document.getElementById('bulk-delete-form-' + resource).submit();
            }
        </script>
    </div>
</div>

@endsection