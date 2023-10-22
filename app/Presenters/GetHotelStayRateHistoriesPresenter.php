<?php

declare(strict_types=1);

namespace App\Presenters;

use App\Models\HotelStayRatesHistory;

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
            'date_of_stay' => $this->hotelStayRatesHistory->date_of_stay,
            'date_scraped' => $this->hotelStayRatesHistory->date_scraped,
        ];
    }
}
