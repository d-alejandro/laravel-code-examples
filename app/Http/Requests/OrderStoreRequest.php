<?php

namespace App\Http\Requests;

use App\DTO\OrderStoreRequestDTO;
use App\Helpers\Interfaces\RequestFilterHelperInterface;
use App\Http\Requests\Enums\OrderStoreRequestParamEnum;
use App\Http\Requests\Interfaces\OrderStoreRequestInterface;
use App\Providers\Bindings\HelperServiceProvider;
use Illuminate\Foundation\Http\FormRequest;

class OrderStoreRequest extends FormRequest implements OrderStoreRequestInterface
{
    public function rules(): array
    {
        return [
            OrderStoreRequestParamEnum::AgencyName->value => 'required|string|max:200',
            OrderStoreRequestParamEnum::RentalDate->value => 'required|date|after_or_equal:now',
            OrderStoreRequestParamEnum::GuestCount->value => 'required|integer|min:1',
            OrderStoreRequestParamEnum::TransportCount->value => 'required|integer|min:1',
            OrderStoreRequestParamEnum::UserName->value => 'required|string|max:100',
            OrderStoreRequestParamEnum::Email->value => 'required|string|email|max:100',
            OrderStoreRequestParamEnum::Phone->value => 'required|string|max:50',
            OrderStoreRequestParamEnum::Note->value => 'nullable|string',
            OrderStoreRequestParamEnum::AdminNote->value => 'nullable|string',
        ];
    }

    public function getValidated(): OrderStoreRequestDTO
    {
        $requestParams = $this->validated();

        /* @var $filter \App\Helpers\RequestFilterHelper */
        $filter = resolve(RequestFilterHelperInterface::class, [
            HelperServiceProvider::PARAM_REQUEST_PARAMS => $requestParams,
        ]);

        return new OrderStoreRequestDTO(
            $requestParams[OrderStoreRequestParamEnum::AgencyName->value],
            $requestParams[OrderStoreRequestParamEnum::RentalDate->value],
            $requestParams[OrderStoreRequestParamEnum::GuestCount->value],
            $requestParams[OrderStoreRequestParamEnum::TransportCount->value],
            $requestParams[OrderStoreRequestParamEnum::UserName->value],
            $requestParams[OrderStoreRequestParamEnum::Email->value],
            $requestParams[OrderStoreRequestParamEnum::Phone->value],
            $filter->checkRequestParam(OrderStoreRequestParamEnum::Note),
            $filter->checkRequestParam(OrderStoreRequestParamEnum::AdminNote),
        );
    }
}
