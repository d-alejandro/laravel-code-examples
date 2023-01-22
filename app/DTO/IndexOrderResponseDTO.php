<?php

namespace App\DTO;

use Illuminate\Database\Eloquent\Collection;

readonly class IndexOrderResponseDTO
{
    public function __construct(
        public Collection $collection,
        public int        $totalRowCount
    ) {
    }
}
