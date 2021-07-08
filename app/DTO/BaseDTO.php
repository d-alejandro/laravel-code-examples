<?php

namespace App\DTO;

use Illuminate\Support\Arr;

abstract class BaseDTO
{
    public function __construct(array $attributes)
    {
        $this->setProperties($attributes);
    }

    abstract protected function setters(): array;

    abstract protected function getters(): array;

    public function getNotNullProperties(): array
    {
        return Arr::where($this->getters(), fn($value) => isset($value));
    }

    public function getProperties(): array
    {
        return $this->getters();
    }

    private function setProperties(array $attributes): void
    {
        $filteredSetters = $this->filterSetters($attributes);

        foreach ($filteredSetters as $key => $callback) {
            call_user_func($callback, $attributes[$key]);
        }
    }

    private function filterSetters(array $attributes): array
    {
        return array_intersect_key($this->setters(), $attributes);
    }
}
