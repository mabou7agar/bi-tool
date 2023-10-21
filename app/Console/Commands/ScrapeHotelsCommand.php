<?php

namespace App\Console\Commands;

use App\Jobs\ScrapeHotelJob;
use App\Models\Hotel;
use App\Services\HotelsService;
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
    protected $description = 'Command to fetch all hotel data';

    /**
     * Execute the console command.
     */
    public function handle()
    {
            /** @var HotelsService $hotelsService */
            $hotelsService = app()->make(HotelsService::class);
            $hotelsCount = $hotelsService->count();
            $perPage = Hotel::HOTELS_PER_PAGE;
            $pagesCount = ceil($hotelsCount / $perPage);
            //Use Loop and handle hotels in queue
            for ($page = 1; $page <= $pagesCount; $page++) {
                //Queue Could Be Changed But keep it default as it is while this is the case now
                ScrapeHotelJob::dispatch($page,$perPage);
            }
    }
}
