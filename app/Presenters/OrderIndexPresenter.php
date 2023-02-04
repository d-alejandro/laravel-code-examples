<?php

namespace App\Presenters;

use App\DTO\Interfaces\OrderIndexResponseDTOInterface;
use App\Http\Resources\OrderIndexResource;
use App\Presenters\Interfaces\OrderIndexPresenterInterface;
use Symfony\Component\HttpFoundation\Response;

class OrderIndexPresenter implements OrderIndexPresenterInterface
{
    public const HEADER_X_TOTAL_COUNT = 'X-Total-Count';

    public function present(OrderIndexResponseDTOInterface $responseDTO): mixed
    {
        return OrderIndexResource::collection($responseDTO->collection)
            ->response()
            ->header(self::HEADER_X_TOTAL_COUNT, $responseDTO->totalRowCount)
            ->setStatusCode(Response::HTTP_OK);
    }
}
