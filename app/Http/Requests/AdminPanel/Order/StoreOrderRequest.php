<?php

namespace App\Http\Requests\AdminPanel\Order;

use App\DTO\AdminPanel\Order\StoreOrderRequestDTO;
use App\Helpers\Interfaces\StringArrayConverterInterface;
use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    private const KEYS = [
        StoreOrderRequestDTO::IS_SUBSCRIBE,
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
            StoreOrderRequestDTO::AGENCY_NAME => 'required|string|max:100',
            StoreOrderRequestDTO::DATE_TOUR => 'required|date|after_or_equal:now',
            StoreOrderRequestDTO::GUESTS_COUNT => 'required|integer|min:1',
            StoreOrderRequestDTO::SCOOTERS_COUNT => 'required|integer|min:1',
            StoreOrderRequestDTO::TRANSFER => 'nullable|string|max:200',
            StoreOrderRequestDTO::HOTEL => 'required|string|max:100',
            StoreOrderRequestDTO::ROOM_NUMBER => 'required|string|max:10',
            StoreOrderRequestDTO::NAME => 'required|string|max:100',
            StoreOrderRequestDTO::EMAIL => 'required|string|email|max:100',
            StoreOrderRequestDTO::GENDER => 'nullable|string|max:50',
            StoreOrderRequestDTO::NATIONALITY => 'nullable|string|max:50',
            StoreOrderRequestDTO::PHONE =>
                'required|string|max:100|regex:/^[+]?[0-9]{0,10}[ ]?[(]?[0-9]{1,10}[)]?[-\s.0-9]*$/',
            StoreOrderRequestDTO::IS_SUBSCRIBE => 'required|string|in:true,false',
            StoreOrderRequestDTO::NOTE => 'nullable|string',
            StoreOrderRequestDTO::ADMIN_NOTE => 'nullable|string',
            StoreOrderRequestDTO::PHOTO_REPORT => 'nullable|string',
            StoreOrderRequestDTO::REFERRER => 'nullable|string|max:200',
        ];
    }

    public function validated(): array
    {
        return $this->stringArrayConverter->convertToBooleanByKeys(parent::validated(), self::KEYS);
    }
}
