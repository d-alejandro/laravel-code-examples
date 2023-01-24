<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Interfaces\IndexOrderRequestInterface;
use App\Presenter\Interfaces\IndexOrderPresenterInterface;
use App\UseCases\Interfaces\IndexOrderUseCaseInterface;

final class IndexOrderController extends Controller
{
    public function __construct(
        private IndexOrderUseCaseInterface   $useCase,
        private IndexOrderPresenterInterface $presenter
    ) {
    }

    public function __invoke(IndexOrderRequestInterface $request): mixed
    {
        $requestDTO = $request->getValidated();

        $responseDTO = $this->useCase->execute($requestDTO);

        return $this->presenter->present($responseDTO);
    }
}
