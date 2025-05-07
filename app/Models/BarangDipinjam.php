<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BarangDipinjam extends Model
{
    protected $table = 'barang_dipinjams';
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
