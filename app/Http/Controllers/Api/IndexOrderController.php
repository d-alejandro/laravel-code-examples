<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\IndexOrderRequest;
use App\Presenter\Interfaces\IndexOrderPresenterInterface;
use App\UseCases\Interfaces\IndexOrderUseCaseInterface;

final class IndexOrderController extends Controller
{
    public function __construct(
        private IndexOrderUseCaseInterface   $useCase,
        private IndexOrderPresenterInterface $presenter
    ) {
    }

    public function __invoke(IndexOrderRequest $request): mixed
    {
        $indexOrderRequestDTO = $request->getValidated();

        $indexOrderResponseDTO = $this->useCase->execute($indexOrderRequestDTO);

        return $this->presenter->present($indexOrderResponseDTO);
    }
}
