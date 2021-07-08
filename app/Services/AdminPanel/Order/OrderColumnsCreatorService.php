<?php

namespace App\Services\AdminPanel\Order;

use App\DTO\AdminPanel\Order\UpdateOrderRequestDTO;
use App\Models\Order;
use App\Services\AdminPanel\Order\Interfaces\OrderColumnsCreatorServiceInterface;

class OrderColumnsCreatorService implements OrderColumnsCreatorServiceInterface
{
    public function make(array $properties): array
    {
        return [
            Order::COLUMN_GUESTS_COUNT => $properties[UpdateOrderRequestDTO::GUESTS_COUNT],
            Order::COLUMN_SCOOTERS_COUNT => $properties[UpdateOrderRequestDTO::SCOOTERS_COUNT],
            Order::COLUMN_TRANSFER => $properties[UpdateOrderRequestDTO::TRANSFER],
            Order::COLUMN_HOTEL => $properties[UpdateOrderRequestDTO::HOTEL],
            Order::COLUMN_ROOM_NUMBER => $properties[UpdateOrderRequestDTO::ROOM_NUMBER],
            Order::COLUMN_NAME => $properties[UpdateOrderRequestDTO::NAME],
            Order::COLUMN_EMAIL => $properties[UpdateOrderRequestDTO::EMAIL],
            Order::COLUMN_GENDER => $properties[UpdateOrderRequestDTO::GENDER],
            Order::COLUMN_NATIONALITY => $properties[UpdateOrderRequestDTO::NATIONALITY],
            Order::COLUMN_PHONE => $properties[UpdateOrderRequestDTO::PHONE],
            Order::COLUMN_IS_SUBSCRIBE => $properties[UpdateOrderRequestDTO::IS_SUBSCRIBE],
            Order::COLUMN_NOTE => $properties[UpdateOrderRequestDTO::NOTE],
            Order::COLUMN_ADMIN_NOTE => $properties[UpdateOrderRequestDTO::ADMIN_NOTE],
            Order::COLUMN_PHOTO_REPORT => $properties[UpdateOrderRequestDTO::PHOTO_REPORT],
        ];
    }
}
