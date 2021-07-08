<?php

namespace Tests\Feature\AdminPanel\Order;

use App\Models\Agency;
use App\Models\Order;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Response;
use Tests\TestCase;

class IndexOrderControllerTest extends TestCase
{
    use DatabaseTransactions;

    private Order $order;

    protected function setUp(): void
    {
        parent::setUp();

        $this->order = Order::factory()->create();
    }

    public function getDataProviderSuccessful(): array
    {
        return [
            'successful' => [
                'request' => [
                    '_start' => 0,
                    '_end' => 1,
                    '_sort' => 'id',
                    '_order' => 'desc',
                ]
            ],
        ];
    }

    public function getDataProviderError(): array
    {
        return [
            'error' => [
                'request' => [
                    '_start' => -1,
                    '_end' => 0,
                    '_sort' => 'ids',
                    '_order' => 'd',
                ]
            ],
        ];
    }

    /**
     * @dataProvider getDataProviderSuccessful
     */
    public function testSuccessfulExecution(array $request): void
    {
        $getters = $this->order->getters();

        $request['id'] = [$this->order->getKey()];

        $response = $this->json('GET', route('adminPanel.order.index'), $request);

        $response->assertStatus(Response::HTTP_OK)
            ->assertHeader('X-Total-Count', Order::count())
            ->assertExactJson([
                'data' => [
                    [
                        'id' => $this->order->getKey(),
                        'agency_name' => $this->order->getAgency()->getters()[Agency::COLUMN_NAME](),
                        'status' => $getters[Order::COLUMN_STATUS](),
                        'is_confirmed' => $getters[Order::COLUMN_IS_CONFIRMED](),
                        'is_checked' => $getters[Order::COLUMN_IS_CHECKED](),
                        'date_tour' => $getters[Order::COLUMN_DATE_TOUR]()->format('Y-m-d'),
                        'name' => $getters[Order::COLUMN_NAME](),
                        'scooters_count' => $getters[Order::COLUMN_SCOOTERS_COUNT](),
                        'guests_count' => $getters[Order::COLUMN_GUESTS_COUNT](),
                        'admin_note' => $getters[Order::COLUMN_ADMIN_NOTE](),
                        'photo_report' => $getters[Order::COLUMN_PHOTO_REPORT](),
                        'transfer' => $getters[Order::COLUMN_TRANSFER](),
                    ],
                ]
            ]);
    }

    /**
     * @dataProvider getDataProviderError
     */
    public function testValidationError(array $request): void
    {
        $response = $this->json('GET', route('adminPanel.order.index'), $request);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['_start', '_end', '_sort', '_order']);
    }
}
