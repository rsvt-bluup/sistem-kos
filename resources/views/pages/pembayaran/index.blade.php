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

        <form action="{{ route('pembayaran.index') }}" method="GET" class="mb-3">
            <div class="input-group" style="max-width: 420px;">
                <input type="text" name="search" class="form-control" placeholder="Cari penyewa, kamar, bulan, atau status..." value="{{ request('search') }}">
                <button class="btn btn-outline-secondary" type="submit">Cari</button>
                @if(request('search'))
                <a href="{{ route('pembayaran.index') }}" class="btn btn-light">Reset</a>
                @endif
            </div>
        </form>

        <div class="mb-3 d-flex gap-2">
            <button type="button" class="btn btn-outline-primary btn-sm" onclick="toggleMultiSelect('pembayaran')">Pilih Beberapa</button>
            <button id="bulk-delete-btn-pembayaran" type="button" class="btn btn-danger btn-sm d-none" onclick="submitBulkDelete('pembayaran')">Hapus Terpilih</button>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th class="select-column select-column-pembayaran d-none"><input type="checkbox" id="select-all-pembayaran" onclick="toggleSelectAll('pembayaran', this.checked)"></th>
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
                        <td class="select-column select-column-pembayaran d-none">
                            <input type="checkbox" class="row-checkbox-pembayaran" value="{{ $pembayaran->id_bayar }}">
                        </td>
                        <td>{{ $pembayarans->firstItem() + $loop->index }}</td>
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
                                <button type="button" 
                                    class="btn btn-sm btn-outline-primary py-1 px-2 d-inline-flex align-items-center gap-1 btn-view-bukti"
                                    data-id="{{ $pembayaran->id_bayar }}"
                                    data-penyewa="{{ $pembayaran->penyewa->nama ?? '-' }}"
                                    data-kamar="{{ $pembayaran->kamar->nomor_kamar ?? '-' }}"
                                    data-tipe="{{ $pembayaran->kamar->tipe ?? '-' }}"
                                    data-bulan="{{ $pembayaran->bulan }}"
                                    data-jumlah="{{ $pembayaran->jumlah_bayar }}"
                                    data-tanggal="{{ \Carbon\Carbon::parse($pembayaran->tanggal_bayar)->format('d-m-Y') }}"
                                    data-status="{{ $pembayaran->status }}"
                                    data-bukti="{{ asset('storage/' . $pembayaran->bukti_bayar) }}">
                                    <i class="ti ti-file-text fs-5"></i> Bukti
                                </button>
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
                        <td colspan="10" class="text-center text-muted py-4">Belum ada data pembayaran.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($pembayarans->hasPages())
        <div class="mt-3 d-flex justify-content-end">
            {{ $pembayarans->links('pagination::bootstrap-5') }}
        </div>
        @endif

        <form id="bulk-delete-form-pembayaran" action="{{ route('pembayaran.bulkDestroy') }}" method="POST" style="display:none;">
            @csrf
            <input type="hidden" name="ids" id="bulk-ids-pembayaran" value="">
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

