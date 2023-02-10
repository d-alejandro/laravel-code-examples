<?php

namespace Tests\Feature;

use App\Enums\OrderStatusEnum;
use App\Http\Requests\Enums\OrderUpdateRequestParamEnum;
use App\Http\Resources\Enums\OrderResourceEnum;
use App\Models\Agency;
use App\Models\Enums\AgencyColumn;
use App\Models\Enums\OrderColumn;
use App\Models\Order;
use Carbon\Carbon;
use Closure;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class OrderUpdateControllerTest extends TestCase
{
    use DatabaseTransactions;

    private const METHOD_PUT = 'put';

    private Closure $route;
    private Order $order;
    private string $agencyName = 'AgencyNameTest';
    private OrderStatusEnum $status = OrderStatusEnum::Paid;
    private Carbon $rentalDate;

    protected function setUp(): void
    {
        parent::setUp();

        $this->route = fn(int $id) => route('order.update', ['id' => $id]);

        $this->generateTestData();
    }

    public function getDataProvider(): array
    {
        $guestCount = 3;
        $transportCount = 3;
        $userName = 'NewTestUserName';
        $email = 'new-test@test.test';
        $phone = '7000000007';
        $note = 'NewNoteTest';

        return [
            'single' => [
                'request' => [
                    OrderUpdateRequestParamEnum::GuestCount->value => $guestCount,
                    OrderUpdateRequestParamEnum::TransportCount->value => $transportCount,
                    OrderUpdateRequestParamEnum::UserName->value => $userName,
                    OrderUpdateRequestParamEnum::Email->value => $email,
                    OrderUpdateRequestParamEnum::Phone->value => $phone,
                    OrderUpdateRequestParamEnum::Note->value => $note,
                ],
                'expectedResponse' => fn(Order $order, Carbon $rentalDate) => [
                    OrderResourceEnum::Id->value => $order->getKey(),
                    OrderResourceEnum::AgencyName->value => $this->agencyName,
                    OrderResourceEnum::Status->value => $this->status,
                    OrderResourceEnum::IsConfirmed->value => false,
                    OrderResourceEnum::IsChecked->value => false,
                    OrderResourceEnum::RentalDate->value => $rentalDate->format('d-m-Y'),
                    OrderResourceEnum::UserName->value => $userName,
                    OrderResourceEnum::TransportCount->value => $transportCount,
                    OrderResourceEnum::GuestCount->value => $guestCount,
                    OrderResourceEnum::AdminNote->value => null,
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
        $response = $this->json(self::METHOD_PUT, ($this->route)($this->order->getKey()), $request);

        $response->assertStatus(Response::HTTP_OK)
            ->assertExactJson([
                'data' => $expectedResponse($this->order, $this->rentalDate),
            ]);
    }

    /**
     * @dataProvider getDataProvider
     */
    public function testErrorExecution(array $request): void
    {
        Log::shouldReceive('error');

        $id = 0;
        $response = $this->json(self::METHOD_PUT, ($this->route)($id), $request);

        $response->assertStatus(Response::HTTP_BAD_REQUEST)
            ->assertExactJson([
                'message' => 'Order update error.',
            ]);
    }

    private function generateTestData(): void
    {
        $agency = Agency::factory()->create([
            AgencyColumn::Name->value => $this->agencyName,
        ]);

        $this->rentalDate = now()->addWeek();
        $this->order = Order::factory()->create([
            OrderColumn::AgencyId->value => $agency->getKey(),
            OrderColumn::Status->value => $this->status,
            OrderColumn::IsChecked->value => false,
            OrderColumn::IsConfirmed->value => false,
            OrderColumn::RentalDate->value => $this->rentalDate,
            OrderColumn::GuestCount->value => 1,
            OrderColumn::TransportCount->value => 1,
            OrderColumn::UserName->value => 'UserNameTest',
            OrderColumn::Email->value => 'test@test.test',
            OrderColumn::Phone->value => '7000000000',
            OrderColumn::Note->value => 'NoteTest',
            OrderColumn::AdminNote->value => 'AdminNoteTest',
            OrderColumn::ConfirmedAt->value => null,
        ]);
    }
}
