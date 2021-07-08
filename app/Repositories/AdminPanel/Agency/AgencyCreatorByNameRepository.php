<?php

namespace App\Repositories\AdminPanel\Agency;

use App\Models\Agency;
use App\Repositories\AdminPanel\Agency\Interfaces\AgencyCreatorByNameRepositoryInterface;
use App\Repositories\Query\ExpressionBuilderInterface;

class AgencyCreatorByNameRepository implements AgencyCreatorByNameRepositoryInterface
{
    public function __construct(private ExpressionBuilderInterface $expressionBuilder)
    {
    }

    /**
     * @return Agency|\Illuminate\Database\Eloquent\Model
     */
    public function make(string $name): Agency
    {
        return $this->expressionBuilder->firstOrCreate([
            Agency::COLUMN_NAME => $name,
        ]);
    }
}
