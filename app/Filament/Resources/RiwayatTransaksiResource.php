<?php

namespace App\Filament\Resources;

use Carbon\Carbon;
use Filament\Forms;
use Filament\Tables;
use App\Models\RiwayatTransaksi;
use Filament\Resources\Resource;
use App\Filament\Resources\RiwayatTransaksiResource\Pages;

class RiwayatTransaksiResource extends Resource
{
    protected static ?string $model = RiwayatTransaksi::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationLabel = 'Riwayat Transaksi';
    protected static ?string $navigationGroup = 'Manajemen Barang';
    protected static ?int $navigationSort = 4;

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('barang.nama_barang')->label('Nama Barang'),
                Tables\Columns\TextColumn::make('nama_user')->label('Penanggung Jawab'),
                Tables\Columns\TextColumn::make('jenis_transaksi')
                    ->badge()
                    ->color(fn($state) => $state === 'Dipinjam' ? 'warning' : 'success')
                    ->label('Jenis Transaksi'),
                Tables\Columns\TextColumn::make('tanggal_transaksi')->date('d M Y')->label('Tanggal Transaksi'),
                Tables\Columns\TextColumn::make('tanggal_dikembalikan')
                    ->label('Tanggal Dikembalikan')
                    ->formatStateUsing(function ($state, $record) {
                        return $record->jenis_transaksi === 'Dikembalikan' && $state
                            ? Carbon::parse($state)->format('d M Y')
                            : null;
                    })

            ])
            ->filters([
                Tables\Filters\Filter::make('Dipinjam')
                    ->query(fn($query) => $query->where('jenis_transaksi', 'Dipinjam')),
                Tables\Filters\Filter::make('Dikembalikan')
                    ->query(fn($query) => $query->where('jenis_transaksi', 'Dikembalikan')),
            ])
            ->recordUrl(null)
            ->striped()
            ->actions([
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRiwayatTransaksis::route('/'),
            'create' => Pages\CreateRiwayatTransaksi::route('/create'),
            'edit' => Pages\EditRiwayatTransaksi::route('/{record}/edit'),
        ];
    }
}
