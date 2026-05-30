<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Bersihkan data lama untuk mencegah duplikasi/error
        \App\Models\Pembayaran::query()->delete();
        \App\Models\Penyewa::query()->delete();

        \App\Models\Admin::updateOrCreate(
            ['username' => 'admin'],
            ['password' => \Illuminate\Support\Facades\Hash::make('admin123')]
        );

        $groups = [
            'A1' => 10,
            'A2' => 8,
            'A3' => 10,
            'A4' => 8,
            'A5' => 10,
            'A6' => 8,
        ];

        foreach ($groups as $prefix => $count) {
            for ($i = 1; $i <= $count; $i++) {
                $nomorKamar = sprintf('%s-%02d', $prefix, $i);
                
                // Variasi tipe dan harga kamar berdasarkan prefix untuk realisme
                $tipe = 'Standard';
                $harga = 800000;
                
                if (in_array($prefix, ['A3', 'A4'])) {
                    $tipe = 'Deluxe';
                    $harga = 1200000;
                } elseif (in_array($prefix, ['A5', 'A6'])) {
                    $tipe = 'Suite';
                    $harga = 1800000;
                }

                \App\Models\Kamar::updateOrCreate(
                    ['nomor_kamar' => $nomorKamar],
                    [
                        'tipe' => $tipe,
                        'harga' => $harga,
                        'status' => 'Kosong',
                    ]
                );
            }
        }

        // Seed Penyewa & Pembayaran terkait
        $penyewaData = [
            ['nama' => 'Budi Santoso', 'no_hp' => '081234567890', 'room_number' => 'A1-01', 'bulan' => 'Mei 2026', 'status' => 'Lunas'],
            ['nama' => 'Siti Aisyah', 'no_hp' => '081298765432', 'room_number' => 'A2-02', 'bulan' => 'Mei 2026', 'status' => 'Lunas'],
            ['nama' => 'Rizky Pratama', 'no_hp' => '081355566677', 'room_number' => 'A3-03', 'bulan' => 'Mei 2026', 'status' => 'Belum Lunas'],
            ['nama' => 'Dewi Lestari', 'no_hp' => '081288889999', 'room_number' => 'A4-04', 'bulan' => 'April 2026', 'status' => 'Lunas'],
            ['nama' => 'Adi Wijaya', 'no_hp' => '085711112222', 'room_number' => 'A5-05', 'bulan' => 'Mei 2026', 'status' => 'Lunas'],
            ['nama' => 'Fania Putri', 'no_hp' => '089833334444', 'room_number' => 'A6-06', 'bulan' => 'Mei 2026', 'status' => 'Belum Lunas'],
        ];

        foreach ($penyewaData as $data) {
            $kamar = \App\Models\Kamar::where('nomor_kamar', $data['room_number'])->first();
            if ($kamar) {
                // Buat data penyewa
                $penyewa = \App\Models\Penyewa::create([
                    'nama' => $data['nama'],
                    'no_hp' => $data['no_hp'],
                    'ktp' => 'ktp/dummy.jpg', // dummy path
                    'id_kamar' => $kamar->id_kamar,
                ]);

                // Ubah status kamar menjadi Terisi
                $kamar->update(['status' => 'Terisi']);

                // Buat data pembayaran
                \App\Models\Pembayaran::create([
                    'id_penyewa' => $penyewa->id_penyewa,
                    'id_kamar' => $kamar->id_kamar,
                    'tanggal_bayar' => $data['status'] === 'Lunas' ? '2026-05-02' : '2026-05-15',
                    'jumlah_bayar' => $kamar->harga,
                    'bukti_bayar' => 'bukti_bayar/dummy.jpg',
                    'bulan' => $data['bulan'],
                    'status' => $data['status'] === 'Lunas' ? 'Lunas' : 'Belum Lunas',
                ]);
            }
        }
    }
}
