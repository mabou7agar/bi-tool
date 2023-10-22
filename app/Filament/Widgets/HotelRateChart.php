<?php

namespace App\Filament\Widgets;

use App\Services\HotelsService;
use Carbon\Carbon;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class HotelRateChart extends ApexChartWidget
{
    public ?string $filter = 'A';
    protected int|string|array $columnSpan = 'full';
     protected static ?string $pollingInterval = null;
    /**
     * Chart Id
     *
     * @var string
     */
    protected static string $chartId = 'hotelRateChart';

    /**
     * Widget Title
     *
     * @var string|null
     */
    protected static ?string $heading = 'Hotel Rate Chart';

    /**
     * Chart options (series, labels, types, size, animations...)
     * https://apexcharts.com/docs/options
     *
     * @return array
     */
    protected function getOptions(): array
    {
        /** @var HotelsService $hotelsService */
        $hotelsService = app()->make(HotelsService::class);
        $hotel = $hotelsService->getByName($this->filterFormData['hotel_name'] ?? 'A');

        $rate = $hotel->rates()->where('date_of_stay', '=', $this->filterFormData['date_of_stay'])->first();
        $historyRates = $rate?->histories()->orderBy('date_scraped', 'asc')->get() ?? [];
        $dates = [];
        $chartRates = [];
        foreach ($historyRates as $rate) {
            $chartRates[] = $rate->rate_per_night;
            $dates[] = $rate->date_scraped;
        }

        return [
            'chart' => [
                'type' => 'line',
                'height' => 500
            ],
            'series' => [
                [
                    'name' => 'HotelRateChart',
                    'data' => $chartRates,
                ],
            ],
            'xaxis' => [
                'categories' => $dates,
                'labels' => [
                    'style' => [
                        'fontFamily' => 'inherit',
                    ],
                ],
            ],
            'yaxis' => [
                'labels' => [
                    'style' => [
                        'fontFamily' => 'inherit',
                    ],
                ],
            ],
            'colors' => ['#f59e0b'],
            'stroke' => [
                'curve' => 'smooth',
            ],
        ];
    }


    protected function getFormSchema(): array
    {
        $hotelsService = app()->make(HotelsService::class);
        $hotels = $hotelsService->getAll();
        $names = [];
        foreach ($hotels as $hotel) {
            $names[$hotel->name] = $hotel->name;
        }

        return [
            DatePicker::make('date_of_stay')
                ->default(Carbon::today()),
            Select::make('hotel_name')->default('A')->options($names),
        ];
    }
}
