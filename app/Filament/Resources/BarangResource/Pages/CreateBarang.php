<?php

namespace App\Filament\Resources\BarangResource\Pages;

use App\Filament\Resources\BarangResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateBarang extends CreateRecord
{
    protected static string $resource = BarangResource::class;

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Barang Berhasil Ditambahkan';
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index'); // ⬅️ Redirect ke halaman table
    }
}
