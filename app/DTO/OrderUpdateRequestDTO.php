<?php

namespace App\DTO;

use App\DTO\Interfaces\OrderUpdateRequestDTOInterface;

readonly class OrderUpdateRequestDTO implements OrderUpdateRequestDTOInterface
{
    public function __construct(
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
