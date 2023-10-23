<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Data\ScrapedItemData;
use App\Handlers\CreateRateHistoryHandler;
use App\Models\Hotel;
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

    public function handle(HotelsService $hotelsService, GenerateScrapeService $generateScrapeService)
    {
        //Getting Paginated Data For Hotels
        $hotels = $hotelsService->paginate($this->page, $this->perPage);
        /** @var Hotel $hotel */
        foreach ($hotels->getItems() as $hotel) {
            $scrapedData = $generateScrapeService->generate($hotel->name);
            /** @var \App\Data\ScrapedItemData $scrapedItem */
            foreach ($scrapedData as $scrapedItem) {
                //Could be enhanced to make a bulk action once to the DB to reduce number of queries needed
                $hotel->rates()->updateOrCreate(
                    [
                        'hotel_name' => $scrapedItem->getName(),
                        'date_of_stay' => $scrapedItem->getDateOfStay()->format('Y-m-d')
                    ],
                    $scrapedItem->toArray()
                );
            }
            //Clone Hotel Rates to history table
            (new CreateRateHistoryHandler())->handle($hotel->name);
        }
    }
}
