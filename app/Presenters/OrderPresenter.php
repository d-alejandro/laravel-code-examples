<?php

namespace App\Presenters;

use App\DTO\Interfaces\OrderResponseDTOInterface;
use App\Http\Resources\OrderResource;
use App\Presenters\Interfaces\OrderPresenterInterface;
use Symfony\Component\HttpFoundation\Response;

class OrderPresenter implements OrderPresenterInterface
{
    public function present(OrderResponseDTOInterface $responseDTO): mixed
    {
        return (new OrderResource($responseDTO->order))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }
}
