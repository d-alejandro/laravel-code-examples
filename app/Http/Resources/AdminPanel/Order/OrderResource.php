<?php

namespace App\Http\Resources\AdminPanel\Order;

use App\Models\Agency;
use App\Models\Order;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'date_tour' => $getters[Order::COLUMN_DATE_TOUR]()?->format('Y-m-d'),
            'guests_count' => $getters[Order::COLUMN_GUESTS_COUNT](),
            'scooters_count' => $getters[Order::COLUMN_SCOOTERS_COUNT](),
            'transfer' => $getters[Order::COLUMN_TRANSFER](),
            'hotel' => $getters[Order::COLUMN_HOTEL](),
            'room_number' => $getters[Order::COLUMN_ROOM_NUMBER](),
            'name' => $getters[Order::COLUMN_NAME](),
            'email' => $getters[Order::COLUMN_EMAIL](),
            'gender' => $getters[Order::COLUMN_GENDER](),
            'nationality' => $getters[Order::COLUMN_NATIONALITY](),
            'phone' => $getters[Order::COLUMN_PHONE](),
            'is_subscribe' => $getters[Order::COLUMN_IS_SUBSCRIBE](),
            'note' => $getters[Order::COLUMN_NOTE](),
            'admin_note' => $getters[Order::COLUMN_ADMIN_NOTE](),
            'photo_report' => $getters[Order::COLUMN_PHOTO_REPORT](),
            'referrer' => $getters[Order::COLUMN_REFERRER](),
            'created_at' => $getters[Order::COLUMN_CREATED_AT]()?->format('Y-m-d'),
            'updated_at' => $getters[Order::COLUMN_CREATED_AT]()?->format('Y-m-d'),
        ];
    }
}