<!-- Modal Detail Bukti & Struk -->
<div id="buktiModal" class="modal-backdrop-blur d-none">
    <div class="modal-card" style="max-width: 750px; width: 95%;">
        <div class="modal-card-header" style="padding: 16px 20px;">
            <h5 class="modal-card-title d-flex align-items-center gap-2" style="font-size: 16px;">
                <i class="ti ti-receipt fs-5 text-primary"></i>
                <span>Detail Transaksi & Bukti Pembayaran</span>
            </h5>
            <a href="javascript:void(0)" class="modal-close-btn" onclick="closeBuktiModal()"><i class="ti ti-x"></i></a>
        </div>
        <div class="modal-card-body p-3">
            <div class="row g-3">
                <!-- Sisi Kiri: Struk Pembayaran -->
                <div class="col-md-6 border-end pe-md-3">
                    <div class="receipt-paper shadow-sm p-3 rounded-3 position-relative overflow-hidden mb-2 mb-md-0 bg-white" id="print-receipt-area" style="border: 1px solid #e2e8f0; font-family: 'Courier New', Courier, monospace;">
                        <div class="receipt-header text-center mb-3">
                            <h5 class="fw-bold mb-1 text-uppercase text-dark" style="letter-spacing: 0.5px; font-size: 14px;">KOSKU RESIDENCE</h5>
                            <p class="text-muted small mb-1" style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: 9.5px; line-height: 1.3;">Perumahan Araya Residence Blok KR 30, Kecamatan Blimbing, Kota Malang</p>
                            <p class="text-muted small mb-0" style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: 9.5px;">Telp: 0812-3456-7890</p>
                            <div class="my-2" style="border-top: 1px dashed #cbd5e1;"></div>
                            <h6 class="fw-bold mb-1 text-dark" style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12px; letter-spacing: 0.5px;">STRUK PEMBAYARAN</h6>
                            <p class="text-muted small mb-0" id="receipt-invoice-id" style="font-size: 11px;">#INV-PAY-0000</p>
                        </div>
                        
                        <div class="receipt-details small mb-3 text-dark" style="line-height: 1.4; font-size: 12px;">
                            <div class="d-flex justify-content-between mb-1">
                                <span>Tanggal:</span>
                                <span id="receipt-date" class="fw-semibold">30-05-2026</span>
                            </div>
                            <div class="d-flex justify-content-between mb-1">
                                <span>Penyewa:</span>
                                <span id="receipt-tenant" class="fw-semibold">Budi Santoso</span>
                            </div>
                            <div class="d-flex justify-content-between mb-1">
                                <span>No. Kamar:</span>
                                <span id="receipt-room" class="fw-semibold">A1-01</span>
                            </div>
                            <div class="d-flex justify-content-between mb-1">
                                <span>Tipe Kamar:</span>
                                <span id="receipt-room-type" class="fw-semibold">Standard</span>
                            </div>
                            <div class="d-flex justify-content-between mb-1">
                                <span>Periode Bulan:</span>
                                <span id="receipt-month" class="fw-semibold">Mei 2026</span>
                            </div>
                            <div class="my-2" style="border-top: 1px dashed #cbd5e1;"></div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span>Status:</span>
                                <span id="receipt-status" class="badge bg-success" style="font-size: 9.5px; padding: 4px 8px !important;">Lunas</span>
                            </div>
                            <div class="my-2" style="border-top: 1px dashed #cbd5e1;"></div>
                            <div class="d-flex justify-content-between align-items-baseline mt-1">
                                <span class="fs-6 fw-bold" style="font-size: 13px !important;">TOTAL BAYAR:</span>
                                <span class="fw-bold text-primary" id="receipt-amount" style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: 16px;">Rp 0</span>
                            </div>
                        </div>
                        
                        <div class="receipt-footer text-center mt-3">
                            <p class="text-muted mb-2" style="font-family: 'Plus Jakarta Sans', sans-serif; font-style: italic; font-size: 10px; line-height: 1.3;">Terima kasih atas pembayaran Anda.<br>Simpan struk ini sebagai bukti pembayaran yang sah.</p>
                            
                            <div class="barcode-container d-inline-flex flex-column align-items-center bg-light p-1.5 rounded">
                                <div class="barcode-lines" style="height: 25px; width: 120px; background: repeating-linear-gradient(90deg, #334155, #334155 2px, transparent 2px, transparent 5px, #334155 5px, #334155 8px, transparent 8px, transparent 10px);"></div>
                                <span class="text-muted mt-1" style="font-size: 7.5px; letter-spacing: 2px; font-family: monospace;">*KOSKU-PAY-0000*</span>
                            </div>
                        </div>
                        
                        <div id="receipt-stamp" class="paid-stamp">LUNAS</div>
                    </div>
                    <div class="text-center mt-2 no-print">
                        <button type="button" class="btn btn-sm btn-primary d-inline-flex align-items-center gap-2 py-1 px-3" onclick="printReceipt()">
                            <i class="ti ti-printer"></i> Cetak Struk
                        </button>
                    </div>
                </div>
                
                <!-- Sisi Kanan: Foto Bukti Transaksi -->
                <div class="col-md-6 ps-md-3 d-flex flex-column justify-content-between">
                    <div class="text-center mb-2">
                        <h6 class="fw-semibold text-start text-dark mb-2" style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px;">Foto Bukti Pembayaran</h6>
                        <div class="bukti-img-container d-flex align-items-center justify-content-center border rounded-3 p-1 bg-light" style="min-height: 200px; max-height: 250px; overflow: hidden; border-style: dashed !important;">
                            <img id="bukti-image-preview" src="" alt="Bukti Pembayaran" class="img-fluid rounded" style="max-height: 230px; object-fit: contain; cursor: zoom-in;" onclick="window.open(this.src, '_blank')">
                        </div>
                    </div>
                    <div class="d-flex justify-content-end gap-2 no-print mt-2">
                        <a id="download-bukti-btn" href="" download class="btn btn-sm btn-outline-primary d-inline-flex align-items-center gap-2 py-1 px-3">
                            <i class="ti ti-download"></i> Unduh Bukti
                        </a>
                        <button type="button" class="btn btn-sm btn-light-custom py-1 px-3" onclick="closeBuktiModal()">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .receipt-paper {
        border-radius: 12px;
        position: relative;
        background-color: #fff;
    }
    
    .paid-stamp {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%) rotate(-15deg);
        border: 3px double #15803d;
        color: #15803d;
        font-size: 20px;
        font-weight: 800;
        padding: 2px 10px;
        border-radius: 6px;
        opacity: 0.15;
        letter-spacing: 3px;
        text-transform: uppercase;
        pointer-events: none;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }
    
    .unpaid-stamp {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%) rotate(-15deg);
        border: 3px double #b45309;
        color: #b45309;
        font-size: 16px;
        font-weight: 800;
        padding: 2px 8px;
        border-radius: 6px;
        opacity: 0.15;
        letter-spacing: 2px;
        text-transform: uppercase;
        pointer-events: none;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    @media print {
        body * {
            visibility: hidden;
        }
        #print-receipt-area, #print-receipt-area * {
            visibility: visible;
        }
        #print-receipt-area {
            position: fixed;
            left: 50%;
            top: 5%;
            transform: translateX(-50%);
            width: 80mm;
            border: none !important;
            box-shadow: none !important;
            padding: 0 !important;
            margin: 0 !important;
            background: white !important;
            color: black !important;
        }
        .paid-stamp, .unpaid-stamp {
            opacity: 0.25 !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
        .no-print {
            display: none !important;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const viewButtons = document.querySelectorAll('.btn-view-bukti');
        const modal = document.getElementById('buktiModal');
        
        viewButtons.forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const penyewa = this.getAttribute('data-penyewa');
                const kamar = this.getAttribute('data-kamar');
                const tipe = this.getAttribute('data-tipe');
                const bulan = this.getAttribute('data-bulan');
                const jumlah = parseFloat(this.getAttribute('data-jumlah'));
                const tanggal = this.getAttribute('data-tanggal');
                const status = this.getAttribute('data-status');
                const bukti = this.getAttribute('data-bukti');
                
                const formattedJumlah = new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    minimumFractionDigits: 0
                }).format(jumlah);
                
                document.getElementById('receipt-invoice-id').innerText = '#INV-PAY-' + String(id).padStart(4, '0');
                document.getElementById('receipt-date').innerText = tanggal;
                document.getElementById('receipt-tenant').innerText = penyewa;
                document.getElementById('receipt-room').innerText = kamar;
                document.getElementById('receipt-room-type').innerText = tipe;
                document.getElementById('receipt-month').innerText = bulan;
                document.getElementById('receipt-amount').innerText = formattedJumlah;
                
                const statusBadge = document.getElementById('receipt-status');
                const stamp = document.getElementById('receipt-stamp');
                
                if (status === 'Lunas') {
                    statusBadge.innerText = 'Lunas';
                    statusBadge.className = 'badge bg-success';
                    stamp.innerText = 'LUNAS';
                    stamp.className = 'paid-stamp';
                } else {
                    statusBadge.innerText = 'Belum Lunas';
                    statusBadge.className = 'badge bg-warning';
                    stamp.innerText = 'BELUM LUNAS';
                    stamp.className = 'unpaid-stamp';
                }
                
                const barcodeLabel = modal.querySelector('.barcode-container span');
                if (barcodeLabel) {
                    barcodeLabel.innerText = '*KOSKU-PAY-' + String(id).padStart(4, '0') + '*';
                }
                
                const imagePreview = document.getElementById('bukti-image-preview');
                const downloadBtn = document.getElementById('download-bukti-btn');
                
                if (bukti) {
                    imagePreview.src = bukti;
                    downloadBtn.href = bukti;
                    downloadBtn.classList.remove('disabled');
                } else {
                    imagePreview.src = '';
                    downloadBtn.href = '#';
                    downloadBtn.classList.add('disabled');
                }
                
                modal.classList.remove('d-none');
            });
        });
    });
    
    // Klik di luar modal untuk menutup
    document.getElementById('buktiModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeBuktiModal();
        }
    });
    
    function closeBuktiModal() {
        document.getElementById('buktiModal').classList.add('d-none');
    }
    
    function printReceipt() {
        window.print();
    }
</script>

@endsection