<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Interfaces\OrderUpdateRequestInterface;
use App\Presenters\Interfaces\OrderPresenterInterface;
use App\UseCases\Interfaces\OrderUpdateUseCaseInterface;

final class OrderUpdateController extends Controller
{
    public function __construct(
        private OrderUpdateUseCaseInterface $useCase,
        private OrderPresenterInterface     $presenter
    ) {
    }

    public function __invoke(OrderUpdateRequestInterface $request, int $id): mixed
    {
        $requestDTO = $request->getValidated();

        $response = $this->useCase->execute($requestDTO, $id);

        return $this->presenter->present($response);
    }
}
