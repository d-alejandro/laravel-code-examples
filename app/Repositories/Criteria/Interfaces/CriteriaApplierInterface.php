<?php

namespace App\Repositories\Criteria\Interfaces;

interface CriteriaApplierInterface
{
    public function addCriterion(CriterionInterface $criterion): void;
}
