<?php

declare(strict_types=1);

namespace App\Presenters;

use App\Models\HotelStayRatesHistory;
/*
 * Instead of outputting all the model fields and their loaded relationship,
 * we can basically format that to an agreed structure that will output only the needed data and also rename fields
 * to be more convenient than the original names in models or datasets
 */
class GetHotelStayRateHistoriesPresenter extends AbstractPresenter
{
    public function __construct(private HotelStayRatesHistory $hotelStayRatesHistory)
    {
    }

    protected function present(): array
    {
        return [
            'id' => $this->hotelStayRatesHistory->id,
            'name' => $this->hotelStayRatesHistory->hotel_name,
            'date_of_stay' => $this->hotelStayRatesHistory->date_of_stay->format('Y-m-d'),
            'date_scraped' => $this->hotelStayRatesHistory->date_scraped->format('Y-m-d'),
        ];
    }
}
