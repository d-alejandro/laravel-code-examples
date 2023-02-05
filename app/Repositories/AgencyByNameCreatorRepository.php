<?php

namespace App\Repositories;

use App\Models\Agency;
use App\Models\Enums\AgencyColumn;
use App\Repositories\Interfaces\AgencyByNameCreatorRepositoryInterface;

class AgencyByNameCreatorRepository implements AgencyByNameCreatorRepositoryInterface
{
    public function __construct(
        private Agency $agency
    ) {
    }

    public function make(string $name): Agency
    {
        return $this->agency->firstOrCreate([
            AgencyColumn::Name->value => $name,
        ]);
    }
}
