<?php

namespace App\Repositories\Criteria;

use App\Repositories\Criteria\Exceptions\ClassExistenceException;
use App\Repositories\Criteria\Interfaces\CriteriaApplierInterface;
use App\Repositories\Criteria\Interfaces\CriterionInterface;
use Illuminate\Database\Eloquent\Builder;

/**
 * @method \Illuminate\Database\Eloquent\Collection get(array|string $columns = ['*'])
 */
class CriteriaApplier implements CriteriaApplierInterface
{
    private Builder $builder;

    private array $criteria = [];

    /**
     * @throws ClassExistenceException
     */
    public function __construct(string $eloquentModel)
    {
        $this->checkClassExistence($eloquentModel);

        /* @var $eloquentModel \Illuminate\Database\Eloquent\Model */
        $this->builder = $eloquentModel::query();
    }

    public function __call(string $name, array $arguments): mixed
    {
        /* @var $criterion CriterionInterface */
        foreach ($this->criteria as $criterion) {
            $criterion->apply($this->builder);
        }

        return $this->builder->{$name}(...$arguments);
    }

    public function addCriterion(CriterionInterface $criterion): void
    {
        $this->criteria[] = $criterion;
    }

    /**
     * @throws ClassExistenceException
     */
    private function checkClassExistence(string $eloquentModel): void
    {
        if (!class_exists($eloquentModel)) {
            throw new ClassExistenceException("Class '$eloquentModel' not found.");
        }
    }
}
