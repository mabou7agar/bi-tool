<?php

declare(strict_types=1);

namespace App\Handlers;

use App\Models\HotelStayRate;
use App\Models\HotelStayRatesHistory;
use Illuminate\Support\Facades\DB;

use function now;
use function today;

class CreateRateHistoryHandler
{
    public function __construct()
    {
    }

    public function handle()
    {
        $historyTable = (new HotelStayRatesHistory)->getTable();
        $rateTable = (new HotelStayRate)->getTable();
        $today = today()->format('Y-m-d');
        $now = now();
        $count = HotelStayRatesHistory::where('date_scraped', $today)->where('date_of_stay',$today)->count();
        if ($count < 1) {
            DB::statement(
                "INSERT IGNORE INTO {$historyTable} (id,hotel_name,date_of_stay,date_scraped,rate_per_night,old_uuid,created_at,updated_at) SELECT
            uuid(),hotel_name,date_of_stay,date_scraped,rate_per_night,id,'{$now}','{$now}' from {$rateTable}"
            );
        }
    }
}
