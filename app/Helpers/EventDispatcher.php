<?php

namespace App\Helpers;

use App\Events\Interfaces\EventInterface;
use App\Helpers\Interfaces\EventDispatcherInterface;

class EventDispatcher implements EventDispatcherInterface
{
    public function dispatch(EventInterface $event): void
    {
        event($event);
    }
}
