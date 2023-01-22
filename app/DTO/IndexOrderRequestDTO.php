<?php

namespace App\DTO;

use App\Enums\OrderStatus;
use Carbon\Carbon;

readonly class IndexOrderRequestDTO
{
    public function __construct(
        public IndexOrderPaginationDTO $indexOrderPaginationDTO,
        public ?Carbon                 $rentalDate = null,
        public ?string                 $userName = null,
        public ?string                 $agencyName = null,
        public ?Carbon                 $startRentalDate = null,
        public ?Carbon                 $endRentalDate = null,
        public ?OrderStatus            $orderStatus = null,
        public ?bool                   $isConfirmed = null,
        public ?bool                   $isChecked = null,
        public ?bool                   $hasAdminNote = null
    ) {
    }
}
