<?php

namespace App\Http\Resources\AdminPanel\Order;

use App\Models\Agency;
use App\Models\Order;
use Illuminate\Http\Resources\Json\JsonResource;

class IndexOrderResource extends JsonResource
{
    /**
     * @param \Illuminate\Http\Request $request
     */
    public function toArray($request): array
    {
        /* @var Order $this */
        $getters = $this->getters();

        return [
            'id' => $this->getKey(),
            'agency_name' => $this->getAgency()->getters()[Agency::COLUMN_NAME](),
            'status' => $getters[Order::COLUMN_STATUS](),
            'is_confirmed' => $getters[Order::COLUMN_IS_CONFIRMED](),
            'is_checked' => $getters[Order::COLUMN_IS_CHECKED](),
            'date_tour' => $getters[Order::COLUMN_DATE_TOUR]()?->format('Y-m-d'),
            'name' => $getters[Order::COLUMN_NAME](),
            'scooters_count' => $getters[Order::COLUMN_SCOOTERS_COUNT](),
            'guests_count' => $getters[Order::COLUMN_GUESTS_COUNT](),
            'admin_note' => $getters[Order::COLUMN_ADMIN_NOTE](),
            'photo_report' => $getters[Order::COLUMN_PHOTO_REPORT](),
            'transfer' => $getters[Order::COLUMN_TRANSFER](),
        ];
    }
}
