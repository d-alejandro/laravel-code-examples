<?php

namespace App\Http\Controllers\Api\AdminPanel\Order;

use App\DTO\AdminPanel\Order\StoreOrderRequestDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminPanel\Order\StoreOrderRequest;
use App\Presenter\AdminPanel\Order\Interfaces\OrderPresenterInterface;
use App\UseCases\AdminPanel\Order\Interfaces\StoreOrderUseCaseInterface;

final class StoreOrderController extends Controller
{
    public function __construct(
        private StoreOrderUseCaseInterface $storeOrderUseCase,
        private OrderPresenterInterface $orderPresenter
    ) {
    }

    public function __invoke(StoreOrderRequest $storeOrderRequest): mixed
    {
        $storeOrderRequestDTO = new StoreOrderRequestDTO($storeOrderRequest->validated());

        $order = $this->storeOrderUseCase->execute($storeOrderRequestDTO);

        return $this->orderPresenter->present($order);
    }
}
