<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HotelStayRateResource\Pages;
use App\Models\HotelStayRatesHistory;
use App\Services\HotelsService;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class HotelStayRateResource extends Resource
{
    protected static ?string $label = "Hotel Stay Rates";
    protected static ?string $model = HotelStayRatesHistory::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function canCreate(): bool
    {
        return false;
    }

    public static function table(Table $table): Table
    {
        $hotelsService = app()->make(HotelsService::class);
        $hotels = $hotelsService->getAll();
        $names = [];
        foreach ($hotels as $hotel) {
            $names[$hotel->name] = $hotel->name;
        }

        return $table
            ->columns([
                          Tables\Columns\TextColumn::make('hotel_name'),
                          Tables\Columns\TextColumn::make('date_scraped')->date()->sortable(),
                          Tables\Columns\TextColumn::make('rate_per_night'),
                      ])
            ->filters(
                [
                    Filter::make('created_at')
                        ->form(
                            [
                                Forms\Components\DatePicker::make('date_of_stay')->default(now()),
                                Forms\Components\Select::make('hotel_name')->default('A')->options($names),
                            ]
                        )
                        ->query(function (Builder $query, array $data): Builder {
                            return $query
                                ->when(
                                    $data['date_of_stay'],
                                    fn(Builder $query, $date): Builder => $query->whereDate(
                                        'date_of_stay',
                                        '=',
                                        $date
                                    ),
                                )->when(
                                    $data['hotel_name'],
                                    fn(Builder $query, $name): Builder => $query->where(
                                        'hotel_name',
                                        '=',
                                        $name
                                    ),
                                );
                        })
                ]
            )->defaultSort('date_scraped', 'asc');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHotelStayRates::route('/'),
        ];
    }
}
