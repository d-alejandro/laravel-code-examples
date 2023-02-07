<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Presenters\Interfaces\OrderPresenterInterface;
use App\UseCases\Interfaces\OrderShowUseCaseInterface;

final class OrderShowController extends Controller
{
    public function __construct(
        private OrderShowUseCaseInterface $useCase,
        private OrderPresenterInterface   $presenter
    ) {
    }

    public function __invoke(int $id): mixed
    {
        $response = $this->useCase->execute($id);

        return $this->presenter->present($response);
    }
}
