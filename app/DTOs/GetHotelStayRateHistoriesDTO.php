<?php

declare(strict_types=1);

namespace App\DTOs;

use Carbon\Carbon;
/*
 * DTO (Data Transfer Object) is a simple utility and a small component that can be used to transfer data between the
 * outside world to the inside world of either the Domain or the Module.
 */
class GetHotelStayRateHistoriesDTO
{
    public function __construct(
        public string $hotelName,
        public Carbon $dateOfStay,
        public int $page = 1,
        public int $perPage = 15
    ) {
    }
}
