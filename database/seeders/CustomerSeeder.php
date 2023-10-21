<?php

namespace Database\Seeders;

use Database\Factories\CustomerFactory;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;
use Illuminate\Database\UniqueConstraintViolationException;

class CustomerSeeder extends Seeder
{
    public function __construct(private CustomerFactory $customerFactory)
    {
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $names = ['C1', 'C2', 'C3', 'C4'];
        try {
            $this->customerFactory->count(count($names))
                ->sequence(fn(Sequence $sequence) => ['name' => $names[$sequence->index]])->create();
        }
        catch (UniqueConstraintViolationException $uniqueConstraintViolationException){
            //No Need to recreated if exists
        }
    }
}
