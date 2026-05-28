@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')

<style>
    .page-title {
        font-weight: 700;
        color: #28557d;
        margin-bottom: 18px;
    }

    .payment-card {
        border: 1px solid #e5e7eb;
        border-radius: 14px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }

    .table-custom {
        border-collapse: separate;
        border-spacing: 0;
    }

    .table-custom thead th {
        background: #28557d;
        color: #fff;
        font-weight: 600;
        font-size: 14px;
        border: none;
        padding: 14px;
    }

    .table-custom tbody td {
        border-bottom: 1px solid #e5e7eb;
        padding: 14px;
        font-size: 14px;
        color: #333;
    }

    .table-custom tbody tr:hover {
        background: #f5f9ff;
        transition: 0.2s;
    }

    .badge {
        padding: 6px 10px;
        border-radius: 8px;
        font-size: 12px;
    }
</style>

<div class="container-fluid">

    <h3 class="page-title">Data Pembayaran</h3>

    <div class="card payment-card">
        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-custom mb-0">

                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Penyewa</th>
                            <th>Kamar</th>
                            <th>Bulan</th>
                            <th>Jumlah</th>
                            <th>Status</th>
                            <th>Tanggal Bayar</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Budi Santoso</td>
                            <td>A1</td>
                            <td>Jan 2026</td>
                            <td>750.000</td>
                            <td><span class="badge bg-success">Lunas</span></td>
                            <td>05-01-2026</td>
                        </tr>

                        <tr>
                            <td>2</td>
                            <td>Siti Aisyah</td>
                            <td>B2</td>
                            <td>Jan 2026</td>
                            <td>800.000</td>
                            <td><span class="badge bg-warning text-dark">Pending</span></td>
                            <td>-</td>
                        </tr>

                        <tr>
                            <td>3</td>
                            <td>Rizky Pratama</td>
                            <td>C3</td>
                            <td>Des 2025</td>
                            <td>700.000</td>
                            <td><span class="badge bg-success">Lunas</span></td>
                            <td>28-12-2025</td>
                        </tr>
                    </tbody>

                </table>

            </div>

        </div>
    </div>

</div>

@endsection