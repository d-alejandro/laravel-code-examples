<?php

namespace App\Http\Requests\AdminPanel\Order;

use App\DTO\AdminPanel\Order\UpdateOrderRequestDTO;
use App\Helpers\Interfaces\StringArrayConverterInterface;
use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderRequest extends FormRequest
{
    private const KEYS = [
        UpdateOrderRequestDTO::IS_SUBSCRIBE,
    ];

    public function __construct(
        private StringArrayConverterInterface $stringArrayConverter,
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
            UpdateOrderRequestDTO::GUESTS_COUNT => 'required|integer|min:1',
            UpdateOrderRequestDTO::SCOOTERS_COUNT => 'required|integer|min:1',
            UpdateOrderRequestDTO::TRANSFER => 'nullable|string|max:200',
            UpdateOrderRequestDTO::HOTEL => 'required|string|max:100',
            UpdateOrderRequestDTO::ROOM_NUMBER => 'required|string|max:10',
            UpdateOrderRequestDTO::NAME => 'required|string|max:100',
            UpdateOrderRequestDTO::EMAIL => 'required|string|email|max:100',
            UpdateOrderRequestDTO::GENDER => 'nullable|string|max:50',
            UpdateOrderRequestDTO::NATIONALITY => 'nullable|string|max:50',
            UpdateOrderRequestDTO::PHONE =>
                'required|string|max:100|regex:/^[+]?[0-9]{0,10}[ ]?[(]?[0-9]{1,10}[)]?[-\s.0-9]*$/',
            UpdateOrderRequestDTO::IS_SUBSCRIBE => 'required|string|in:true,false',
            UpdateOrderRequestDTO::NOTE => 'nullable|string',
            UpdateOrderRequestDTO::ADMIN_NOTE => 'nullable|string',
            UpdateOrderRequestDTO::PHOTO_REPORT => 'nullable|string',
        ];
    }

    public function validated(): array
    {
        return $this->stringArrayConverter->convertToBooleanByKeys(parent::validated(), self::KEYS);
    }
}
