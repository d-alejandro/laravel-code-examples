<?php

namespace App\Listeners;

use App\Events\OrderStored;
use App\Services\AdminPanel\Order\Interfaces\StoreOrderLoggerServiceInterface;

class StoreOrderLogger
{
    public function __construct(private StoreOrderLoggerServiceInterface $storeOrderLoggerService)
    {
    }

    public function handle(OrderStored $event): void
    {
        $this->storeOrderLoggerService->make($event->getOrder());
    }
}
