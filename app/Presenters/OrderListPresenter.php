<?php

namespace App\Presenters;

use App\DTO\Interfaces\OrderIndexResponseDTOInterface;
use App\Http\Resources\OrderIndexResource;
use App\Presenters\Interfaces\OrderListPresenterInterface;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class OrderListPresenter implements OrderListPresenterInterface
{
    public const HEADER_X_TOTAL_COUNT = 'X-Total-Count';

    public function present(OrderIndexResponseDTOInterface $responseDTO): JsonResponse
    {
        return OrderIndexResource::collection($responseDTO->collection)
            ->response()
            ->header(self::HEADER_X_TOTAL_COUNT, $responseDTO->totalRowCount)
            ->setStatusCode(Response::HTTP_OK);
    }
}
