<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\IndexOrderRequest;
use App\Presenter\Interfaces\IndexOrderPresenterInterface;
use App\UseCases\Interfaces\IndexOrderUseCaseInterface;

final class IndexOrderController extends Controller
{
    public function __construct(
        private IndexOrderUseCaseInterface $indexOrderUseCase,
        private IndexOrderPresenterInterface $indexOrderPresenter
    ) {
    }

    public function __invoke(IndexOrderRequest $request): mixed
    {
        $indexOrderRequestDTO = $request->getValidated();

        $indexOrderResponseDTO = $this->indexOrderUseCase->execute($indexOrderRequestDTO);

        return $this->indexOrderPresenter->present($indexOrderResponseDTO);
    }
}
