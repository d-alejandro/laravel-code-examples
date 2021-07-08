<?php

namespace Tests\Feature\AdminPanel\Order;

use App\Models\Agency;
use App\Models\Order;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class UpdateOrderControllerTest extends TestCase
{
    use DatabaseTransactions;

    private Order $order;

    protected function setUp(): void
    {
        parent::setUp();

        $this->order = Order::factory()->create();
    }

    public function getDataProvider(): array
    {
        $request = [
            'guests_count' => 1,
            'scooters_count' => 1,
            'transfer' => 'transferTest',
            'hotel' => 'hotelTest',
            'room_number' => 'test',
            'name' => 'nameTest',
            'email' => 'test@test.test',
            'gender' => 'male',
            'nationality' => 'nationalityTest',
            'phone' => '38000000000',
            'is_subscribe' => 'true',
            'note' => 'noteTest',
            'admin_note' => 'adminNoteTest',
            'photo_report' => 'photoReportTestUrl',
        ];

        return [
            'single' => [
                'request' => $request,
            ],
        ];
    }

    /**
     * @dataProvider getDataProvider
     */
    public function testSuccessfulExecution(array $request): void
    {
        $getters = $this->order->getters();

        $id = $this->order->getKey();

        $response = $this->json('PUT', route('adminPanel.order.update', ['id' => $id]), $request);

        $response->assertStatus(Response::HTTP_OK)
            ->assertExactJson([
                'data' => [
                    'id' => $id,
                    'agency_name' => $this->order->getAgency()->getters()[Agency::COLUMN_NAME](),
                    'date_tour' => $getters[Order::COLUMN_DATE_TOUR]()->format('Y-m-d'),
                    'guests_count' => $request['guests_count'],
                    'scooters_count' => $request['scooters_count'],
                    'transfer' => $request['transfer'],
                    'hotel' => $request['hotel'],
                    'room_number' => $request['room_number'],
                    'name' => $request['name'],
                    'email' => $request['email'],
                    'gender' => $request['gender'],
                    'nationality' => $request['nationality'],
                    'phone' => $request['phone'],
                    'is_subscribe' => true,
                    'note' => $request['note'],
                    'admin_note' => $request['admin_note'],
                    'photo_report' => $request['photo_report'],
                    'referrer' => $getters[Order::COLUMN_REFERRER](),
                    'created_at' => $getters[Order::COLUMN_UPDATED_AT]()->format('Y-m-d'),
                    'updated_at' => $getters[Order::COLUMN_UPDATED_AT]()->format('Y-m-d'),
                ],
            ]);
    }

    /**
     * @dataProvider getDataProvider
     */
    public function testError(array $request): void
    {
        Log::shouldReceive('error', 'debug');

        $response = $this->json('PUT', route('adminPanel.order.update', ['id' => 0]), $request);

        $response->assertStatus(Response::HTTP_BAD_REQUEST)
            ->assertJsonStructure(['message']);
    }
}
