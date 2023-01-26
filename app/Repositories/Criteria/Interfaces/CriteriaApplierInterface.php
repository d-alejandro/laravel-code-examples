<?php

namespace App\Repositories\Criteria\Interfaces;

interface CriteriaApplierInterface
{
    public function __call(string $name, array $arguments): mixed;

    public function addCriterion(CriterionInterface $criterion): void;
}
