<?php

namespace App\Repositories\AdminPanel\Agency\Interfaces;

use App\Models\Agency;

interface AgencyCreatorByNameRepositoryInterface
{
    public function make(string $name): Agency;
}
