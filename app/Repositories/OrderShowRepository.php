<?php

namespace App\Repositories;

use App\DTO\Interfaces\OrderResponseDTOInterface;
use App\DTO\OrderResponseDTO;
use App\Repositories\Criteria\Interfaces\CriteriaApplierInterface;
use App\Repositories\Interfaces\OrderShowRepositoryInterface;

class OrderShowRepository implements OrderShowRepositoryInterface
{
    public function __construct(
        private CriteriaApplierInterface $criteriaApplier
    ) {
    }

    public function make(int $id): OrderResponseDTOInterface
    {
        /* @var $order \App\Models\Order */
        $order = $this->criteriaApplier->findOrFail($id);

        return new OrderResponseDTO($order);
    }
}
