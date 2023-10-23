<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Hotel extends Model
{
    use UuidTrait;

    public $incrementing = false;
    const HOTELS_PER_PAGE = 2;
    protected $fillable = ['name'];

    public function rates(): HasMany
    {
        return $this->hasMany(HotelStayRate::class, 'hotel_name', 'name');
    }

    public function histories(): HasMany
    {
        return $this->hasMany(HotelStayRatesHistory::class, 'hotel_name', 'name');
    }
}
