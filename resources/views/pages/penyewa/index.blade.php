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

        <form action="{{ route('penyewa.index') }}" method="GET" class="mb-3">
            <div class="input-group" style="max-width: 420px;">
                <input type="text" name="search" class="form-control" placeholder="Cari nama, no HP, atau kamar..." value="{{ request('search') }}">
                <button class="btn btn-outline-secondary" type="submit">Cari</button>
                @if(request('search'))
                <a href="{{ route('penyewa.index') }}" class="btn btn-light">Reset</a>
                @endif
            </div>
        </form>

        <div class="mb-3 d-flex gap-2">
            <button type="button" class="btn btn-outline-primary btn-sm" onclick="toggleMultiSelect('penyewa')">Pilih Beberapa</button>
            <button id="bulk-delete-btn-penyewa" type="button" class="btn btn-danger btn-sm d-none" onclick="submitBulkDelete('penyewa')">Hapus Terpilih</button>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th class="select-column select-column-penyewa d-none"><input type="checkbox" id="select-all-penyewa" onclick="toggleSelectAll('penyewa', this.checked)"></th>
                        <th>No</th>
                        <th>Nama Penyewa</th>
                        <th>No HP</th>
                        <th>Kamar</th>
                        <th>Bulan</th>
                        <th>Status</th>
                        <th>Dokumen KTP</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($penyewas as $penyewa)
                    <tr>
                        <td class="select-column select-column-penyewa d-none">
                            <input type="checkbox" class="row-checkbox-penyewa" value="{{ $penyewa->id_penyewa }}">
                        </td>
                        <td>{{ $penyewas->firstItem() + $loop->index }}</td>
                        <td class="fw-semibold">{{ $penyewa->nama }}</td>
                        <td>{{ $penyewa->no_hp }}</td>
                        <td>
                            <span class="badge bg-info">
                                {{ $penyewa->kamar->nomor_kamar ?? '-' }}
                            </span>
                        </td>
                        <td>{{ $penyewa->pembayaranTerakhir->bulan ?? '-' }}</td>
                        <td>
                            @if(isset($penyewa->pembayaranTerakhir) && $penyewa->pembayaranTerakhir->status == 'Lunas')
                                <span class="badge bg-success">Lunas</span>
                            @elseif(isset($penyewa->pembayaranTerakhir))
                                <span class="badge bg-warning">{{ $penyewa->pembayaranTerakhir->status ?? 'Belum' }}</span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
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
                        <td colspan="9" class="text-center text-muted py-4">Belum ada data penyewa.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($penyewas->hasPages())
        <div class="mt-3 d-flex justify-content-end">
            {{ $penyewas->links('pagination::bootstrap-5') }}
        </div>
        @endif

        <form id="bulk-delete-form-penyewa" action="{{ route('penyewa.bulkDestroy') }}" method="POST" style="display:none;">
            @csrf
            <input type="hidden" name="ids" id="bulk-ids-penyewa" value="">
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