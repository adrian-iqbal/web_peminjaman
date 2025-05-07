<?php

namespace App\Filament\Resources\BarangDipinjamResource\Pages;

use App\Filament\Resources\BarangDipinjamResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBarangDipinjams extends ListRecords
{
    protected static string $resource = BarangDipinjamResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
