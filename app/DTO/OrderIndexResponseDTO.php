<?php

namespace App\DTO;

use App\DTO\Interfaces\OrderIndexResponseDTOInterface;
use Illuminate\Support\Collection;

readonly class OrderIndexResponseDTO implements OrderIndexResponseDTOInterface
{
    public function __construct(
        public Collection $collection,
        public int        $totalRowCount
    ) {
    }
}
