<?php

namespace App\Http\Requests;

use App\DTO\IndexOrderPaginationDTO;
use App\DTO\IndexOrderRequestDTO;
use App\Enums\OrderSortColumn;
use App\Enums\OrderStatus;
use App\Enums\SortType;
use App\Helpers\Interfaces\EnumSerializerInterface;
use App\Helpers\Interfaces\BooleanFilterInterface;
use App\Http\Requests\QueryParams\IndexOrderQueryParam;
use App\Http\Requests\QueryParams\Pagination;
use App\Models\Order;
use Illuminate\Foundation\Http\FormRequest;

class IndexOrderRequest extends FormRequest
{
    private BooleanFilterInterface $filter;
    private array $data;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $serializer = resolve(EnumSerializerInterface::class);

        return [
            Pagination::START => 'required|integer|min:0',
            Pagination::END => 'required|integer|min:1',
            Pagination::SORT_COLUMN => 'required|string|in:' . $serializer->execute(OrderSortColumn::class),
            Pagination::SORT_TYPE => 'required|string|in:' . $serializer->execute(SortType::class),
            Pagination::IDS => 'sometimes|required|array|exists:' . Order::TABLE_NAME . ',' . Order::COLUMN_ID,
            Pagination::IDS . '.*' => 'required|integer|min:1',
            Order::COLUMN_RENTAL_DATE => 'sometimes|required|date',
            Order::COLUMN_IS_CONFIRMED => 'sometimes|required|string|in:true,false',
            Order::COLUMN_IS_CHECKED => 'sometimes|required|string|in:true,false',
            Order::COLUMN_STATUS => 'sometimes|required|string|in:' . $serializer->execute(OrderStatus::class),
            Order::COLUMN_USER_NAME => 'sometimes|required|string',
            IndexOrderQueryParam::AGENCY_NAME => 'sometimes|required|string',
            Order::COLUMN_ADMIN_NOTE => 'sometimes|required|string|in:true,false',
            IndexOrderQueryParam::START_DATE => 'sometimes|required|date',
            IndexOrderQueryParam::END_DATE => 'sometimes|required|date',
        ];
    }

    public function getValidated(): IndexOrderRequestDTO
    {
        $this->filter = resolve(BooleanFilterInterface::class);

        $this->data = $this->validated();

        $indexOrderPaginationDTO = new IndexOrderPaginationDTO(
            $this->data[Pagination::START],
            $this->data[Pagination::END],
            OrderSortColumn::from($this->data[Pagination::SORT_COLUMN]),
            SortType::from($this->data[Pagination::SORT_TYPE]),
            $this->checkValue(Pagination::IDS),
        );

        return new IndexOrderRequestDTO(
            $indexOrderPaginationDTO,
            $this->checkValue(Order::COLUMN_RENTAL_DATE),
            $this->checkValue(Order::COLUMN_USER_NAME),
            $this->checkValue(IndexOrderQueryParam::AGENCY_NAME),
            $this->checkValue(IndexOrderQueryParam::START_DATE),
            $this->checkValue(IndexOrderQueryParam::END_DATE),
            OrderStatus::tryFrom($this->checkValue(Order::COLUMN_STATUS)),
            $this->filterValue(Order::COLUMN_IS_CONFIRMED),
            $this->filterValue(Order::COLUMN_IS_CHECKED),
            $this->filterValue(Order::COLUMN_ADMIN_NOTE),
        );
    }

    private function checkValue(string $queryParam): mixed
    {
        return $this->data[$queryParam] ?? null;
    }

    private function filterValue(string $queryParam): bool|null
    {
        return isset($this->data[$queryParam])
            ? $this->filter->execute($this->data[$queryParam])
            : null;
    }
}
