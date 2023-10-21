<?php

namespace App\Console\Commands;

use App\Entities\ScrapedItem;
use App\Models\Hotel;
use App\Repositories\HotelRepository;
use App\Services\GenerateScrapeService;
use Illuminate\Console\Command;

class ScrapeHotelsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scrape-hotels';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to fetch all customer hotel data';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        /** @var HotelRepository $hotelRepository */
        $hotelRepository = app()->make(HotelRepository::class);
        /** @var GenerateScrapeService $generateScrapeService */
        $generateScrapeService = app()->make(GenerateScrapeService::class);
        $hotels = $hotelRepository->all();
        /** @var Hotel $hotel */
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
