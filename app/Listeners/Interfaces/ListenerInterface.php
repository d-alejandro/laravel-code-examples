<?php

namespace App\Listeners\Interfaces;

use App\Events\Interfaces\EventInterface;

interface ListenerInterface
{
    public function handle(EventInterface $event): void;
}
