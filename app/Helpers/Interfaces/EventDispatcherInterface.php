<?php

namespace App\Helpers\Interfaces;

interface EventDispatcherInterface
{
    public function dispatch(string|object $event): void;
}
