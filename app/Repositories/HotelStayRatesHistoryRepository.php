<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\HotelStayRatesHistory;

class HotelStayRatesHistoryRepository extends BaseRepository
{
    public function __construct(HotelStayRatesHistory $model)
    {
        parent::__construct($model);
    }
}
