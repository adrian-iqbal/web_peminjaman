<?php

namespace App\Filament\Resources\RuanganResource\Pages;

use App\Filament\Resources\RuanganResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateRuangan extends CreateRecord
{
    protected static string $resource = RuanganResource::class;

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Ruangan Berhasil Ditambahkan';
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index'); // ⬅️ Redirect ke halaman table
    }
}
