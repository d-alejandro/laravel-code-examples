<?php

namespace App\Http\Resources;

use App\Http\Resources\Enums\OrderIndexResourceEnum;
use App\Models\Enums\AgencyColumn;
use App\Models\Enums\OrderColumn;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderIndexResource extends JsonResource
{
    /**
     * @param \Illuminate\Http\Request $request
     */
    public function toArray($request): array
    {
        /* @var $this \App\Models\Order */
        return [
            OrderIndexResourceEnum::Id->value => (int)$this->getKey(),
            OrderIndexResourceEnum::AgencyName->value => $this->getAgency()->getColumn(AgencyColumn::Name),
            OrderIndexResourceEnum::Status->value => $this->getColumn(OrderColumn::Status),
            OrderIndexResourceEnum::IsConfirmed->value => (bool)$this->getColumn(OrderColumn::IsConfirmed),
            OrderIndexResourceEnum::IsChecked->value => (bool)$this->getColumn(OrderColumn::IsChecked),
            OrderIndexResourceEnum::RentalDate->value => $this->getColumn(OrderColumn::RentalDate)->format('d-m-Y'),
            OrderIndexResourceEnum::UserName->value => $this->getColumn(OrderColumn::UserName),
            OrderIndexResourceEnum::TransportCount->value => (int)$this->getColumn(OrderColumn::TransportCount),
            OrderIndexResourceEnum::GuestCount->value => (int)$this->getColumn(OrderColumn::GuestCount),
            OrderIndexResourceEnum::AdminNote->value => $this->getColumn(OrderColumn::AdminNote),
        ];
    }
}
