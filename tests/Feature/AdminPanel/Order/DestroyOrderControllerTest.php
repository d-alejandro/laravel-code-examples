<?php

namespace Tests\Feature\AdminPanel\Order;

use App\Models\Agency;
use App\Models\Order;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class DestroyOrderControllerTest extends TestCase
{
    use DatabaseTransactions;

    private Order $order;

    protected function setUp(): void
    {
        parent::setUp();

        $this->order = Order::factory()->create();
    }

    public function testSuccessfulExecution(): void
    {
        $getters = $this->order->getters();

        $id = $this->order->getKey();

        $response = $this->json('DELETE', route('adminPanel.order.destroy', ['id' => $id]));

        $response->assertStatus(Response::HTTP_OK)
            ->assertExactJson([
                'data' => [
                    'id' => $id,
                    'agency_name' => $this->order->getAgency()->getters()[Agency::COLUMN_NAME](),
                    'date_tour' => $getters[Order::COLUMN_DATE_TOUR]()->format('Y-m-d'),
                    'guests_count' => $getters[Order::COLUMN_GUESTS_COUNT](),
                    'scooters_count' => $getters[Order::COLUMN_SCOOTERS_COUNT](),
                    'transfer' => $getters[Order::COLUMN_TRANSFER](),
                    'hotel' => $getters[Order::COLUMN_HOTEL](),
                    'room_number' => $getters[Order::COLUMN_ROOM_NUMBER](),
                    'name' => $getters[Order::COLUMN_NAME](),
                    'email' => $getters[Order::COLUMN_EMAIL](),
                    'gender' => $getters[Order::COLUMN_GENDER](),
                    'nationality' => $getters[Order::COLUMN_NATIONALITY](),
                    'phone' => $getters[Order::COLUMN_PHONE](),
                    'is_subscribe' => $getters[Order::COLUMN_IS_SUBSCRIBE](),
                    'note' => $getters[Order::COLUMN_NOTE](),
                    'admin_note' => $getters[Order::COLUMN_ADMIN_NOTE](),
                    'photo_report' => $getters[Order::COLUMN_PHOTO_REPORT](),
                    'referrer' => $getters[Order::COLUMN_REFERRER](),
                    'created_at' => $getters[Order::COLUMN_CREATED_AT]()->format('Y-m-d'),
                    'updated_at' => $getters[Order::COLUMN_UPDATED_AT]()->format('Y-m-d'),
                ],
            ]);
    }

    public function testError(): void
    {
        Log::shouldReceive('error', 'debug');

        $response = $this->json('DELETE', route('adminPanel.order.destroy', ['id' => 0]));

        $response->assertStatus(Response::HTTP_BAD_REQUEST)
            ->assertJsonStructure(['message']);
    }
}
