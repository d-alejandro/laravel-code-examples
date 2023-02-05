<?php

namespace App\DTO;

use App\DTO\Interfaces\OrderIndexRequestDTOInterface;
use App\Enums\OrderStatusEnum;

readonly class OrderIndexRequestDTO implements OrderIndexRequestDTOInterface
{
    public function __construct(
        public PaginationDTO        $paginationDTO,
        public string|null          $rentalDate = null,
        public string|null          $userName = null,
        public string|null          $agencyName = null,
        public string|null          $startRentalDate = null,
        public string|null          $endRentalDate = null,
        public OrderStatusEnum|null $status = null,
        public bool|null            $isConfirmed = null,
        public bool|null            $isChecked = null,
        public bool|null            $hasAdminNote = null
    ) {
    }
}
