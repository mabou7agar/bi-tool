<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Entities\ScrapedItem;
use App\Models\Hotel;
use App\Services\GenerateScrapeService;
use App\Services\HotelsService;
use Carbon\CarbonPeriod;
use Illuminate\Database\Seeder;

class HotelRateSeeder extends Seeder
{
    public function __construct(
        private HotelsService $hotelsService,
        private GenerateScrapeService $generateScrapeService
    ) {
    }

    public function run(): void
    {
        $hotels = $this->hotelsService->getAll();
        /** @var Hotel $hotel */
        foreach ($hotels as $hotel) {
            $scrapedData = $this->generateScrapeService->generate($hotel->name, now()->subMonth());
            $hotel->rates()->delete();
            /** @var ScrapedItem $scrapedItem */
            foreach ($scrapedData as $scrapedItem) {
                $scrapedItem->setDateScraped($scrapedItem->getDateOfStay());
                $rate = $hotel->rates()->create($scrapedItem->toArray());
                $period = CarbonPeriod::create(now()->subMonth(), now());
                foreach ($period as $date) {
                    if ($scrapedItem->getDateOfStay()->lessThan($date)) {
                        break;
                    }
                    $rateArray = $rate->toArray();
                    unset($rateArray['id']);
                    $rateArray['date_scraped'] = $date;
                    $rateArray['date_of_stay'] = $scrapedItem->getDateOfStay();
                    $rateArray['rate_per_night'] = abs(
                        $date->diffInDays($scrapedItem->getDateOfStay()) - $rateArray['rate_per_night']
                    );
                    $rate->histories()->create($rateArray);
                }
            }
        }
    }
}
