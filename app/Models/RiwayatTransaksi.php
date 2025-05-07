<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiwayatTransaksi extends Model
{
    protected $table = 'riwayat_transaksis';
    protected $guarded = [];

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }

}
