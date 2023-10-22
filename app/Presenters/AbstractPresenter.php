<?php

declare(strict_types=1);

namespace App\Presenters;

abstract class AbstractPresenter
{
    public static function collection(iterable $collection, ...$additionalParams): array
    {
        $result = [];
        foreach ($collection as $item) {
            $result[] = (new static($item, ...$additionalParams))->getData(isListing: true);
        }

        return $result;
    }

    public function getData(bool $isListing = false): array
    {
        return $this->present($isListing);
    }

    abstract protected function present(): array;
}
