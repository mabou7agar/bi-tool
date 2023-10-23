<?php

namespace Database\Seeders;

use Database\Factories\CustomerFactory;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function __construct(private UserFactory $userFactory)
    {
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $names = ['C1', 'C2', 'C3', 'C4'];
        try {
            $this->userFactory->count(count($names))
                ->sequence(
                    fn(Sequence $sequence) => [
                        'name' => $names[$sequence->index],
                        'email' => Str::snake($names[$sequence->index]) . '@bi.com'
                    ]
                )->create();
        } catch (UniqueConstraintViolationException $uniqueConstraintViolationException) {
            //No Need to recreated if exists
        }
    }
}
