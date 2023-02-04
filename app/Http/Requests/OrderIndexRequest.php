<?php

namespace App\Http\Requests;

use App\DTO\PaginationDTO;
use App\DTO\OrderIndexRequestDTO;
use App\Enums\OrderStatusEnum;
use App\Enums\SortTypeEnum;
use App\Helpers\Interfaces\EnumHelperInterface;
use App\Helpers\Interfaces\RequestFilterHelperInterface;
use App\Http\Requests\Enums\OrderIndexRequestParamEnum;
use App\Http\Requests\Enums\PaginationEnum;
use App\Http\Requests\Interfaces\OrderIndexRequestInterface;
use App\Models\Enums\OrderColumn;
use App\Models\Order;
use App\Providers\Bindings\HelperServiceProvider;
use Illuminate\Foundation\Http\FormRequest;

class OrderIndexRequest extends FormRequest implements OrderIndexRequestInterface
{
    /**
     * @throws \App\Helpers\Exceptions\EnumHelperException
     */
    public function rules(): array
    {
        /* @var $enumHelper \App\Helpers\EnumHelper */
        $enumHelper = resolve(EnumHelperInterface::class);

        return [
            PaginationEnum::Start->value => 'required|integer|min:0',
            PaginationEnum::End->value => 'required|integer|min:1',
            PaginationEnum::SortColumn->value =>
                'required|string|in:' . $enumHelper->serialize(OrderColumn::class),
            PaginationEnum::SortType->value =>
                'required|string|in:' . $enumHelper->serialize(SortTypeEnum::class),
            PaginationEnum::Ids->value =>
                'sometimes|required|array|exists:' . Order::TABLE_NAME . ',' . OrderColumn::Id->value,
            PaginationEnum::Ids->value . '.*' => 'required|integer|min:1',
            OrderIndexRequestParamEnum::RentalDate->value => 'sometimes|required|date',
            OrderIndexRequestParamEnum::IsConfirmed->value => 'sometimes|required|string|in:true,false',
            OrderIndexRequestParamEnum::IsChecked->value => 'sometimes|required|string|in:true,false',
            OrderIndexRequestParamEnum::Status->value =>
                'sometimes|required|string|in:' . $enumHelper->serialize(OrderStatusEnum::class),
            OrderIndexRequestParamEnum::UserName->value => 'sometimes|required|string',
            OrderIndexRequestParamEnum::AgencyName->value => 'sometimes|required|string',
            OrderIndexRequestParamEnum::AdminNote->value => 'sometimes|required|string|in:true,false',
            OrderIndexRequestParamEnum::StartDate->value => 'sometimes|required|date',
            OrderIndexRequestParamEnum::EndDate->value => 'sometimes|required|date',
        ];
    }

    /**
     * @throws \App\Helpers\Exceptions\BooleanFilterHelperException
     */
    public function getValidated(): OrderIndexRequestDTO
    {
        $requestParams = $this->validated();

        /* @var $filter \App\Helpers\RequestFilterHelper */
        $filter = resolve(RequestFilterHelperInterface::class, [
            HelperServiceProvider::PARAM_REQUEST_PARAMS => $requestParams,
        ]);

        $paginationDTO = new PaginationDTO(
            $requestParams[PaginationEnum::Start->value],
            $requestParams[PaginationEnum::End->value],
            OrderColumn::from($requestParams[PaginationEnum::SortColumn->value]),
            SortTypeEnum::from($requestParams[PaginationEnum::SortType->value]),
            $filter->checkRequestParam(PaginationEnum::Ids),
        );

        return new OrderIndexRequestDTO(
            $paginationDTO,
            $filter->checkRequestParam(OrderIndexRequestParamEnum::RentalDate),
            $filter->checkRequestParam(OrderIndexRequestParamEnum::UserName),
            $filter->checkRequestParam(OrderIndexRequestParamEnum::AgencyName),
            $filter->checkRequestParam(OrderIndexRequestParamEnum::StartDate),
            $filter->checkRequestParam(OrderIndexRequestParamEnum::EndDate),
            OrderStatusEnum::tryFrom($filter->checkRequestParam(OrderIndexRequestParamEnum::Status)),
            $filter->filterBooleanRequestParam(OrderIndexRequestParamEnum::IsConfirmed),
            $filter->filterBooleanRequestParam(OrderIndexRequestParamEnum::IsChecked),
            $filter->filterBooleanRequestParam(OrderIndexRequestParamEnum::AdminNote),
        );
    }
}
