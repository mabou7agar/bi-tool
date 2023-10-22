<?php

declare(strict_types=1);

namespace App\DTOs;

use Carbon\Carbon;

class GetHotelStayRateHistoriesDTO
{
    public function __construct(
        public string $hotelName,
        public Carbon $dateOfStay,
        public $page = 1,
        public $perPage = 15
    ) {
    }
}
