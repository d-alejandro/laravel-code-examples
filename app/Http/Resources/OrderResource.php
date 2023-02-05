<?php

namespace App\Http\Resources;

use App\Http\Resources\Enums\OrderResourceEnum;
use App\Models\Enums\AgencyColumn;
use App\Models\Enums\OrderColumn;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * @param \Illuminate\Http\Request $request
     */
    public function toArray($request): array
    {
        /* @var $this \App\Models\Order */
        return [
            OrderResourceEnum::Id->value => (int)$this->getKey(),
            OrderResourceEnum::AgencyName->value => $this->getAgency()->getColumn(AgencyColumn::Name),
            OrderResourceEnum::Status->value => $this->getColumn(OrderColumn::Status),
            OrderResourceEnum::IsConfirmed->value => (bool)$this->getColumn(OrderColumn::IsConfirmed),
            OrderResourceEnum::IsChecked->value => (bool)$this->getColumn(OrderColumn::IsChecked),
            OrderResourceEnum::RentalDate->value => $this->getColumn(OrderColumn::RentalDate)->format('d-m-Y'),
            OrderResourceEnum::UserName->value => $this->getColumn(OrderColumn::UserName),
            OrderResourceEnum::TransportCount->value => (int)$this->getColumn(OrderColumn::TransportCount),
            OrderResourceEnum::GuestCount->value => (int)$this->getColumn(OrderColumn::GuestCount),
            OrderResourceEnum::AdminNote->value => $this->getColumn(OrderColumn::AdminNote),
            OrderResourceEnum::Note->value => $this->getColumn(OrderColumn::AdminNote),
            OrderResourceEnum::Email->value => $this->getColumn(OrderColumn::Email),
            OrderResourceEnum::Phone->value => $this->getColumn(OrderColumn::Phone),
            OrderResourceEnum::CreatedAt->value => $this->getColumn(OrderColumn::CreatedAt)->format('d-m-Y'),
            OrderResourceEnum::UpdatedAt->value => $this->getColumn(OrderColumn::UpdatedAt)->format('d-m-Y'),
        ];
    }
}
