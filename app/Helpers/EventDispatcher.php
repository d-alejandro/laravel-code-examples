<?php

namespace App\Helpers;

use App\Helpers\Interfaces\EventDispatcherInterface;

class EventDispatcher implements EventDispatcherInterface
{
    public function dispatch(string|object $event): void
    {
        event($event);
    }
}
