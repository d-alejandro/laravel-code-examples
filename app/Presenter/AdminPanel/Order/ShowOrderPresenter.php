<?php

namespace App\Presenter\AdminPanel\Order;

use App\Helpers\Interfaces\JsonResponseCreatorInterface;
use App\Helpers\Interfaces\JsonResponseManagerInterface;
use App\Http\Resources\AdminPanel\Order\ShowOrderResource;
use App\Models\Order;
use App\Presenter\AdminPanel\Order\Interfaces\ShowOrderPresenterInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ShowOrderPresenter implements ShowOrderPresenterInterface
{
    public function __construct(
        private JsonResponseCreatorInterface $jsonResponseCreator,
        private JsonResponseManagerInterface $jsonResponseManager
    ) {
    }

    public function present(Order $order): JsonResponse
    {
        $response = $this->jsonResponseCreator->createFromResource(ShowOrderResource::class, $order);

        $this->jsonResponseManager->setStatusCode($response, Response::HTTP_OK);

        return $response;
    }
}
