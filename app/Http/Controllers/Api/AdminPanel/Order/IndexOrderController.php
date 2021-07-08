<?php

namespace App\Http\Controllers\Api\AdminPanel\Order;

use App\DTO\AdminPanel\Order\IndexOrderRequestDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminPanel\Order\IndexOrderRequest;
use App\Presenter\AdminPanel\Order\Interfaces\IndexOrderPresenterInterface;
use App\UseCases\AdminPanel\Order\Interfaces\IndexOrderUseCaseInterface;

final class IndexOrderController extends Controller
{
    public function __construct(
        private IndexOrderUseCaseInterface $indexOrderUseCase,
        private IndexOrderPresenterInterface $indexOrderPresenter
    ) {
    }

    public function __invoke(IndexOrderRequest $request): mixed
    {
        $indexOrderRequestDTO = new IndexOrderRequestDTO($request->validated());

        $indexOrderResponseDTO = $this->indexOrderUseCase->execute($indexOrderRequestDTO);

        return $this->indexOrderPresenter->present($indexOrderResponseDTO);
    }
}
