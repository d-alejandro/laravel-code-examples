<?php

namespace App\Http\Resources;

use App\Http\Resources\Enums\IndexOrderResourceEnum;
use App\Models\Enums\AgencyColumn;
use App\Models\Enums\OrderColumn;
use Illuminate\Http\Resources\Json\JsonResource;

class IndexOrderResource extends JsonResource
{
    /**
     * @param \Illuminate\Http\Request $request
     */
    public function toArray($request): array
    {
        /* @var $this \App\Models\Order */
        return [
            IndexOrderResourceEnum::Id->value => (int)$this->getKey(),
            IndexOrderResourceEnum::AgencyName->value => $this->getAgency()->getColumn(AgencyColumn::Name),
            IndexOrderResourceEnum::Status->value => $this->getColumn(OrderColumn::Status),
            IndexOrderResourceEnum::IsConfirmed->value => (bool)$this->getColumn(OrderColumn::IsConfirmed),
            IndexOrderResourceEnum::IsChecked->value => (bool)$this->getColumn(OrderColumn::IsChecked),
            IndexOrderResourceEnum::RentalDate->value => $this->getColumn(OrderColumn::RentalDate)->format('d-m-Y'),
            IndexOrderResourceEnum::UserName->value => $this->getColumn(OrderColumn::UserName),
            IndexOrderResourceEnum::TransportCount->value => (int)$this->getColumn(OrderColumn::TransportCount),
            IndexOrderResourceEnum::GuestsCount->value => (int)$this->getColumn(OrderColumn::GuestsCount),
            IndexOrderResourceEnum::AdminNote->value => $this->getColumn(OrderColumn::AdminNote),
        ];
    }
}
