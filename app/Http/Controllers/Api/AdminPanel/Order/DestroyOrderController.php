<?php

namespace App\Http\Controllers\Api\AdminPanel\Order;

use App\Http\Controllers\Controller;
use App\Presenter\AdminPanel\Order\Interfaces\OrderPresenterInterface;
use App\UseCases\AdminPanel\Order\Interfaces\DestroyOrderUseCaseInterface;

class DestroyOrderController extends Controller
{
    public function __construct(
        private DestroyOrderUseCaseInterface $destroyOrderUseCase,
        private OrderPresenterInterface $orderPresenter
    ) {
    }

    public function __invoke(int $id): mixed
    {
        $response = $this->destroyOrderUseCase->execute($id);

        return $this->orderPresenter->present($response);
    }
}
