<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BarangDikembalikan extends Model
{
    protected $table = 'barang_dikembalikans';
    protected $guarded = [];

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }

    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class);
    }
}
