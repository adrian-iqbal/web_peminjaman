<?php

namespace App\Filament\Resources\BarangDikembalikanResource\Pages;

use App\Filament\Resources\BarangDikembalikanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBarangDikembalikan extends EditRecord
{
    protected static string $resource = BarangDikembalikanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
