@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<style>
    .page-title {
        font-weight: 700;
        color: #28557d;
        margin-bottom: 18px;
    }

    .card-custom {
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
        padding: 14px;
        border: none;
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

    <h3 class="page-title">Data Penyewa</h3>

    <div class="card card-custom">
        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-custom mb-0">

                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>No KTP</th>
                            <th>No HP</th>
                            <th>Kamar</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Budi Santoso</td>
                            <td>3578123456780001</td>
                            <td>081234567890</td>
                            <td>A1</td>
                            <td><span class="badge bg-success">Aktif</span></td>
                        </tr>

                        <tr>
                            <td>2</td>
                            <td>Siti Aisyah</td>
                            <td>3578123456780002</td>
                            <td>081298765432</td>
                            <td>B2</td>
                            <td><span class="badge bg-success">Aktif</span></td>
                        </tr>

                        <tr>
                            <td>3</td>
                            <td>Rizky Pratama</td>
                            <td>3578123456780003</td>
                            <td>081355566677</td>
                            <td>C3</td>
                            <td><span class="badge bg-danger">Keluar</span></td>
                        </tr>
                    </tbody>

                </table>

            </div>

        </div>
    </div>

</div>

@endsection