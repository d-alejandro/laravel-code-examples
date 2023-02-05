<?php

namespace App\Listeners;

use App\Events\Interfaces\EventInterface;
use App\Listeners\Interfaces\ListenerInterface;
use App\Services\Interfaces\LoggerServiceInterface;

class OrderStoreLogger implements ListenerInterface
{
    public function __construct(
        private LoggerServiceInterface $service
    ) {
    }

    public function handle(EventInterface $event): void
    {
        $this->service->make($event->order);
    }
}
