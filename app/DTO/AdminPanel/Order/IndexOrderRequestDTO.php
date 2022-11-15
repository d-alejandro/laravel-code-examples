<?php

namespace App\DTO\AdminPanel\Order;

use App\Enums\OrderStatus;
use Carbon\Carbon;

class IndexOrderRequestDTO
{
    public function __construct(
        public readonly ?Carbon      $rentalDate = null,
        public readonly ?string      $transportName = null,
        public readonly ?string      $agencyName = null,
        public readonly ?Carbon      $startRentalDate = null,
        public readonly ?Carbon      $endRentalDate = null,
        public readonly ?OrderStatus $status = null,
        public readonly ?bool        $isConfirmed = null,
        public readonly ?bool        $isChecked = null,
        public readonly ?bool        $hasAdminNote = null
    ) {
    }
}
