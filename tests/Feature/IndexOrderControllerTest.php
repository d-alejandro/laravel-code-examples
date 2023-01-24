<?php

namespace Tests\Feature;

use App\Enums\OrderSortColumnEnum;
use App\Enums\SortTypeEnum;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class IndexOrderControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function getDataProviderSuccessful(): array
    {
        $firstPaginationItemNumber = 0;
        $lastPaginationItemNumber = 1;

        return [
            'successful' => [
                'request' => [
                    'start' => $firstPaginationItemNumber,
                    'end' => $lastPaginationItemNumber,
                    'sort_column' => OrderSortColumnEnum::Id,
                    'sort_type' => SortTypeEnum::Desc,
                ]
            ],
        ];
    }

    /**
     * @dataProvider getDataProviderSuccessful
     */
    public function testSuccessfulExecution(array $request): void
    {
        $response = $this->json('GET', route('adminPanel.order.index'), $request);

        $response->assertStatus(Response::HTTP_OK);
    }
}
