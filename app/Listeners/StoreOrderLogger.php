<?php

namespace App\Listeners;

use App\Events\Interfaces\EventInterface;
use App\Listeners\Interfaces\ListenerInterface;
use App\Services\Interfaces\OrderStoreLoggerServiceInterface;

class StoreOrderLogger implements ListenerInterface
{
    public function __construct(
        private OrderStoreLoggerServiceInterface $service
    ) {
    }

    public function handle(EventInterface $event): void
    {
        $this->service->make($event->order);
    }
}
