<?php

namespace App\Http\Requests;

use App\DTO\IndexOrderPaginationDTO;
use App\DTO\IndexOrderRequestDTO;
use App\Enums\OrderSortColumn;
use App\Enums\OrderStatus;
use App\Enums\SortType;
use App\Helpers\Interfaces\EnumValuesToStringConverterInterface;
use App\Http\Requests\QueryParams\IndexOrderQueryParam;
use App\Http\Requests\QueryParams\Pagination;
use App\Models\Order;
use Illuminate\Foundation\Http\FormRequest;

class IndexOrderRequest extends FormRequest
{
    public function __construct(
        private EnumValuesToStringConverterInterface $converter,
        array                                        $query = [],
        array                                        $request = [],
        array                                        $attributes = [],
        array                                        $cookies = [],
        array                                        $files = [],
        array                                        $server = [],
        mixed                                        $content = null
    ) {
        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);
    }

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            Pagination::START => 'required|integer|min:0',
            Pagination::END => 'required|integer|min:1',
            Pagination::SORT_COLUMN => 'required|string|in:' . $this->converter->execute(OrderSortColumn::class),
            Pagination::SORT_TYPE => 'required|string|in:' . $this->converter->execute(SortType::class),
            Pagination::IDS => 'sometimes|required|array|exists:' . Order::TABLE_NAME . ',' . Order::COLUMN_ID,
            Pagination::IDS . '.*' => 'required|integer|min:1',
            Order::COLUMN_RENTAL_DATE => 'sometimes|required|date',
            Order::COLUMN_IS_CONFIRMED => 'sometimes|required|string|in:true,false',
            Order::COLUMN_IS_CHECKED => 'sometimes|required|string|in:true,false',
            Order::COLUMN_STATUS => 'sometimes|required|string|in:' . $this->converter->execute(OrderStatus::class),
            Order::COLUMN_USER_NAME => 'sometimes|required|string',
            IndexOrderQueryParam::AGENCY_NAME => 'sometimes|required|string',
            Order::COLUMN_ADMIN_NOTE => 'sometimes|required|string|in:true,false',
            IndexOrderQueryParam::START_DATE => 'sometimes|required|date',
            IndexOrderQueryParam::END_DATE => 'sometimes|required|date',
        ];
    }

    public function getValidated(): IndexOrderRequestDTO
    {
        $data = $this->validated();

        $indexOrderPaginationDTO = new IndexOrderPaginationDTO(
            $data[Pagination::START],
            $data[Pagination::END],
            OrderSortColumn::from($data[Pagination::SORT_COLUMN]),
            SortType::from($data[Pagination::SORT_TYPE]),
            $data[Pagination::IDS] ?? null,
        );

        return new IndexOrderRequestDTO(
            $indexOrderPaginationDTO,
            $data[Order::COLUMN_RENTAL_DATE] ?? null,
            $data[Order::COLUMN_USER_NAME] ?? null,
            $data[IndexOrderQueryParam::AGENCY_NAME] ?? null,
            $data[IndexOrderQueryParam::START_DATE] ?? null,
            $data[IndexOrderQueryParam::END_DATE] ?? null,
            $data[Order::COLUMN_STATUS] ?? null,
            $data[Order::COLUMN_IS_CONFIRMED] ?? null,
            $data[Order::COLUMN_IS_CHECKED] ?? null,
            $data[Order::COLUMN_ADMIN_NOTE] ?? null,
        );
    }
}
