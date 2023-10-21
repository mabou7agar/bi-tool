<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Hotel;

class HotelRepository extends BaseRepository
{
    public function __construct(Hotel $model)
    {
        parent::__construct($model);
    }
}
