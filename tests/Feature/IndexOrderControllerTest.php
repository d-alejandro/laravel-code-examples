<?php

namespace Tests\Feature;

use App\Enums\OrderSortColumn;
use App\Enums\SortType;
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
                    '_start' => $firstPaginationItemNumber,
                    '_end' => $lastPaginationItemNumber,
                    '_sort' => OrderSortColumn::Id,
                    '_order' => SortType::Desc,
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
