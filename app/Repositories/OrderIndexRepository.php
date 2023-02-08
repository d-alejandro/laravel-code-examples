<?php

namespace App\Repositories;

use App\DTO\OrderIndexResponseDTO;
use App\DTO\Interfaces\OrderIndexRequestDTOInterface;
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
use App\Repositories\Criteria\WhereDateGreaterThanOrEqualCriterion;
use App\Repositories\Criteria\WhereDateLessThanOrEqualCriterion;
use App\Repositories\Criteria\WhereEqualCriterion;
use App\Repositories\Criteria\WhereInIdsCriterion;
use App\Repositories\Criteria\WhereLikeCenterCriterion;
use App\Repositories\Criteria\WhereNullOrNotCriterion;
use App\Repositories\Criteria\WithCriterion;
use App\Repositories\Interfaces\OrderIndexRepositoryInterface;

class OrderIndexRepository implements OrderIndexRepositoryInterface
{
    private OrderIndexRequestDTOInterface $requestDTO;

    public function __construct(
        private CriteriaApplierInterface $criteriaApplier
    ) {
    }

    public function make(OrderIndexRequestDTOInterface $requestDTO): OrderIndexResponseDTO
    {
        $this->requestDTO = $requestDTO;

        $this->addWhereDateEqualRentalDateCriterion();
        $this->addWhereEqualIsConfirmedCriterion();
        $this->addWhereEqualIsCheckedCriterion();
        $this->addWhereEqualStatusCriterion();
        $this->addWhereLikeCenterCriterion();
        $this->addJoinAndApplyWhereEqualCriterion();
        $this->addWhereNullOrNotCriterion();
        $this->addWhereDateGreaterThanOrEqualCriterion();
        $this->addWhereDateLessThanOrEqualCriterion();

        $count = $this->criteriaApplier->count();

        $this->addWithCriterion();
        $this->addSelectCriterion();
        $this->addPaginationCriterion();
        $this->addWhereInIdsCriterion();

        $collection = $this->criteriaApplier->get();

        return new OrderIndexResponseDTO($collection, $count);
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

    private function addWhereNullOrNotCriterion(): void
    {
        $this->criteriaApplier->addCriterion(
            new WhenCriterion(
                $this->requestDTO->hasAdminNote,
                new WhereNullOrNotCriterion(
                    Order::TABLE_NAME,
                    OrderColumn::AdminNote,
                    $this->requestDTO->hasAdminNote
                )
            )
        );
    }

    private function addWhereDateGreaterThanOrEqualCriterion(): void
    {
        $this->criteriaApplier->addCriterion(
            new WhenCriterion(
                $this->requestDTO->startRentalDate,
                new WhereDateGreaterThanOrEqualCriterion(
                    Order::TABLE_NAME,
                    OrderColumn::RentalDate,
                    $this->requestDTO->startRentalDate
                )
            )
        );
    }

    private function addWhereDateLessThanOrEqualCriterion(): void
    {
        $this->criteriaApplier->addCriterion(
            new WhenCriterion(
                $this->requestDTO->endRentalDate,
                new WhereDateLessThanOrEqualCriterion(
                    Order::TABLE_NAME,
                    OrderColumn::RentalDate,
                    $this->requestDTO->endRentalDate
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
                $this->requestDTO->paginationDTO->sortColumn,
                $this->requestDTO->paginationDTO->sortType,
                $this->requestDTO->paginationDTO->start,
                $this->requestDTO->paginationDTO->end
            )
        );
    }

    private function addWhereInIdsCriterion(): void
    {
        $this->criteriaApplier->addCriterion(
            new WhenCriterion(
                $this->requestDTO->paginationDTO->ids,
                new WhereInIdsCriterion(
                    Order::TABLE_NAME,
                    $this->requestDTO->paginationDTO->ids,
                )
            )
        );
    }
}
