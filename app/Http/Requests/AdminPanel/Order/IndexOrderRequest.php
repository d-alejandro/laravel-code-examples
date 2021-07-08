<?php

namespace App\Http\Requests\AdminPanel\Order;

use App\DTO\AdminPanel\Order\IndexOrderRequestDTO;
use App\Helpers\Interfaces\StringArrayConverterInterface;
use App\Models\Order;
use Illuminate\Foundation\Http\FormRequest;

class IndexOrderRequest extends FormRequest
{
    private const KEYS = [
        IndexOrderRequestDTO::IS_CONFIRMED,
        IndexOrderRequestDTO::IS_CHECKED,
        IndexOrderRequestDTO::ADMIN_NOTE,
    ];

    public function __construct(
        private StringArrayConverterInterface $stringArrayConverterInterface,
        array $query = [],
        array $request = [],
        array $attributes = [],
        array $cookies = [],
        array $files = [],
        array $server = [],
        $content = null
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
            IndexOrderRequestDTO::START => 'required|integer|min:0',
            IndexOrderRequestDTO::END => 'required|integer|min:1',
            IndexOrderRequestDTO::SORT => 'required|string|in:' . implode(',', Order::sortColumns()),
            IndexOrderRequestDTO::ORDER => 'required|string|in:asc,desc',
            IndexOrderRequestDTO::IDS => 'sometimes|required|array|exists:'
                . Order::TABLE_NAME . ',' . Order::COLUMN_ID,
            IndexOrderRequestDTO::IDS . '.*' => 'required|integer|min:1',
            IndexOrderRequestDTO::DATE_TOUR => 'sometimes|required|date',
            IndexOrderRequestDTO::IS_CONFIRMED => 'sometimes|required|string|in:true,false',
            IndexOrderRequestDTO::IS_CHECKED => 'sometimes|required|string|in:true,false',
            IndexOrderRequestDTO::STATUS => 'sometimes|required|string|in:' . implode(',', Order::statuses()),
            IndexOrderRequestDTO::NAME => 'sometimes|required|string',
            IndexOrderRequestDTO::AGENCY_NAME => 'sometimes|required|string',
            IndexOrderRequestDTO::ADMIN_NOTE => 'sometimes|required|string|in:true,false',
            IndexOrderRequestDTO::START_DATE => 'sometimes|required|date',
            IndexOrderRequestDTO::END_DATE => 'sometimes|required|date',
            IndexOrderRequestDTO::HAS_PHOTO_REPORT => 'sometimes|required|boolean',
        ];
    }

    public function validated(): array
    {
        return $this->stringArrayConverterInterface->convertToBooleanByKeys(parent::validated(), self::KEYS);
    }
}
