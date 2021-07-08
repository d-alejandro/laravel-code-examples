<?php

namespace App\Http\Controllers\Api\AdminPanel\Order;

use App\DTO\AdminPanel\Order\UpdateOrderRequestDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminPanel\Order\UpdateOrderRequest;
use App\Presenter\AdminPanel\Order\Interfaces\OrderPresenterInterface;
use App\UseCases\AdminPanel\Order\Interfaces\UpdateOrderUseCaseInterface;

final class UpdateOrderController extends Controller
{
    public function __construct(
        private UpdateOrderUseCaseInterface $updateOrderUseCase,
        private OrderPresenterInterface $orderPresenter
    ) {
    }

    public function __invoke(UpdateOrderRequest $updateOrderRequest, int $id): mixed
    {
        $updateOrderRequestDTO = new UpdateOrderRequestDTO($updateOrderRequest->validated());

        $order = $this->updateOrderUseCase->execute($updateOrderRequestDTO, $id);

        return $this->orderPresenter->present($order);
    }
}
