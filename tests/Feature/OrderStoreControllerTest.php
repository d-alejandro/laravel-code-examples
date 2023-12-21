<?php

namespace Tests\Feature;

use App\Enums\OrderStatusEnum;
use App\Helpers\Interfaces\EventDispatcherInterface;
use App\Http\Requests\Enums\OrderStoreRequestParamEnum;
use App\Http\Resources\Enums\OrderResourceEnum;
use App\Models\Enums\OrderColumn;
use App\Models\Order;
use Closure;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Mockery;
use Mockery\MockInterface;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class OrderStoreControllerTest extends TestCase
{
    use DatabaseTransactions;

    private const METHOD_POST = 'post';

    private string $route;

    protected function setUp(): void
    {
        parent::setUp();

        $this->route = route('order.store');

        $this->instance(
            EventDispatcherInterface::class,
            Mockery::mock(
                EventDispatcherInterface::class,
                fn(MockInterface $mock) => $mock->shouldReceive('dispatch')
            )
        );

        $this->deleteDatabaseData();
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        Mockery::close();
    }

    public function getDataProvider(): array
    {
        $agencyName = 'AgencyNameTest';
        $rentalDate = now()->addWeek();
        $guestCount = 1;
        $transportCount = 1;
        $userName = 'UserNameTest';
        $email = 'test@test.test';
        $phone = '7000000000';
        $note = 'NoteTest';
        $adminNote = 'AdminNoteTest';
        return [
            'single' => [
                'request' => [
                    OrderStoreRequestParamEnum::AgencyName->value => $agencyName,
                    OrderStoreRequestParamEnum::RentalDate->value => $rentalDate,
                    OrderStoreRequestParamEnum::GuestCount->value => $guestCount,
                    OrderStoreRequestParamEnum::TransportCount->value => $transportCount,
                    OrderStoreRequestParamEnum::UserName->value => $userName,
                    OrderStoreRequestParamEnum::Email->value => $email,
                    OrderStoreRequestParamEnum::Phone->value => $phone,
                    OrderStoreRequestParamEnum::Note->value => $note,
                    OrderStoreRequestParamEnum::AdminNote->value => $adminNote,
                ],
                'expectedResponse' => fn(Order $order) => [
                    OrderResourceEnum::Id->value => $order->getKey(),
                    OrderResourceEnum::AgencyName->value => $agencyName,
                    OrderResourceEnum::Status->value => OrderStatusEnum::Waiting->value,
                    OrderResourceEnum::IsConfirmed->value => false,
                    OrderResourceEnum::IsChecked->value => false,
                    OrderResourceEnum::RentalDate->value => $rentalDate->format('d-m-Y'),
                    OrderResourceEnum::UserName->value => $userName,
                    OrderResourceEnum::TransportCount->value => $transportCount,
                    OrderResourceEnum::GuestCount->value => $guestCount,
                    OrderResourceEnum::AdminNote->value => $adminNote,
                    OrderResourceEnum::Note->value => $note,
                    OrderResourceEnum::Email->value => $email,
                    OrderResourceEnum::Phone->value => $phone,
                    OrderResourceEnum::ConfirmedAt->value => null,
                    OrderResourceEnum::CreatedAt->value =>
                        $order->getColumn(OrderColumn::CreatedAt)->format('d-m-Y H:i:s'),
                    OrderResourceEnum::UpdatedAt->value =>
                        $order->getColumn(OrderColumn::UpdatedAt)->format('d-m-Y H:i:s'),
                ],
            ],
        ];
    }

    /**
     * @dataProvider getDataProvider
     */
    public function testSuccessfulExecution(array $request, Closure $expectedResponse): void
    {
        $response = $this->json(self::METHOD_POST, $this->route, $request);

        $order = Order::query()->firstOrFail();

        $response->assertStatus(Response::HTTP_CREATED)
            ->assertExactJson([
                'data' => $expectedResponse($order),
            ]);
    }

    public function testValidationError(): void
    {
        $response = $this->json(self::METHOD_POST, $this->route);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors([
                OrderStoreRequestParamEnum::AgencyName->value,
                OrderStoreRequestParamEnum::RentalDate->value,
                OrderStoreRequestParamEnum::GuestCount->value,
                OrderStoreRequestParamEnum::TransportCount->value,
                OrderStoreRequestParamEnum::UserName->value,
                OrderStoreRequestParamEnum::Email->value,
                OrderStoreRequestParamEnum::Phone->value,
            ]);
    }

    private function deleteDatabaseData(): void
    {
        Order::query()->delete();
    }
}
