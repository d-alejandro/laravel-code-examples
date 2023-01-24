<?php

namespace App\Http\Requests;

use App\DTO\IndexOrderPaginationDTO;
use App\DTO\IndexOrderRequestDTO;
use App\Enums\OrderSortColumnEnum;
use App\Enums\OrderStatusEnum;
use App\Enums\SortTypeEnum;
use App\Helpers\Exceptions\BooleanFilterException;
use App\Helpers\Exceptions\EnumSerializerException;
use App\Helpers\Interfaces\EnumSerializerHelperInterface;
use App\Helpers\Interfaces\RequestFilterHelperInterface;
use App\Http\Requests\Enums\IndexOrderRequestParamEnum;
use App\Http\Requests\Enums\PaginationEnum;
use App\Http\Requests\Interfaces\IndexOrderRequestInterface;
use App\Models\Order;
use App\Providers\Bindings\HelperServiceProvider;
use Illuminate\Foundation\Http\FormRequest;

class IndexOrderRequest extends FormRequest implements IndexOrderRequestInterface
{
    /**
     * @throws EnumSerializerException
     */
    public function rules(): array
    {
        /* @var $serializer \App\Helpers\EnumSerializerHelper */
        $serializer = resolve(EnumSerializerHelperInterface::class);

        return [
            PaginationEnum::Start->value => 'required|integer|min:0',
            PaginationEnum::End->value => 'required|integer|min:1',
            PaginationEnum::SortColumn->value =>
                'required|string|in:' . $serializer->execute(OrderSortColumnEnum::class),
            PaginationEnum::SortType->value => 'required|string|in:' . $serializer->execute(SortTypeEnum::class),
            PaginationEnum::Ids->value =>
                'sometimes|required|array|exists:' . Order::TABLE_NAME . ',' . Order::COLUMN_ID,
            PaginationEnum::Ids->value . '.*' => 'required|integer|min:1',
            IndexOrderRequestParamEnum::RentalDate->value => 'sometimes|required|date',
            IndexOrderRequestParamEnum::IsConfirmed->value => 'sometimes|required|string|in:true,false',
            IndexOrderRequestParamEnum::IsChecked->value => 'sometimes|required|string|in:true,false',
            IndexOrderRequestParamEnum::Status->value =>
                'sometimes|required|string|in:' . $serializer->execute(OrderStatusEnum::class),
            IndexOrderRequestParamEnum::UserName->value => 'sometimes|required|string',
            IndexOrderRequestParamEnum::AgencyName->value => 'sometimes|required|string',
            IndexOrderRequestParamEnum::AdminNote->value => 'sometimes|required|string|in:true,false',
            IndexOrderRequestParamEnum::StartDate->value => 'sometimes|required|date',
            IndexOrderRequestParamEnum::EndDate->value => 'sometimes|required|date',
        ];
    }

    /**
     * @throws BooleanFilterException
     */
    public function getValidated(): IndexOrderRequestDTO
    {
        $requestParams = $this->validated();

        /* @var $filter \App\Helpers\RequestFilterHelper */
        $filter = resolve(RequestFilterHelperInterface::class, [
            HelperServiceProvider::PARAM_REQUEST_PARAMS => $requestParams,
        ]);

        $indexOrderPaginationDTO = new IndexOrderPaginationDTO(
            $requestParams[PaginationEnum::Start->value],
            $requestParams[PaginationEnum::End->value],
            OrderSortColumnEnum::from(
                $requestParams[PaginationEnum::SortColumn->value]
            ),
            SortTypeEnum::from(
                $requestParams[PaginationEnum::SortType->value]
            ),
            $filter->checkRequestParam(PaginationEnum::Ids),
        );

        return new IndexOrderRequestDTO(
            $indexOrderPaginationDTO,
            $filter->checkRequestParam(IndexOrderRequestParamEnum::RentalDate),
            $filter->checkRequestParam(IndexOrderRequestParamEnum::UserName),
            $filter->checkRequestParam(IndexOrderRequestParamEnum::AgencyName),
            $filter->checkRequestParam(IndexOrderRequestParamEnum::StartDate),
            $filter->checkRequestParam(IndexOrderRequestParamEnum::EndDate),
            OrderStatusEnum::tryFrom(
                $filter->checkRequestParam(IndexOrderRequestParamEnum::Status)
            ),
            $filter->filterBooleanRequestParam(IndexOrderRequestParamEnum::IsConfirmed),
            $filter->filterBooleanRequestParam(IndexOrderRequestParamEnum::IsChecked),
            $filter->filterBooleanRequestParam(IndexOrderRequestParamEnum::AdminNote),
        );
    }
}
