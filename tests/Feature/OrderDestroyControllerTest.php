<?php

namespace Tests\Feature;

use App\Enums\OrderStatusEnum;
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

class OrderDestroyControllerTest extends TestCase
{
    use DatabaseTransactions;

    private const METHOD_DELETE = 'delete';

    private Closure $route;
    private Order $order;
    private string $agencyName = 'AgencyNameTest';
    private OrderStatusEnum $status = OrderStatusEnum::Paid;
    private Carbon $rentalDate;
    private int $guestCount = 1;
    private int $transportCount = 1;
    private string $userName = 'UserNameTest';
    private string $email = 'test@test.test';
    private string $phone = '7000000000';
    private string $note = 'NoteTest';
    private string $adminNote = 'AdminNoteTest';

    protected function setUp(): void
    {
        parent::setUp();

        $this->route = fn(int $id) => route('order.destroy', ['id' => $id]);

        $this->generateTestData();
    }

    public function getDataProvider(): array
    {
        return [
            'single' => [
                'expectedResponse' => fn(Order $order, Carbon $rentalDate) => [
                    OrderResourceEnum::Id->value => $order->getKey(),
                    OrderResourceEnum::AgencyName->value => $this->agencyName,
                    OrderResourceEnum::Status->value => $this->status,
                    OrderResourceEnum::IsConfirmed->value => false,
                    OrderResourceEnum::IsChecked->value => false,
                    OrderResourceEnum::RentalDate->value => $rentalDate->format('d-m-Y'),
                    OrderResourceEnum::UserName->value => $this->userName,
                    OrderResourceEnum::TransportCount->value => $this->transportCount,
                    OrderResourceEnum::GuestCount->value => $this->guestCount,
                    OrderResourceEnum::AdminNote->value => $this->adminNote,
                    OrderResourceEnum::Note->value => $this->note,
                    OrderResourceEnum::Email->value => $this->email,
                    OrderResourceEnum::Phone->value => $this->phone,
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
    public function testSuccessfulExecution(Closure $expectedResponse): void
    {
        $response = $this->json(self::METHOD_DELETE, ($this->route)($this->order->getKey()));

        $response->assertStatus(Response::HTTP_OK)
            ->assertExactJson([
                'data' => $expectedResponse($this->order, $this->rentalDate),
            ]);

        $this->assertSoftDeleted($this->order);
    }

    public function testErrorExecution(): void
    {
        Log::shouldReceive('error');

        $id = 0;
        $response = $this->json(self::METHOD_DELETE, ($this->route)($id));

        $response->assertStatus(Response::HTTP_BAD_REQUEST)
            ->assertExactJson([
                'message' => 'Order delete error.',
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
            OrderColumn::GuestCount->value => $this->guestCount,
            OrderColumn::TransportCount->value => $this->transportCount,
            OrderColumn::UserName->value => $this->userName,
            OrderColumn::Email->value => $this->email,
            OrderColumn::Phone->value => $this->phone,
            OrderColumn::Note->value => $this->note,
            OrderColumn::AdminNote->value => $this->adminNote,
            OrderColumn::ConfirmedAt->value => null,
        ]);
    }
}
