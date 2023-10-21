<?php

declare(strict_types=1);

namespace App\Services;

use App\Repositories\HotelRepository;
use Ramsey\Uuid\UuidInterface;

class HotelsService
{
    public function __construct(private HotelRepository $hotelRepository)
    {
    }

    public function paginate($page = 1, $perPage = 15)
    {
        return $this->hotelRepository->paginatedList([], $page, $perPage);
    }

    public function get(UuidInterface $id)
    {
        return $this->hotelRepository->findOneOrFail($id);
    }

    public function count(): int
    {
        return $this->hotelRepository->count();
    }
}
