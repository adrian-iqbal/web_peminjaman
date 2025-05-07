<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Barang extends Model
{
    protected $table = 'barangs';
    protected $guarded = [];

    public function barangDipinjam()
    {
        return $this->hasMany(BarangDipinjam::class);
    }

    public function barangDikembalikan()
    {
        return $this->hasMany(BarangDikembalikan::class);
    }
}
