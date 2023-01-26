<?php

namespace App\Repositories;

use App\DTO\IndexOrderResponseDTO;
use App\DTO\Interfaces\IndexOrderRequestDTOInterface;
use App\Models\Order;
use App\Repositories\Criteria\Interfaces\CriteriaApplierInterface;
use App\Repositories\Criteria\WhereEqualCriterion;
use App\Repositories\Interfaces\OrderSearchRepositoryInterface;

class OrderSearchRepository implements OrderSearchRepositoryInterface
{
    public function __construct(
        private CriteriaApplierInterface $criteriaApplier
    ) {
    }

    public function make(IndexOrderRequestDTOInterface $indexOrderRequestDTO): IndexOrderResponseDTO
    {
        $whereEqualCriterion = new WhereEqualCriterion(
            Order::TABLE_NAME,
            Order::COLUMN_IS_CONFIRMED,
            $indexOrderRequestDTO->isConfirmed
        );

        $this->criteriaApplier->addCriterion($whereEqualCriterion);

        $collection = $this->criteriaApplier->get();

        return new IndexOrderResponseDTO($collection, 1);
    }
}
