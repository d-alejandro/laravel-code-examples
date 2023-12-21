<?php

namespace App\Presenters;

use App\DTO\Interfaces\OrderResponseDTOInterface;
use App\Http\Resources\OrderResource;
use App\Presenters\Interfaces\OrderPresenterInterface;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class OrderCreatedPresenter implements OrderPresenterInterface
{
    public function present(OrderResponseDTOInterface $responseDTO): JsonResponse
    {
        return (new OrderResource($responseDTO->order))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }
}
