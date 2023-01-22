<?php

namespace App\DTO;

use App\Enums\OrderStatus;
use Carbon\Carbon;

readonly class IndexOrderRequestDTO
{
    public function __construct(
        public IndexOrderPaginationDTO $indexOrderPaginationDTO,
        public Carbon|null             $rentalDate = null,
        public string|null             $userName = null,
        public string|null             $agencyName = null,
        public Carbon|null             $startRentalDate = null,
        public Carbon|null             $endRentalDate = null,
        public OrderStatus|null        $orderStatus = null,
        public bool|null               $isConfirmed = null,
        public bool|null               $isChecked = null,
        public bool|null               $hasAdminNote = null
    ) {
    }
}
