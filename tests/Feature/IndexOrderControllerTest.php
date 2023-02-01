<?php

namespace Tests\Feature;

use App\Enums\OrderStatusEnum;
use App\Enums\SortTypeEnum;
use App\Http\Requests\Enums\IndexOrderRequestParamEnum;
use App\Http\Requests\Enums\PaginationEnum;
use App\Http\Resources\Enums\IndexOrderResourceEnum;
use App\Models\Agency;
use App\Models\Enums\AgencyColumn;
use App\Models\Enums\OrderColumn;
use App\Models\Order;
use Carbon\Carbon;
use Closure;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class IndexOrderControllerTest extends TestCase
{
    use DatabaseTransactions;

    private const DAY_COUNT = 7;

    private Order $order;
    private string $agencyName = 'Test Agency';
    private OrderStatusEnum $status = OrderStatusEnum::Paid;
    private Carbon $rentalDate;
    private int $guestCount = 3;
    private int $transportCount = 2;
    private string $userName = 'Test User';
    private string $adminNote = 'Test Admin Note';

    protected function setUp(): void
    {
        parent::setUp();

        Order::query()->delete();

        $agency = Agency::factory()->create([
            AgencyColumn::Name->value => $this->agencyName,
        ]);

        $this->rentalDate = now()->addDays(self::DAY_COUNT);

        $this->order = Order::factory()->create([
            OrderColumn::AgencyId->value => $agency->getKey(),
            OrderColumn::Status->value => $this->status,
            OrderColumn::IsChecked->value => true,
            OrderColumn::IsConfirmed->value => true,
            OrderColumn::RentalDate->value => $this->rentalDate,
            OrderColumn::GuestsCount->value => $this->guestCount,
            OrderColumn::TransportCount->value => $this->transportCount,
            OrderColumn::UserName->value => $this->userName,
            OrderColumn::AdminNote->value => $this->adminNote,
            OrderColumn::ConfirmedAt->value => now(),
        ]);
    }

    public function getDataProviderSuccessful(): array
    {
        return [
            'successful' => [
                'request' => fn(Order $order, Carbon $rentalDate) => [
                    PaginationEnum::Start->value => 0,
                    PaginationEnum::End->value => 1,
                    PaginationEnum::SortColumn->value => OrderColumn::Id,
                    PaginationEnum::SortType->value => SortTypeEnum::Desc,
                    PaginationEnum::Ids->value => [$order->getKey()],
                    IndexOrderRequestParamEnum::RentalDate->value => $rentalDate->format('Y-m-d'),
                    IndexOrderRequestParamEnum::IsConfirmed->value => 'true',
                    IndexOrderRequestParamEnum::IsChecked->value => 'true',
                    IndexOrderRequestParamEnum::Status->value => $this->status->value,
                    IndexOrderRequestParamEnum::UserName->value => $this->userName,
                    IndexOrderRequestParamEnum::AgencyName->value => $this->agencyName,
                    IndexOrderRequestParamEnum::AdminNote->value => 'true',
                    IndexOrderRequestParamEnum::StartDate->value => $rentalDate->format('Y-m-d'),
                    IndexOrderRequestParamEnum::EndDate->value => $rentalDate->format('Y-m-d'),
                ],
                'expectedResponse' => fn(Order $order, Carbon $rentalDate) => [
                    IndexOrderResourceEnum::Id->value => $order->getKey(),
                    IndexOrderResourceEnum::AgencyName->value => $this->agencyName,
                    IndexOrderResourceEnum::Status->value => $this->status->value,
                    IndexOrderResourceEnum::IsConfirmed->value => true,
                    IndexOrderResourceEnum::IsChecked->value => true,
                    IndexOrderResourceEnum::RentalDate->value => $rentalDate->format('d-m-Y'),
                    IndexOrderResourceEnum::UserName->value => $this->userName,
                    IndexOrderResourceEnum::TransportCount->value => $this->transportCount,
                    IndexOrderResourceEnum::GuestsCount->value => $this->guestCount,
                    IndexOrderResourceEnum::AdminNote->value => $this->adminNote,
                ],
            ],
        ];
    }

    public function getDataProviderError(): array
    {
        return [
            'error' => [
                'request' => [
                    PaginationEnum::Start->value => -1,
                    PaginationEnum::End->value => 0,
                    PaginationEnum::SortColumn->value => 'test',
                    PaginationEnum::SortType->value => 'test',
                ]
            ],
        ];
    }

    /**
     * @dataProvider getDataProviderSuccessful
     */
    public function testSuccessfulExecution(Closure $request, Closure $expectedResponse): void
    {
        $response = $this->json(
            'GET',
            route('adminPanel.order.index'),
            $request($this->order, $this->rentalDate)
        );

        $response->assertStatus(Response::HTTP_OK)
            ->assertHeader('X-Total-Count', 1)
            ->assertExactJson([
                'data' => [$expectedResponse($this->order, $this->rentalDate)],
            ]);
    }

    /**
     * @dataProvider getDataProviderError
     */
    public function testValidationError(array $request): void
    {
        $response = $this->json('GET', route('adminPanel.order.index'), $request);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors([
                PaginationEnum::Start->value,
                PaginationEnum::End->value,
                PaginationEnum::SortColumn->value,
                PaginationEnum::SortType->value,
            ]);
    }
}
