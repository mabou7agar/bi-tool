<?php

namespace App\Filament\Resources\HotelStayRateResource\Pages;

use App\Filament\Resources\HotelStayRateResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListHotelStayRates extends ListRecords
{
    protected static string $resource = HotelStayRateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
