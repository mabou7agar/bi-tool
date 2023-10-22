<?php

declare(strict_types=1);

namespace App\Entities;

use Illuminate\Database\Eloquent\Collection;

class PaginatedData
{
    public function __construct(private int $count, private Collection $items)
    {
    }

    /**
     * @return int
     */
    public function getCount(): int
    {
        return $this->count;
    }

    /**
     * @param int $count
     */
    public function setCount(int $count): void
    {
        $this->count = $count;
    }

    /**
     * @return Collection
     */
    public function getItems(): Collection
    {
        return $this->items;
    }

    /**
     * @param Collection $items
     */
    public function setItems(Collection $items): void
    {
        $this->items = $items;
    }
}
