<?php

declare(strict_types=1);

namespace App\Services;

use App\Repositories\CustomerRepository;
use Ramsey\Uuid\UuidInterface;

class CustomersService
{
    public function __construct(private CustomerRepository $customerRepository)
    {
    }

    public function paginate($page = 1,$perPage = 15)
    {
        return $this->customerRepository->paginatedList([],$page,$perPage);
    }

    public function get(UuidInterface $id)
    {
        return $this->customerRepository->findOneOrFail($id);
    }
}
