<?php

namespace App\Filament\Resources\BarangDipinjamResource\Pages;

use App\Models\Barang;
use App\Models\BarangDipinjam;
use App\Models\RiwayatTransaksi;
use App\Models\BarangDikembalikan;
use Illuminate\Support\Facades\Auth;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\BarangDipinjamResource;


class CreateBarangDipinjam extends CreateRecord
{
    protected static string $resource = BarangDipinjamResource::class;

    protected function afterCreate(): void
    {
        RiwayatTransaksi::create([
            'barang_id' => $this->record->barang_id,
            'nama_user' => Auth::user()->name, // ✅ ganti ini sesuai kebutuhan
            'jenis_transaksi' => 'Dipinjam',
            'tanggal_transaksi' => now(),
        ]);
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index'); // ⬅️ Redirect ke halaman table
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $barang = Barang::find($data['barang_id']);

        $barangDikembalikan = BarangDikembalikan::where('barang_id', $data['barang_id'])->first();

        if ($barangDikembalikan) {
            // Jika barang sudah dikembalikan, hapus data pengembalian sebelumnya
            $barangDikembalikan->delete();
        }

        // Cek apakah barang sedang dipinjam
        $barangDipinjam = BarangDipinjam::where('barang_id', $data['barang_id'])->first();

        if ($barang->status === 'Dipinjam') {
            Notification::make()
                ->title('Barang sedang dipinjam')
                ->body('Barang ini masih dipinjam dan belum dikembalikan.')
                ->danger()
                ->send();

            $this->halt();
        }

        // Update status jadi Dipinjam
        $barang->update(['status' => 'Dipinjam']);

        // Tambahkan riwayat transaksi
        // RiwayatTransaksi::create([
        //     'barang_id' => $data['barang_id'],
        //     'nama_user' => Auth::user()->name,
        //     'jenis_transaksi' => 'Dipinjam',
        //     'tanggal_transaksi' => now(),
        // ]);

        return $data;
    }
}
