@extends('layouts.app')

@section('title', 'Admin')

@section('content')
<style>
    body {
        background-color: #ffffff;
    }

    .body-wrapper-inner {
        padding-top: 90px !important;
    }

    .container-fluid {
        margin-top: 0 !important;
        padding-top: 0 !important;
    }

    .dashboard-title {
        color: #28557d;
        font-weight: bold;
        margin-bottom: 25px;
    }

    .dashboard-card {
        border: 1px solid rgba(40, 85, 125, 0.15);
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        transition: 0.3s;
        background: #fff;
        height: 100%;
    }

    .dashboard-card:hover {
        transform: translateY(-5px);
    }

    .dashboard-number {
        font-size: 50px;
        font-weight: bold;
        color: #28557d;
    }

    .dashboard-subtitle {
        color: #28557d;
        font-weight: 600;
    }

    .dashboard-text {
        color: #666;
        line-height: 1.8;
    }

    .admin-icon {
        font-size: 65px;
        color: #28557d;
    }

    .admin-name {
        font-weight: bold;
        color: #28557d;
    }

    .dashboard-card .card-body {
        padding: 28px;
    }
</style>

<div class="container-fluid dashboard-content">

    <div class="mb-3">
        <h2 class="dashboard-title">Dashboard Admin</h2>
    </div>
    <div class="row">

        <div class="col-md-8 mb-4">
            <div class="card dashboard-card">
                <div class="card-body d-flex flex-column justify-content-center" style="min-height: 160px;">

                    <h5 class="fw-bold mb-3 dashboard-title">
                        Informasi Kos
                    </h5>
                    <p class="dashboard-text mb-2">
                        Selamat Datang di Dashboard Sistem Pengelolaan Data Kos.
                    </p>
                    <p class="dashboard-text mb-0">
                        Kelola data kamar, penyewa, dan pembayaran dengan mudah dan cepat.
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card dashboard-card">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="ti ti-user-circle admin-icon"></i>
                    </div>
                    <h5 class="admin-name">{{ session('admin') }}</h5>
                    <p class="text-muted mb-0">Administrator</p>
                </div>
            </div>
        </div>

    </div>

    <div class="row">

        <div class="col-md-3 mb-4">
            <div class="card dashboard-card h-100">
                <div class="card-body">
                    <h6 class="dashboard-subtitle">
                        Total Kamar
                    </h6>
                    <h1 class="dashboard-number">
                        20
                    </h1>
                    <p class="text-muted mt-3 mb-0">
                        Semua data kamar kos
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card dashboard-card h-100">
                <div class="card-body">
                    <h6 class="dashboard-subtitle">
                        Total Penyewa
                    </h6>
                    <h1 class="dashboard-number">
                        15
                    </h1>
                    <p class="text-muted mt-3 mb-0">
                        Penyewa aktif saat ini
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card dashboard-card h-100">
                <div class="card-body">
                    <h6 class="dashboard-subtitle">
                        Sudah Bayar
                    </h6>
                    <h1 class="dashboard-number">
                        12
                    </h1>
                    <p class="text-muted mt-3 mb-0">
                        Pembayaran berhasil
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card dashboard-card h-100">
                <div class="card-body">
                    <h6 class="dashboard-subtitle">
                        Belum Bayar
                    </h6>
                    <h1 class="dashboard-number">
                        3
                    </h1>
                    <p class="text-muted mt-3 mb-0">
                        Menunggu pembayaran
                    </p>
                </div>
            </div>
        </div>

    </div>

</div>

@endsection