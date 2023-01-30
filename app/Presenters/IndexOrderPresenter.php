<?php

namespace App\Presenters;

use App\DTO\Interfaces\IndexOrderResponseDTOInterface;
use App\Http\Resources\IndexOrderResource;
use App\Presenters\Interfaces\IndexOrderPresenterInterface;
use Symfony\Component\HttpFoundation\Response;

class IndexOrderPresenter implements IndexOrderPresenterInterface
{
    public const HEADER_X_TOTAL_COUNT = 'X-Total-Count';

    public function present(IndexOrderResponseDTOInterface $indexOrderResponseDTO): mixed
    {
        return IndexOrderResource::collection($indexOrderResponseDTO->collection)
            ->response()
            ->header(self::HEADER_X_TOTAL_COUNT, $indexOrderResponseDTO->totalRowCount)
            ->setStatusCode(Response::HTTP_OK);
    }
}
