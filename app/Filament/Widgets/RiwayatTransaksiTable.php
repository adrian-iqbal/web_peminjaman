<?php

namespace App\Filament\Widgets;

use App\Models\RiwayatTransaksi;
use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Tables;
use Filament\Tables\Table;

class RiwayatTransaksiTable extends BaseWidget
{
    protected static ?string $heading = 'Riwayat Transaksi Terbaru';

    protected static ?int $sort = 3;

    protected int | string | array $columnSpan = '1/2';


    public function table(Table $table): Table
    {
        return $table
            ->query(
                RiwayatTransaksi::latest()->limit(5) // ambil 5 transaksi terakhir
            )
            ->columns([
                Tables\Columns\TextColumn::make('barang.nama_barang')->label('Nama Barang'),
                Tables\Columns\TextColumn::make('nama_user')->label('Penanggung Jawab'),
                Tables\Columns\TextColumn::make('jenis_transaksi')
                    ->badge()
                    ->color(fn ($state) => $state === 'Dipinjam' ? 'warning' : 'success')
                    ->label('Jenis Transaksi'),
                Tables\Columns\TextColumn::make('tanggal_transaksi')->date('d M Y')->label('Tanggal Transaksi'),
            ]);
    }
}
