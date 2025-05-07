<?php

namespace App\Filament\Resources\BarangDikembalikanResource\Pages;

use Filament\Actions;
use App\Models\Barang;
use App\Models\BarangDipinjam;
use App\Models\RiwayatTransaksi;
use Illuminate\Support\Facades\Auth;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;
use App\Filament\Resources\BarangDikembalikanResource;

class CreateBarangDikembalikan extends CreateRecord
{
    protected static string $resource = BarangDikembalikanResource::class;

    protected function afterCreate(): void
    {
        RiwayatTransaksi::create([
            'barang_id' => $this->record->barang_id,
            'nama_user' => Auth::user()->name, // ⬅️ FIXED
            'jenis_transaksi' => 'Dikembalikan',
            'tanggal_transaksi' => now(),
            'tanggal_dikembalikan' => $this->record->tanggal_dikembalikan,
        ]);
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index'); // ⬅️ Redirect ke halaman table
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $barangDipinjam = BarangDipinjam::where('barang_id', $data['barang_id'])->first();

        if (!$barangDipinjam) {
            // Jika barang tidak ditemukan di daftar barang yang dipinjam
            Notification::make()
                ->title('Barang tidak ditemukan')
                ->body('Barang ini tidak ada dalam daftar barang yang dipinjam.')
                ->danger()
                ->send();

            $this->halt(); // Menghentikan proses pembuatan data
        }

        // Jika barang ditemukan, update status menjadi Tersedia
        Barang::where('id', $data['barang_id'])->update(['status' => 'Tersedia']);
        BarangDipinjam::where('barang_id', $data['barang_id'])->delete();

        return $data;

        RiwayatTransaksi::create([
            'barang_id' => $data['barang_id'],
            'nama_user' => Auth::user()->name,
            'jenis_transaksi' => 'Dikembalikan',
            'tanggal_transaksi' => now(),
        ]);
    }
}
