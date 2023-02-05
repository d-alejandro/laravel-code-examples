<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Interfaces\OrderIndexRequestInterface;
use App\Presenters\Interfaces\OrderIndexPresenterInterface;
use App\UseCases\Interfaces\OrderIndexUseCaseInterface;

final class OrderIndexController extends Controller
{
    public function __construct(
        private OrderIndexUseCaseInterface   $useCase,
        private OrderIndexPresenterInterface $presenter
    ) {
    }

    public function __invoke(OrderIndexRequestInterface $request): mixed
    {
        $requestDTO = $request->getValidated();

        $responseDTO = $this->useCase->execute($requestDTO);

        return $this->presenter->present($responseDTO);
    }
}
