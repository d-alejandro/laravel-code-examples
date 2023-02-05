<?php

namespace App\DTO;

use App\DTO\Interfaces\OrderStoreRequestDTOInterface;

readonly class OrderStoreRequestDTO implements OrderStoreRequestDTOInterface
{
    public function __construct(
        public string      $agencyName,
        public string      $rentalDate,
        public int         $guestCount,
        public int         $transportCount,
        public string      $userName,
        public string      $email,
        public string      $phone,
        public string|null $note = null,
        public string|null $adminNote = null
    ) {
    }
}
