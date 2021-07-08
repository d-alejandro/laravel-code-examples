<?php

namespace App\Presenter\AdminPanel\Order;

use App\Helpers\Interfaces\JsonResponseCreatorInterface;
use App\Helpers\Interfaces\JsonResponseManagerInterface;
use App\Http\Resources\AdminPanel\Order\OrderResource;
use App\Models\Order;
use App\Presenter\AdminPanel\Order\Interfaces\OrderPresenterInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class OrderPresenter implements OrderPresenterInterface
{
    public function __construct(
        private JsonResponseCreatorInterface $jsonResponseCreator,
        private JsonResponseManagerInterface $jsonResponseManager
    ) {
    }

    public function present(Order $order): JsonResponse
    {
        $response = $this->jsonResponseCreator->createFromResource(OrderResource::class, $order);

        $this->jsonResponseManager->setStatusCode($response, Response::HTTP_OK);

        return $response;
    }
}
