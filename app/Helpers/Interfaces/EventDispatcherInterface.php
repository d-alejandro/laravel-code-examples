<?php

namespace App\Helpers\Interfaces;

use App\Events\Interfaces\EventInterface;

interface EventDispatcherInterface
{
    public function dispatch(EventInterface $event): void;
}
