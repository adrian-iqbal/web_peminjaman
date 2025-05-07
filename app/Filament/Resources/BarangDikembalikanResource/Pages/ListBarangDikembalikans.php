<?php

namespace App\Filament\Resources\BarangDikembalikanResource\Pages;

use App\Filament\Resources\BarangDikembalikanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBarangDikembalikans extends ListRecords
{
    protected static string $resource = BarangDikembalikanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
