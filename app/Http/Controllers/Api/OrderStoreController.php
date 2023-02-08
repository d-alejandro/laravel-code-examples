<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Interfaces\OrderStoreRequestInterface;
use App\Presenters\Interfaces\OrderPresenterInterface;
use App\UseCases\Interfaces\OrderStoreUseCaseInterface;

final class OrderStoreController extends Controller
{
    public function __construct(
        private OrderStoreUseCaseInterface $useCase,
        private OrderPresenterInterface    $presenter
    ) {
    }

    public function __invoke(OrderStoreRequestInterface $request): mixed
    {
        $requestDTO = $request->getValidated();

        $responseDTO = $this->useCase->execute($requestDTO);

        return $this->presenter->present($responseDTO);
    }
}
