<?php

namespace App\Filament\Widgets;

use App\Services\HotelsService;
use Carbon\Carbon;
use Filament\Forms\Components\DatePicker;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class HotelRateChart extends ApexChartWidget
{
    public ?string $filter = 'A';
    protected int | string | array $columnSpan = 'full';
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
        $hotel = $hotelsService->getByName($this->filter);
        $rates = $hotel->rates()->where('date_of_stay', '>=', $this->filterFormData['date_of_stay'])->get();
        $dateOfStay = Carbon::createFromFormat('Y-m-d', $this->filterFormData['date_of_stay']);

        $dates = [];
        $chartRates = [];
        for ($i = 0 ; $i < 365 ; $i++) {
            $dates[] = $dateOfStay->addDay()->format('Y-m-d');
        }
        foreach ($rates as $rate) {
            $chartRates[] = $rate->rate_per_night;
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

    protected function getFilters(): ?array
    {
        /** @var HotelsService $hotelsService */
        $hotelsService = app()->make(HotelsService::class);
        $hotels = $hotelsService->getAll();
        $names = [];
        foreach ($hotels as $hotel) {
            $names[$hotel->name] = $hotel->name;
        }

        return $names;
    }

    protected function getFormSchema(): array
    {
        return [
            DatePicker::make('date_of_stay')
                ->default(Carbon::today()),
        ];
    }
}
