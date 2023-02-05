<?php

namespace App\Presenters;

use App\DTO\Interfaces\OrderStoreResponseDTOInterface;
use App\Http\Resources\OrderResource;
use App\Presenters\Interfaces\OrderStorePresenterInterface;
use Symfony\Component\HttpFoundation\Response;

class OrderStorePresenter implements OrderStorePresenterInterface
{
    public function present(OrderStoreResponseDTOInterface $responseDTO): mixed
    {
        return (new OrderResource($responseDTO->order))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }
}
