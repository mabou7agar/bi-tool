<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Hotel extends Model
{
    protected $fillable = ['name'];

    public function customers(): BelongsToMany
    {
        return $this->belongsToMany(Customer::class,'customer_hotel_stay_rates');
    }

    public function rates(): HasMany
    {
        return $this->hasMany(CustomerHotelStayRates::class);
    }
}
