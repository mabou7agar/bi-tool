<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Data\ScrapedItemData;
use App\Models\Hotel;
use App\Models\HotelStayRate;
use App\Models\HotelStayRatesHistory;
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
        HotelStayRate::query()->truncate();
        HotelStayRatesHistory::query()->truncate();
        $hotels = $this->hotelsService->getAll();
        /** @var Hotel $hotel */
        foreach ($hotels as $hotel) {
            $scrapedData = $this->generateScrapeService->generate($hotel->name, today()->subMonth());

            /** @var ScrapedItemData $scrapedItem */
            foreach ($scrapedData as $scrapedItem) {
                if ($scrapedItem->getDateOfStay()->lessThan(today())) {
                    $scrapedItem->setDateScraped($scrapedItem->getDateOfStay());
                } else {
                    $scrapedItem->setDateScraped(today());
                }

                $rate = $hotel->rates()->create($scrapedItem->toArray());
                $period = CarbonPeriod::create(today()->subMonth(), today());
                foreach ($period as $date) {
                    if ($date->greaterThan($scrapedItem->getDateOfStay())) {
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
