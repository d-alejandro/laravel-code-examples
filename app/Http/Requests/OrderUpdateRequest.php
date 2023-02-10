<?php

namespace App\Http\Requests;

use App\DTO\OrderUpdateRequestDTO;
use App\Helpers\Interfaces\RequestFilterHelperInterface;
use App\Http\Requests\Enums\OrderUpdateRequestParamEnum;
use App\Http\Requests\Interfaces\OrderUpdateRequestInterface;
use App\Providers\Bindings\HelperServiceProvider;
use Illuminate\Foundation\Http\FormRequest;

class OrderUpdateRequest extends FormRequest implements OrderUpdateRequestInterface
{
    public function rules(): array
    {
        return [
            OrderUpdateRequestParamEnum::GuestCount->value => 'required|integer|min:1',
            OrderUpdateRequestParamEnum::TransportCount->value => 'required|integer|min:1',
            OrderUpdateRequestParamEnum::UserName->value => 'required|string|max:100',
            OrderUpdateRequestParamEnum::Email->value => 'required|string|email|max:100',
            OrderUpdateRequestParamEnum::Phone->value => 'required|string|max:50',
            OrderUpdateRequestParamEnum::Note->value => 'nullable|string',
            OrderUpdateRequestParamEnum::AdminNote->value => 'nullable|string',
        ];
    }

    public function getValidated(): OrderUpdateRequestDTO
    {
        $requestParams = $this->validated();

        /* @var $filter \App\Helpers\RequestFilterHelper */
        $filter = resolve(RequestFilterHelperInterface::class, [
            HelperServiceProvider::PARAM_REQUEST_PARAMS => $requestParams,
        ]);

        return new OrderUpdateRequestDTO(
            $requestParams[OrderUpdateRequestParamEnum::GuestCount->value],
            $requestParams[OrderUpdateRequestParamEnum::TransportCount->value],
            $requestParams[OrderUpdateRequestParamEnum::UserName->value],
            $requestParams[OrderUpdateRequestParamEnum::Email->value],
            $requestParams[OrderUpdateRequestParamEnum::Phone->value],
            $filter->checkRequestParam(OrderUpdateRequestParamEnum::Note),
            $filter->checkRequestParam(OrderUpdateRequestParamEnum::AdminNote)
        );
    }
}
