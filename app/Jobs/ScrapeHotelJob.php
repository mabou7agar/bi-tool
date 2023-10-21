<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Entities\ScrapedItem;
use App\Services\GenerateScrapeService;
use App\Services\HotelsService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;

class ScrapeHotelJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;

    public int $tries = 3;
    public int $timeout = 20 * 60;

    public function __construct(private int $page, private int $perPage = 10)
    {
    }

    public function handle(HotelsService $hotelsService,GenerateScrapeService $generateScrapeService){
        $hotels = $hotelsService->paginate($this->page,$this->perPage);
        foreach ($hotels as $hotel) {
            $scrapedData = $generateScrapeService->generate($hotel->name);
            /** @var ScrapedItem $scrapedItem */
            foreach ($scrapedData as $scrapedItem) {
                $hotel->rates()->updateOrCreate(
                    [
                        'hotel_name' => $scrapedItem->getName(),
                        'date_of_stay' => $scrapedItem->getDateOfStay()
                    ],
                    $scrapedItem->toArray()
                );
            }
        }
    }
}
