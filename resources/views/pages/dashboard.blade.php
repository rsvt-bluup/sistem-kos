@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<style>
    .welcome-card {
        background: linear-gradient(135deg, rgba(40, 85, 125, 0.04) 0%, rgba(40, 85, 125, 0.08) 100%) !important;
        border: 1px solid rgba(40, 85, 125, 0.1) !important;
    }

    .icon-shape {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 14px;
        font-size: 20px;
    }

    .icon-shape-primary { background-color: #e0f2fe; color: #0369a1; }
    .icon-shape-success { background-color: #dcfce7; color: #15803d; }
    .icon-shape-info { background-color: #e0f7fa; color: #00838f; }
    .icon-shape-warning { background-color: #fee2e2; color: #b91c1c; }

    .stat-title {
        font-size: 14px;
        font-weight: 600;
        color: #64748b;
    }

    .stat-number {
        font-size: 32px;
        font-weight: 700;
        color: #1e3a5f;
    }
</style>

<div class="container-fluid">

    <div class="mb-4">
        <h2 class="page-title">Selamat Datang, {{ session('admin') }}</h2>
        <p class="text-muted m-0">Berikut adalah ringkasan pengelolaan kos Anda hari ini.</p>
    </div>

    <div class="row mb-4">

        <div class="col-md-8 mb-4 mb-md-0">
            <div class="card welcome-card h-100">
                <div class="card-body d-flex flex-column justify-content-center p-4">
                    <h5 class="fw-bold mb-3" style="color: #28557d;">
                        Sistem Pengelolaan Kos
                    </h5>
                    <p class="text-muted mb-2 leading-relaxed">
                        Aplikasi <strong>KosKu</strong> dirancang untuk membantu Anda memantau status kamar, mencatat data penyewa, serta memverifikasi transaksi pembayaran kos secara terorganisir.
                    </p>
                    <p class="text-muted mb-0 small">
                        Gunakan menu navigasi di sebelah kiri untuk mulai mengelola database.
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body text-center p-4">
                    <div class="mb-3 d-inline-flex align-items-center justify-content-center bg-light rounded-circle" style="width: 70px; height: 70px;">
                        <i class="ti ti-user-circle text-primary" style="font-size: 44px;"></i>
                    </div>
                    <h5 class="fw-bold mb-1" style="color: #1e3a5f;">{{ session('admin') }}</h5>
                    <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-1" style="border-radius: 20px; font-size: 11px;">Administrator Aktif</span>
                </div>
            </div>
        </div>

    </div>

    <div class="row">

        <div class="col-md-3 mb-4">
            <div class="card dashboard-card">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="stat-title">Total Kamar</span>
                        <div class="icon-shape icon-shape-primary">
                            <i class="ti ti-door"></i>
                        </div>
                    </div>
                    <h3 class="stat-number mb-1">{{ $totalKamar }}</h3>
                    <p class="text-muted small mb-0">Unit kamar terdaftar</p>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card dashboard-card">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="stat-title">Total Penyewa</span>
                        <div class="icon-shape icon-shape-success">
                            <i class="ti ti-users"></i>
                        </div>
                    </div>
                    <h3 class="stat-number mb-1">{{ $totalPenyewa }}</h3>
                    <p class="text-muted small mb-0">Penyewa terdaftar</p>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card dashboard-card">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="stat-title">Sudah Bayar</span>
                        <div class="icon-shape icon-shape-info">
                            <i class="ti ti-circle-check"></i>
                        </div>
                    </div>
                    <h3 class="stat-number mb-1" style="color: #00838f;">{{ $sudahBayar }}</h3>
                    <p class="text-muted small mb-0">Pembayaran bulan ini lunas</p>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card dashboard-card">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="stat-title">Belum Bayar</span>
                        <div class="icon-shape icon-shape-warning">
                            <i class="ti ti-alert-circle"></i>
                        </div>
                    </div>
                    <h3 class="stat-number mb-1" style="color: #b91c1c;">{{ $belumBayar }}</h3>
                    <p class="text-muted small mb-0">Menunggu pembayaran</p>
                </div>
            </div>
        </div>

    </div>

</div>
@endsection