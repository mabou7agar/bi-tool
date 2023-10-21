<?php

declare(strict_types=1);

namespace App\Handlers;

use App\Repositories\HotelRepository;
use Illuminate\Support\Carbon;

class GenerateScrapeResponseHandler
{
    public function __construct(private HotelRepository $hotelRepository)
    {
    }

    public function generate(string $hotelName): array
    {
        $hotel = $this->hotelRepository->findBy(['name' => $hotelName]);
        $result = [];
        for ($i = 0 ; $i < 365 ; $i++) {
            $result[] = [
                'name' => $hotel->name,
                'date_scraped' => Carbon::now(),
                'date_of_stay' => Carbon::today()->addDays($i),
                'rate_per_night' => rand(100, 200),
            ];
        }

        return $result;
    }
}
