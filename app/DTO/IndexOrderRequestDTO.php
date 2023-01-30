<?php

namespace App\DTO;

use App\DTO\Interfaces\IndexOrderRequestDTOInterface;
use App\Enums\OrderStatusEnum;
use Carbon\Carbon;

readonly class IndexOrderRequestDTO implements IndexOrderRequestDTOInterface
{
    public function __construct(
        public IndexPaginationDTO   $paginationDTO,
        public Carbon|null          $rentalDate = null,
        public string|null          $userName = null,
        public string|null          $agencyName = null,
        public Carbon|null          $startRentalDate = null,
        public Carbon|null          $endRentalDate = null,
        public OrderStatusEnum|null $status = null,
        public bool|null            $isConfirmed = null,
        public bool|null            $isChecked = null,
        public bool|null            $hasAdminNote = null
    ) {
    }
}
