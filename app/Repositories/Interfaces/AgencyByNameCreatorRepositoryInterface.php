<?php

namespace App\Repositories\Interfaces;

use App\Models\Agency;

interface AgencyByNameCreatorRepositoryInterface
{
    public function make(string $name): Agency;
}
