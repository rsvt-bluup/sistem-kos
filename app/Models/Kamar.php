<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kamar extends Model
{
    use HasFactory;

    protected $table = 'kamars';

    protected $primaryKey = 'id_kamar';

    protected $fillable = [
        'nomor_kamar',
        'tipe',
        'harga',
        'status'
    ];

    public function penyewa()
    {
        return $this->hasMany(Penyewa::class, 'id_kamar');
    }
}
