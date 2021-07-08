<?php

namespace App\Repositories\AdminPanel\Order;

use App\DTO\AdminPanel\Order\IndexOrderRequestDTO;
use App\DTO\AdminPanel\Order\IndexOrderResponseDTO;
use App\Models\Agency;
use App\Models\Order;
use App\Repositories\AdminPanel\Order\Interfaces\OrdersLoaderRepositoryInterface;
use App\Repositories\Query\ClauseBuilder;
use App\Repositories\Query\ExpressionBuilderInterface;
use Illuminate\Database\Query\JoinClause;

class OrdersLoaderRepository implements OrdersLoaderRepositoryInterface
{
    private const ALIAS_TABLE_AGENCY = 'agn';

    private array $properties;

    public function __construct(private ExpressionBuilderInterface $expressionBuilder)
    {
    }

    public function make(IndexOrderRequestDTO $indexOrderRequestDTO): IndexOrderResponseDTO
    {
        $this->properties = $indexOrderRequestDTO->getNotNullProperties();

        $this->generateExpressions();

        $count = $this->expressionBuilder->count();

        $this->expressionBuilder->with(Order::RELATION_AGENCY)
            ->select(Order::TABLE_NAME . '.*')
            ->pagination(
                Order::TABLE_NAME,
                $this->properties[IndexOrderRequestDTO::SORT],
                $this->properties[IndexOrderRequestDTO::ORDER],
                $this->properties[IndexOrderRequestDTO::START],
                $this->properties[IndexOrderRequestDTO::END]
            );

        if (array_key_exists(IndexOrderRequestDTO::IDS, $this->properties)) {
            $this->expressionBuilder->whereInIds(Order::TABLE_NAME, $this->properties[IndexOrderRequestDTO::IDS]);
        }

        return new IndexOrderResponseDTO($this->expressionBuilder->get(), $count);
    }

    private function generateExpressions(): void
    {
        $filteredQueryFilters = $this->filterQueryFilters();

        foreach ($filteredQueryFilters as $callback) {
            call_user_func($callback);
        }
    }

    private function filterQueryFilters(): array
    {
        return array_intersect_key($this->getQueryFilters(), $this->properties);
    }

    private function getQueryFilters(): array
    {
        return [
            IndexOrderRequestDTO::DATE_TOUR => fn() => $this->expressionBuilder->whereDateEqual(
                Order::TABLE_NAME,
                Order::COLUMN_DATE_TOUR,
                $this->properties[IndexOrderRequestDTO::DATE_TOUR]
            ),
            IndexOrderRequestDTO::IS_CONFIRMED => fn() => $this->expressionBuilder->whereEqual(
                Order::TABLE_NAME,
                Order::COLUMN_IS_CONFIRMED,
                $this->properties[IndexOrderRequestDTO::IS_CONFIRMED]
            ),
            IndexOrderRequestDTO::IS_CHECKED => fn() => $this->expressionBuilder->whereEqual(
                Order::TABLE_NAME,
                Order::COLUMN_IS_CHECKED,
                $this->properties[IndexOrderRequestDTO::IS_CHECKED]
            ),
            IndexOrderRequestDTO::STATUS => fn() => $this->expressionBuilder->whereEqual(
                Order::TABLE_NAME,
                Order::COLUMN_STATUS,
                $this->properties[IndexOrderRequestDTO::STATUS]
            ),
            IndexOrderRequestDTO::NAME => fn() => $this->expressionBuilder->whereLikeCenter(
                Order::TABLE_NAME,
                Order::COLUMN_NAME,
                $this->properties[IndexOrderRequestDTO::NAME]
            ),
            IndexOrderRequestDTO::AGENCY_NAME => fn() => $this->expressionBuilder->joinClause(
                Agency::TABLE_NAME,
                self::ALIAS_TABLE_AGENCY,
                Agency::COLUMN_ID,
                Order::TABLE_NAME,
                Order::COLUMN_AGENCY_ID,
                fn(JoinClause $join) => (new ClauseBuilder($join))->whereEqual(
                    self::ALIAS_TABLE_AGENCY,
                    Agency::COLUMN_NAME,
                    $this->properties[IndexOrderRequestDTO::AGENCY_NAME]
                )
            ),
            IndexOrderRequestDTO::ADMIN_NOTE => fn() => $this->expressionBuilder->whereNull(
                Order::TABLE_NAME . '.' . Order::COLUMN_ADMIN_NOTE,
                'and',
                $this->properties[IndexOrderRequestDTO::ADMIN_NOTE]
            ),
            IndexOrderRequestDTO::START_DATE => function () {
                if (array_key_exists(IndexOrderRequestDTO::END_DATE, $this->properties)) {
                    $this->expressionBuilder->whereDateBetween(
                        Order::TABLE_NAME,
                        Order::COLUMN_DATE_TOUR,
                        $this->properties[IndexOrderRequestDTO::START_DATE],
                        $this->properties[IndexOrderRequestDTO::END_DATE]
                    );
                } else {
                    $this->expressionBuilder->whereDateGreaterThanOrEqual(
                        Order::TABLE_NAME,
                        Order::COLUMN_DATE_TOUR,
                        $this->properties[IndexOrderRequestDTO::START_DATE]
                    );
                }
            },
            IndexOrderRequestDTO::END_DATE => function () {
                if (!array_key_exists(IndexOrderRequestDTO::START_DATE, $this->properties)) {
                    $this->expressionBuilder->whereDateLessThanOrEqual(
                        Order::TABLE_NAME,
                        Order::COLUMN_DATE_TOUR,
                        $this->properties[IndexOrderRequestDTO::END_DATE]
                    );
                }
            },
            IndexOrderRequestDTO::HAS_PHOTO_REPORT => fn() => $this->expressionBuilder->whereNull(
                Order::TABLE_NAME . '.' . Order::COLUMN_PHOTO_REPORT,
                'and',
                $this->properties[IndexOrderRequestDTO::HAS_PHOTO_REPORT]
            ),
        ];
    }
}
