<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ruangan extends Model
{
    protected $table = 'ruangans';
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
