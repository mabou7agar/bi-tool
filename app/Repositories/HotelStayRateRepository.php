<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\HotelStayRate;

class HotelStayRateRepository extends BaseRepository
{
    public function __construct(HotelStayRate $model)
    {
        parent::__construct($model);
    }
}
