<?php

namespace App\DTO;

use App\DTO\Interfaces\IndexOrderRequestDTOInterface;
use App\Enums\OrderStatusEnum;

readonly class IndexOrderRequestDTO implements IndexOrderRequestDTOInterface
{
    public function __construct(
        public IndexPaginationDTO   $paginationDTO,
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
