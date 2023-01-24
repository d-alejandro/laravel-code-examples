<?php

namespace App\DTO;

use App\DTO\Interfaces\IndexOrderResponseDTOInterface;
use Illuminate\Database\Eloquent\Collection;

readonly class IndexOrderResponseDTO implements IndexOrderResponseDTOInterface
{
    public function __construct(
        public Collection $collection,
        public int        $totalRowCount
    ) {
    }
}
