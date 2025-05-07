<?php

namespace App\Filament\Widgets;

use App\Models\Barang;
use App\Models\BarangDikembalikan;
use App\Models\BarangDipinjam;
use App\Models\Peminjaman;
use App\Models\Ruangan;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsDashboard extends BaseWidget
{
    protected function getStats(): array
    {
        $countDatabarang = Barang::count();
        $countRuangan = Ruangan::count();
        $countDipinjam = BarangDipinjam::count();
        $countTersedia = BarangDikembalikan::count();
        return [
            Stat::make('Total Barang', $countDatabarang . ' Barang')
                ->description('Semua barang yang terdaftar')
                ->icon('heroicon-o-archive-box')
                ->color('primary'), 

            Stat::make('Total Ruangan', $countRuangan . ' Ruangan')
                ->description('Jumlah ruangan terdaftar')
                ->icon('heroicon-o-building-office')
                ->color('info'), 

            Stat::make('Barang Dipinjam', $countDipinjam . ' Barang')
                ->description('Barang yang sedang dipinjam')
                ->icon('heroicon-o-arrow-up-on-square')
                ->color('danger'), 

            Stat::make('Barang Tersedia', $countTersedia . ' Barang')
                ->description('Barang yang sudah dikembalikan')
                ->icon('heroicon-o-check-circle')
                ->color('success'), 
        ];
    }
}
