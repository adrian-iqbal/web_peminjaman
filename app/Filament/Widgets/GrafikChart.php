<?php

namespace App\Filament\Widgets;

use App\Models\BarangDipinjam;
use App\Models\BarangDikembalikan;
use Filament\Widgets\ChartWidget;

class GrafikChart extends ChartWidget
{
    protected static ?string $heading = 'Grafik Barang Dipinjam dan Tersedia';

    protected static ?int $sort = 3;

    protected function getData(): array
    {
        $dipinjam = BarangDipinjam::count();
        $dikembalikan = BarangDikembalikan::count();

        return [
            'datasets' => [
                [
                    'label' => 'Barang Dipinjam',
                    'data' => [$dipinjam],
                    'borderColor' => '#f59e0b',
                    'backgroundColor' => '#fcd34d',
                ],
                [
                    'label' => 'Barang Dikembalikan',
                    'data' => [$dikembalikan],
                    'borderColor' => '#10b981',
                    'backgroundColor' => '#6ee7b7',
                ],
            ],
            'labels' => ['Transaksi Barang'],
        ];
    }

    public function getDescription(): ?string
    {
        return 'Ringkasan Barang Dipinjam dan Tersedia';
    }

    protected function getType(): string
    {
        return 'bar'; // bisa diganti jadi 'line', 'pie', dll
    }
}
