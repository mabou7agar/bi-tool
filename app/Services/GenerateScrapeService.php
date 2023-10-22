<?php

declare(strict_types=1);

namespace App\Services;

use App\Entities\ScrapedItem;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class GenerateScrapeService
{
    public function generate(string $hotelName, Carbon $startDate = null): Collection
    {
        $result = collect();
        if (empty($startDate)) {
            $startDate = Carbon::today();
        }
        for ($i = 0 ; $i < 365 ; $i++) {
            $result->add(
                new ScrapedItem(
                    name:         $hotelName,
                    dateScraped:  $startDate->copy(),
                    dateOfStay:   $startDate->copy()->addDays($i),
                    ratePerNight: rand(100, 200)
                )
            );
        }

        return $result;
    }
}
