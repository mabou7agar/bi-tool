<?php

declare(strict_types=1);

namespace App\Presenters;

abstract class AbstractPresenter
{
    public static function collection(iterable $collection, ...$additionalParams): array
    {
        $result = [];
        foreach ($collection as $item) {
            $result[] = (new static($item, ...$additionalParams))->getData();
        }

        return $result;
    }

    public function getData(): array
    {
        return $this->present();
    }

    abstract protected function present(): array;
}
