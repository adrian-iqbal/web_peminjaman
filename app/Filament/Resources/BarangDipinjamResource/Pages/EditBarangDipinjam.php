<?php

namespace App\Filament\Resources\BarangDipinjamResource\Pages;

use App\Filament\Resources\BarangDipinjamResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBarangDipinjam extends EditRecord
{
    protected static string $resource = BarangDipinjamResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
