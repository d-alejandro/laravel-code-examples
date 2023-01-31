<?php

namespace App\Repositories;

use App\DTO\IndexOrderResponseDTO;
use App\DTO\IndexPaginationDTO;
use App\DTO\Interfaces\IndexOrderRequestDTOInterface;
use App\Models\Agency;
use App\Models\Enums\AgencyColumn;
use App\Models\Enums\OrderColumn;
use App\Models\Order;
use App\Repositories\Criteria\Interfaces\CriteriaApplierInterface;
use App\Repositories\Criteria\JoinAndApplyCriterion;
use App\Repositories\Criteria\PaginationCriterion;
use App\Repositories\Criteria\SelectCriterion;
use App\Repositories\Criteria\WhenCriterion;
use App\Repositories\Criteria\WhereDateEqualCriterion;
use App\Repositories\Criteria\WhereEqualCriterion;
use App\Repositories\Criteria\WhereInIdsCriterion;
use App\Repositories\Criteria\WhereLikeCenterCriterion;
use App\Repositories\Criteria\WhereNullCheckNotCriterion;
use App\Repositories\Criteria\WithCriterion;
use App\Repositories\Interfaces\OrderSearchRepositoryInterface;

class OrderSearchRepository implements OrderSearchRepositoryInterface
{
    private IndexOrderRequestDTOInterface $requestDTO;
    private IndexPaginationDTO $paginationDTO;

    public function __construct(
        private CriteriaApplierInterface $criteriaApplier
    ) {
    }

    public function make(IndexOrderRequestDTOInterface $indexOrderRequestDTO): IndexOrderResponseDTO
    {
        $this->requestDTO = $indexOrderRequestDTO;
        $this->paginationDTO = $indexOrderRequestDTO->paginationDTO;

        $this->addWhereDateEqualRentalDateCriterion();
        $this->addWhereEqualIsConfirmedCriterion();
        $this->addWhereEqualIsCheckedCriterion();
        $this->addWhereEqualStatusCriterion();
        $this->addWhereLikeCenterCriterion();
        $this->addJoinAndApplyWhereEqualCriterion();
        $this->addWhereNullCheckNotCriterion();

        $count = $this->criteriaApplier->count();

        $this->addWithCriterion();
        $this->addSelectCriterion();
        $this->addPaginationCriterion();
        $this->addWhereInIdsCriterion();

        $collection = $this->criteriaApplier->get();

        return new IndexOrderResponseDTO($collection, $count);
    }

    private function addWhereDateEqualRentalDateCriterion(): void
    {
        $this->criteriaApplier->addCriterion(
            new WhenCriterion(
                $this->requestDTO->rentalDate,
                new WhereDateEqualCriterion(
                    Order::TABLE_NAME,
                    OrderColumn::RentalDate,
                    $this->requestDTO->rentalDate
                )
            )
        );
    }

    private function addWhereEqualIsConfirmedCriterion(): void
    {
        $this->criteriaApplier->addCriterion(
            new WhenCriterion(
                $this->requestDTO->isConfirmed,
                new WhereEqualCriterion(
                    Order::TABLE_NAME,
                    OrderColumn::IsConfirmed,
                    $this->requestDTO->isConfirmed
                )
            )
        );
    }

    private function addWhereEqualIsCheckedCriterion(): void
    {
        $this->criteriaApplier->addCriterion(
            new WhenCriterion(
                $this->requestDTO->isChecked,
                new WhereEqualCriterion(
                    Order::TABLE_NAME,
                    OrderColumn::IsChecked,
                    $this->requestDTO->isChecked
                )
            )
        );
    }

    private function addWhereEqualStatusCriterion(): void
    {
        $this->criteriaApplier->addCriterion(
            new WhenCriterion(
                $this->requestDTO->status?->value,
                new WhereEqualCriterion(
                    Order::TABLE_NAME,
                    OrderColumn::Status,
                    $this->requestDTO->status?->value
                )
            )
        );
    }

    private function addWhereLikeCenterCriterion(): void
    {
        $this->criteriaApplier->addCriterion(
            new WhenCriterion(
                $this->requestDTO->userName,
                new WhereLikeCenterCriterion(
                    Order::TABLE_NAME,
                    OrderColumn::UserName,
                    $this->requestDTO->userName
                )
            )
        );
    }

    private function addJoinAndApplyWhereEqualCriterion(): void
    {
        $this->criteriaApplier->addCriterion(
            new WhenCriterion(
                $this->requestDTO->agencyName,
                new JoinAndApplyCriterion(
                    Agency::TABLE_NAME,
                    Agency::TABLE_ALIAS,
                    AgencyColumn::Id,
                    Order::TABLE_NAME,
                    OrderColumn::AgencyId,
                    new WhereEqualCriterion(
                        Agency::TABLE_ALIAS,
                        AgencyColumn::Name,
                        $this->requestDTO->agencyName
                    )
                )
            )
        );
    }

    private function addWhereNullCheckNotCriterion(): void
    {
        $this->criteriaApplier->addCriterion(
            new WhenCriterion(
                $this->requestDTO->hasAdminNote,
                new WhereNullCheckNotCriterion(
                    Order::TABLE_NAME,
                    OrderColumn::AdminNote,
                    $this->requestDTO->hasAdminNote
                )
            )
        );
    }

    private function addWithCriterion(): void
    {
        $this->criteriaApplier->addCriterion(
            new WithCriterion(Order::RELATION_AGENCY)
        );
    }

    private function addSelectCriterion(): void
    {
        $this->criteriaApplier->addCriterion(
            new SelectCriterion(Order::TABLE_NAME . '.*')
        );
    }

    private function addPaginationCriterion(): void
    {
        $this->criteriaApplier->addCriterion(
            new PaginationCriterion(
                Order::TABLE_NAME,
                $this->paginationDTO->sortColumn,
                $this->paginationDTO->sortType,
                $this->paginationDTO->start,
                $this->paginationDTO->end
            )
        );
    }

    private function addWhereInIdsCriterion(): void
    {
        $this->criteriaApplier->addCriterion(
            new WhenCriterion(
                $this->paginationDTO->ids,
                new WhereInIdsCriterion(
                    Order::TABLE_NAME,
                    $this->paginationDTO->ids,
                )
            )
        );
    }
}
