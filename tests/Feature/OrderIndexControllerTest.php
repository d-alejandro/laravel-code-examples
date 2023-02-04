<?php

namespace Tests\Feature;

use App\Enums\OrderStatusEnum;
use App\Enums\SortTypeEnum;
use App\Http\Requests\Enums\OrderIndexRequestParamEnum;
use App\Http\Requests\Enums\PaginationEnum;
use App\Http\Resources\Enums\OrderIndexResourceEnum;
use App\Models\Agency;
use App\Models\Enums\AgencyColumn;
use App\Models\Enums\OrderColumn;
use App\Models\Order;
use App\Presenters\OrderIndexPresenter;
use Carbon\Carbon;
use Closure;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class OrderIndexControllerTest extends TestCase
{
    use DatabaseTransactions;

    private const METHOD_GET = 'get';

    private const DAY_COUNT = 7;

    private string $route;
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

        $this->route = route('order.index');

        $this->deleteDatabaseData();
        $this->generateTestData();
    }

    public function getDataProviderSuccessful(): array
    {
        return [
            'single' => [
                'request' => fn(Order $order, Carbon $rentalDate) => [
                    PaginationEnum::Start->value => 0,
                    PaginationEnum::End->value => 1,
                    PaginationEnum::SortColumn->value => OrderColumn::Id,
                    PaginationEnum::SortType->value => SortTypeEnum::Desc,
                    PaginationEnum::Ids->value => [$order->getKey()],
                    OrderIndexRequestParamEnum::RentalDate->value => $rentalDate->format('Y-m-d'),
                    OrderIndexRequestParamEnum::IsConfirmed->value => 'true',
                    OrderIndexRequestParamEnum::IsChecked->value => 'true',
                    OrderIndexRequestParamEnum::Status->value => $this->status->value,
                    OrderIndexRequestParamEnum::UserName->value => $this->userName,
                    OrderIndexRequestParamEnum::AgencyName->value => $this->agencyName,
                    OrderIndexRequestParamEnum::AdminNote->value => 'true',
                    OrderIndexRequestParamEnum::StartDate->value => $rentalDate->copy()->subDay()->format('Y-m-d'),
                    OrderIndexRequestParamEnum::EndDate->value => $rentalDate->copy()->addDay()->format('Y-m-d'),
                ],
                'expectedResponse' => fn(Order $order, Carbon $rentalDate) => [
                    OrderIndexResourceEnum::Id->value => $order->getKey(),
                    OrderIndexResourceEnum::AgencyName->value => $this->agencyName,
                    OrderIndexResourceEnum::Status->value => $this->status->value,
                    OrderIndexResourceEnum::IsConfirmed->value => true,
                    OrderIndexResourceEnum::IsChecked->value => true,
                    OrderIndexResourceEnum::RentalDate->value => $rentalDate->format('d-m-Y'),
                    OrderIndexResourceEnum::UserName->value => $this->userName,
                    OrderIndexResourceEnum::TransportCount->value => $this->transportCount,
                    OrderIndexResourceEnum::GuestsCount->value => $this->guestCount,
                    OrderIndexResourceEnum::AdminNote->value => $this->adminNote,
                ],
                'expectedRowCount' => 1,
            ],
        ];
    }

    /**
     * @dataProvider getDataProviderSuccessful
     */
    public function testSuccessfulExecution(Closure $request, Closure $expectedResponse, int $expectedRowCount): void
    {
        $response = $this->json(self::METHOD_GET, $this->route, $request($this->order, $this->rentalDate));

        $response->assertStatus(Response::HTTP_OK)
            ->assertHeader(OrderIndexPresenter::HEADER_X_TOTAL_COUNT, $expectedRowCount)
            ->assertExactJson([
                'data' => [$expectedResponse($this->order, $this->rentalDate)],
            ]);
    }

    public function getDataProviderError(): array
    {
        return [
            'single' => [
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
     * @dataProvider getDataProviderError
     */
    public function testValidationError(array $request): void
    {
        $response = $this->json(self::METHOD_GET, $this->route, $request);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors([
                PaginationEnum::Start->value,
                PaginationEnum::End->value,
                PaginationEnum::SortColumn->value,
                PaginationEnum::SortType->value,
            ]);
    }

    private function deleteDatabaseData(): void
    {
        Order::query()->delete();
    }

    private function generateTestData(): void
    {
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
}
