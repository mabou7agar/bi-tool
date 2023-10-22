<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Entities\ScrapedItem;
use App\Models\Hotel;
use App\Services\GenerateScrapeService;
use App\Services\HotelsService;
use Carbon\Carbon;
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
        $hotels = $hotelsService->paginate($this->page, $this->perPage);
        /** @var Hotel $hotel */
        foreach ($hotels as $hotel) {
            $scrapedData = $generateScrapeService->generate($hotel->name);
            $hotel->rates()
                ->where('hotel_name', $hotel->name)
                ->where('date_of_stay', Carbon::tomorrow())->delete();
            /** @var ScrapedItem $scrapedItem */
            foreach ($scrapedData as $scrapedItem) {
                if ($scrapedItem->getDateScraped() == Carbon::tomorrow()) {
                    $hotel->rates()->create($scrapedItem->toArray());
                    continue;
                }
                $hotel->rates()
                    ->where('hotel_name', $scrapedItem->getName())
                    ->where('date_of_stay', $scrapedItem->getDateOfStay())
                    ->update($scrapedItem->toArray());
            }
        }
    }
}
