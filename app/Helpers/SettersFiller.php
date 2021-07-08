<?php

namespace App\Helpers;

use App\Helpers\Interfaces\SettersFillerInterface;

class SettersFiller implements SettersFillerInterface
{
    public function fill(array $columns, array $setters): void
    {
        foreach ($columns as $key => $value) {
            call_user_func($setters[$key], $value);
        }
    }
}
