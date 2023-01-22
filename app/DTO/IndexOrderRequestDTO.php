<?php

namespace App\DTO;

use App\Enums\OrderStatus;
use Carbon\Carbon;

readonly class IndexOrderRequestDTO
{
    public function __construct(
        public IndexOrderPaginationDTO $indexOrderPaginationDTO,
        public Carbon|null             $rentalDate,
        public string|null             $userName,
        public string|null             $agencyName,
        public Carbon|null             $startRentalDate,
        public Carbon|null             $endRentalDate,
        public OrderStatus|null        $orderStatus,
        public bool|null               $isConfirmed,
        public bool|null               $isChecked,
        public bool|null               $hasAdminNote
    ) {
    }
}
