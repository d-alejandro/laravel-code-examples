<?php

namespace Tests\Feature\AdminPanel\Order;

use App\Helpers\Interfaces\EventDispatcherInterface;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Response;
use Mockery;
use Mockery\MockInterface;
use Tests\TestCase;

class StoreOrderControllerTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();

        $this->instance(
            EventDispatcherInterface::class,
            Mockery::mock(
                EventDispatcherInterface::class,
                fn(MockInterface $mock) => $mock->shouldReceive('dispatch')
            )
        );
    }

    public function getDataProvider(): array
    {
        $currentDate = now();

        $request = [
            'agency_name' => 'agencyNameTest',
            'date_tour' => $dateTour = $currentDate->copy()->addWeek(),
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
            'referrer' => 'referrerTest',
        ];

        $response = [
            'date_tour' => $dateTour->format('Y-m-d'),
            'is_subscribe' => true,
            'created_at' => $createdAt = $currentDate->format('Y-m-d'),
            'updated_at' => $createdAt,
        ];

        return [
            'single' => [
                'request' => $request,
                'expectedResponse' => [
                    'data' => array_merge($request, $response),
                ],
            ],
        ];
    }

    /**
     * @dataProvider getDataProvider
     */
    public function testSuccessfulExecution(array $request, array $expectedResponse): void
    {
        $response = $this->json('POST', route('adminPanel.order.store'), $request);

        $expectedResponse['data']['id'] = $response->getOriginalContent()->id;

        $response->assertStatus(Response::HTTP_OK)
            ->assertExactJson($expectedResponse);
    }

    public function testValidationError(): void
    {
        $response = $this->json('POST', route('adminPanel.order.store'), []);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'agency_name',
                    'date_tour',
                    'guests_count',
                    'scooters_count',
                    'hotel',
                    'room_number',
                    'name',
                    'email',
                    'phone',
                    'is_subscribe',
                ],
            ]);
    }
}
