<?php

namespace App\Helpers\Interfaces;

interface SettersFillerInterface
{
    public function fill(array $columns, array $setters): void;
}
