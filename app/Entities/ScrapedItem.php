<?php

declare(strict_types=1);

namespace App\Entities;

use Carbon\Carbon;

class ScrapedItem
{
    public function __construct(
        private string $name,
        private Carbon $dateScraped,
        private Carbon $dateOfStay,
        private int $ratePerNight
    ) {
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return Carbon
     */
    public function getDateScraped(): Carbon
    {
        return $this->dateScraped;
    }

    /**
     * @return Carbon
     */
    public function getDateOfStay(): Carbon
    {
        return $this->dateOfStay;
    }

    /**
     * @return double
     */
    public function getRatePerNight(): float
    {
        return $this->ratePerNight;
    }

    public function toArray(): array
    {
        return [
            'hotel_name' => $this->name,
            'date_of_stay' => $this->dateOfStay,
            'rate_per_night' => $this->ratePerNight,
            'date_scraped' => $this->dateScraped,
        ];
    }
}
