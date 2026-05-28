<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;

    protected $table = 'pembayarans';

    protected $primaryKey = 'id_bayar';

    protected $fillable = [
        'id_penyewa',
        'id_kamar',
        'tanggal_bayar',
        'jumlah_bayar',
        'bukti_bayar',
        'bulan',
        'status'
    ];

    public function penyewa()
    {
        return $this->belongsTo(Penyewa::class, 'id_penyewa');
    }

    public function kamar()
    {
        return $this->belongsTo(Kamar::class, 'id_kamar');
    }
}