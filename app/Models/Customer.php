<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Customer extends Model
{
    use UuidTrait;

    public $incrementing = false;
    protected $fillable = ['name'];

    public function hotels(): BelongsToMany
    {
        return $this->belongsToMany(Hotel::class, 'customer_hotel_stay_rates');
    }
}
