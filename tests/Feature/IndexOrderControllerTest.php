<?php

namespace Tests\Feature;

use App\Enums\SortTypeEnum;
use App\Http\Requests\Enums\IndexOrderRequestParamEnum;
use App\Http\Requests\Enums\PaginationEnum;
use App\Models\Enums\OrderColumn;
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
                    PaginationEnum::Start->value => $firstPaginationItemNumber,
                    PaginationEnum::End->value => $lastPaginationItemNumber,
                    PaginationEnum::SortColumn->value => OrderColumn::Id,
                    PaginationEnum::SortType->value => SortTypeEnum::Desc,
                    IndexOrderRequestParamEnum::IsConfirmed->value => 'true',
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
