<?php

namespace App\Repositories;

use App\DTO\IndexOrderResponseDTO;
use App\DTO\Interfaces\IndexOrderRequestDTOInterface;
use App\Models\Enums\OrderColumn;
use App\Models\Order;
use App\Repositories\Criteria\Interfaces\CriteriaApplierInterface;
use App\Repositories\Criteria\PaginationCriterion;
use App\Repositories\Criteria\WhenCriterion;
use App\Repositories\Criteria\WhereEqualCriterion;
use App\Repositories\Criteria\WhereInIdsCriterion;
use App\Repositories\Interfaces\OrderSearchRepositoryInterface;

class OrderSearchRepository implements OrderSearchRepositoryInterface
{
    public function __construct(
        private CriteriaApplierInterface $criteriaApplier
    ) {
    }

    public function make(IndexOrderRequestDTOInterface $indexOrderRequestDTO): IndexOrderResponseDTO
    {
        $this->criteriaApplier->addCriterion(
            new WhenCriterion(
                $indexOrderRequestDTO->isConfirmed,
                new WhereEqualCriterion(
                    Order::TABLE_NAME,
                    OrderColumn::IsConfirmed,
                    $indexOrderRequestDTO->isConfirmed
                )
            )
        );

        $count = $this->criteriaApplier->count();

        $this->criteriaApplier->addCriterion(
            new PaginationCriterion(
                Order::TABLE_NAME,
                $indexOrderRequestDTO->paginationDTO->sortColumn,
                $indexOrderRequestDTO->paginationDTO->sortType,
                $indexOrderRequestDTO->paginationDTO->start,
                $indexOrderRequestDTO->paginationDTO->end
            )
        );

        $this->criteriaApplier->addCriterion(
            new WhenCriterion(
                $indexOrderRequestDTO->paginationDTO->ids,
                new WhereInIdsCriterion(
                    Order::TABLE_NAME,
                    $indexOrderRequestDTO->paginationDTO->ids,
                )
            )
        );

        $collection = $this->criteriaApplier->get();

        return new IndexOrderResponseDTO($collection, $count);
    }
}
