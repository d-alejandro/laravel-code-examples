<?php

namespace App\Repositories;

use App\DTO\Interfaces\OrderResponseDTOInterface;
use App\DTO\Interfaces\OrderUpdateRequestDTOInterface;
use App\Models\Enums\OrderColumn;
use App\Repositories\Interfaces\OrderUpdateRepositoryInterface;

class OrderUpdateRepository implements OrderUpdateRepositoryInterface
{
    public function make(OrderResponseDTOInterface $responseDTO, OrderUpdateRequestDTOInterface $requestDTO): void
    {
        $order = $responseDTO->order;

        $order->setColumn(OrderColumn::GuestCount, $requestDTO->guestCount);
        $order->setColumn(OrderColumn::TransportCount, $requestDTO->transportCount);
        $order->setColumn(OrderColumn::UserName, $requestDTO->userName);
        $order->setColumn(OrderColumn::Email, $requestDTO->email);
        $order->setColumn(OrderColumn::Phone, $requestDTO->phone);
        $order->setColumn(OrderColumn::Note, $requestDTO->note);
        $order->setColumn(OrderColumn::AdminNote, $requestDTO->adminNote);

        $order->save();
    }
}
