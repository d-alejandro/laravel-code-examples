<?php

namespace App\Http\Controllers\Api\AdminPanel\Order;

use App\Http\Controllers\Controller;
use App\Presenter\AdminPanel\Order\Interfaces\ShowOrderPresenterInterface;
use App\UseCases\AdminPanel\Order\Interfaces\ShowOrderUseCaseInterface;

final class ShowOrderController extends Controller
{
    public function __construct(
        private ShowOrderUseCaseInterface $showOrderUseCase,
        private ShowOrderPresenterInterface $showOrderPresenter
    ) {
    }

    public function __invoke(int $id): mixed
    {
        $response = $this->showOrderUseCase->execute($id);

        return $this->showOrderPresenter->present($response);
    }
}
