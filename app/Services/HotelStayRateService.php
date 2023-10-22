<?php

declare(strict_types=1);

namespace App\Services;

use App\DTOs\GetHotelStayRateHistoriesDTO;
use App\Repositories\HotelStayRatesHistoryRepository;

class HotelStayRateService
{
    public function __construct(private HotelStayRatesHistoryRepository $hotelStayRateRepository)
    {
    }

    public function getHistories(GetHotelStayRateHistoriesDTO $getHotelStayRateHistoriesDTO)
    {
        return $this->hotelStayRateRepository->paginatedList(
            [
                'hotel_name' => $getHotelStayRateHistoriesDTO->hotelName,
                'date_of_stay' => $getHotelStayRateHistoriesDTO->dateOfStay->format('Y-m-d')
            ],
            $getHotelStayRateHistoriesDTO->page,
            $getHotelStayRateHistoriesDTO->perPage,
            'date_scraped'
        );
    }
}
