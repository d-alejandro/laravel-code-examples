<?php

namespace App\Services\AdminPanel\Order;

use App\DTO\AdminPanel\Order\StoreOrderDTO;
use App\DTO\AdminPanel\Order\StoreOrderRequestDTO;
use App\Models\Order;
use App\Repositories\AdminPanel\Agency\Interfaces\AgencyCreatorByNameRepositoryInterface;
use App\Repositories\AdminPanel\Order\Interfaces\OrderCreatorRepositoryInterface;
use App\Services\AdminPanel\Order\Interfaces\StoreOrderServiceInterface;
use Carbon\Carbon;

class StoreOrderService implements StoreOrderServiceInterface
{
    public function __construct(
        private AgencyCreatorByNameRepositoryInterface $agencyCreatorByNameRepository,
        private OrderCreatorRepositoryInterface $orderCreatorRepository
    ) {
    }

    public function make(StoreOrderRequestDTO $storeOrderRequestDTO): Order
    {
        $properties = $storeOrderRequestDTO->getProperties();

        $agency = $this->agencyCreatorByNameRepository->make($properties[StoreOrderRequestDTO::AGENCY_NAME]);

        $storeOrderDTO = new StoreOrderDTO($this->getColumns($properties), $agency);

        return $this->orderCreatorRepository->make($storeOrderDTO);
    }

    private function getColumns(array $properties): array
    {
        return [
            Order::COLUMN_DATE_TOUR => $this->convertStringToDate($properties[StoreOrderRequestDTO::DATE_TOUR]),
            Order::COLUMN_GUESTS_COUNT => $properties[StoreOrderRequestDTO::GUESTS_COUNT],
            Order::COLUMN_SCOOTERS_COUNT => $properties[StoreOrderRequestDTO::SCOOTERS_COUNT],
            Order::COLUMN_TRANSFER => $properties[StoreOrderRequestDTO::TRANSFER],
            Order::COLUMN_HOTEL => $properties[StoreOrderRequestDTO::HOTEL],
            Order::COLUMN_ROOM_NUMBER => $properties[StoreOrderRequestDTO::ROOM_NUMBER],
            Order::COLUMN_NAME => $properties[StoreOrderRequestDTO::NAME],
            Order::COLUMN_EMAIL => $properties[StoreOrderRequestDTO::EMAIL],
            Order::COLUMN_GENDER => $properties[StoreOrderRequestDTO::GENDER],
            Order::COLUMN_NATIONALITY => $properties[StoreOrderRequestDTO::NATIONALITY],
            Order::COLUMN_PHONE => $properties[StoreOrderRequestDTO::PHONE],
            Order::COLUMN_IS_SUBSCRIBE => $properties[StoreOrderRequestDTO::IS_SUBSCRIBE],
            Order::COLUMN_NOTE => $properties[StoreOrderRequestDTO::NOTE],
            Order::COLUMN_ADMIN_NOTE => $properties[StoreOrderRequestDTO::ADMIN_NOTE],
            Order::COLUMN_PHOTO_REPORT => $properties[StoreOrderRequestDTO::PHOTO_REPORT],
            Order::COLUMN_REFERRER => $properties[StoreOrderRequestDTO::REFERRER],
        ];
    }

    private function convertStringToDate(string $value): Carbon
    {
        return Carbon::parse($value);
    }
}
