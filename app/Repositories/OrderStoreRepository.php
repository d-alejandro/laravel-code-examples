<?php

namespace App\Repositories;

use App\DTO\Interfaces\OrderStoreRequestDTOInterface;
use App\DTO\OrderResponseDTO;
use App\Models\Enums\OrderColumn;
use App\Models\Order;
use App\Repositories\Interfaces\AgencyByNameCreatorRepositoryInterface;
use App\Repositories\Interfaces\OrderStoreRepositoryInterface;
use Carbon\Carbon;

class OrderStoreRepository implements OrderStoreRepositoryInterface
{
    public function __construct(
        private Order                                  $order,
        private AgencyByNameCreatorRepositoryInterface $agencyCreatorRepository
    ) {
    }

    public function make(OrderStoreRequestDTOInterface $requestDTO): OrderResponseDTO
    {
        $agency = $this->agencyCreatorRepository->make($requestDTO->agencyName);
        $this->order->setAgency($agency);

        $rentalDate = Carbon::parse($requestDTO->rentalDate);

        $this->order->setColumn(OrderColumn::RentalDate, $rentalDate);
        $this->order->setColumn(OrderColumn::GuestCount, $requestDTO->guestCount);
        $this->order->setColumn(OrderColumn::TransportCount, $requestDTO->transportCount);
        $this->order->setColumn(OrderColumn::UserName, $requestDTO->userName);
        $this->order->setColumn(OrderColumn::Email, $requestDTO->email);
        $this->order->setColumn(OrderColumn::Phone, $requestDTO->phone);
        $this->order->setColumn(OrderColumn::Note, $requestDTO->note);
        $this->order->setColumn(OrderColumn::AdminNote, $requestDTO->adminNote);

        $this->order->save();

        return new OrderResponseDTO($this->order);
    }
}
