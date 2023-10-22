<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HotelStayRateResource\Pages;
use App\Filament\Resources\HotelStayRateResource\RelationManagers;
use App\Models\HotelStayRate;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class HotelStayRateResource extends Resource
{
    protected static ?string $model = HotelStayRate::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function canCreate(): bool
    {
        return false;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                          Tables\Columns\TextColumn::make('hotel_name'),
                          Tables\Columns\TextColumn::make('date_of_stay')->since(),
                          Tables\Columns\TextColumn::make('rate_per_night'),
                      ])
            ->filters(
                [
                    Filter::make('created_at')
                        ->form(
                            [
                                Forms\Components\DatePicker::make('date_of_stay')->default(now()),
                            ]
                        )
                        ->query(function (Builder $query, array $data): Builder {
                            return $query
                                ->when(
                                    $data['date_of_stay'],
                                    fn(Builder $query, $date): Builder => $query->whereDate(
                                        'date_of_stay',
                                        '>=',
                                        $date
                                    ),
                                );
                        })
                ]
            )->defaultSort('date_of_stay', 'asc');
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
