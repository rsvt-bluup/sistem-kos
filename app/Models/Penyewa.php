<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penyewa extends Model
{
    use HasFactory;

    protected $table = 'penyewas';

    protected $primaryKey = 'id_penyewa';

    protected $fillable = [
        'nama',
        'no_hp',
        'ktp',
        'id_kamar'
    ];

    public function kamar()
    {
        return $this->belongsTo(Kamar::class, 'id_kamar');
    }

    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class, 'id_penyewa');
    }

    public function pembayaranTerakhir()
    {
        return $this->hasOne(Pembayaran::class, 'id_penyewa')
            ->latestOfMany('id_bayar');
    }
}
