<?php

namespace App\Presenter\AdminPanel\Order;

use App\DTO\AdminPanel\Order\IndexOrderResponseDTO;
use App\Helpers\Interfaces\JsonResponseCreatorInterface;
use App\Helpers\Interfaces\JsonResponseManagerInterface;
use App\Http\Resources\AdminPanel\Order\IndexOrderResource;
use App\Presenter\AdminPanel\Order\Interfaces\IndexOrderPresenterInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class IndexOrderPresenter implements IndexOrderPresenterInterface
{
    private const HEADER_X_TOTAL_COUNT = 'X-Total-Count';

    public function __construct(
        private JsonResponseCreatorInterface $jsonResponseCreator,
        private JsonResponseManagerInterface $jsonResponseManager
    ) {
    }

    public function present(IndexOrderResponseDTO $indexOrderResponseDTO): JsonResponse
    {
        $response = $this->jsonResponseCreator->createFromResourceCollection(
            IndexOrderResource::class,
            $indexOrderResponseDTO->getCollection()
        );

        $this->jsonResponseManager->setHeader(
            $response,
            self::HEADER_X_TOTAL_COUNT,
            $indexOrderResponseDTO->getTotalRowCount()
        );

        $this->jsonResponseManager->setStatusCode($response, Response::HTTP_OK);

        return $response;
    }
}
