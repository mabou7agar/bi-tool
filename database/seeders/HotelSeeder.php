<?php

namespace Database\Seeders;

use Database\Factories\HotelFactory;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;
use Illuminate\Database\UniqueConstraintViolationException;

class HotelSeeder extends Seeder
{
    public function __construct(private HotelFactory $hotelFactory)
    {
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $names = ['A', 'B', 'C', 'D'];
        try {
            $this->hotelFactory->count(count($names))
                ->sequence(fn(Sequence $sequence) => ['name' => $names[$sequence->index]])->create();
        }
        catch (UniqueConstraintViolationException $uniqueConstraintViolationException){
            //No Need to recreated if exists
        }
    }
}
