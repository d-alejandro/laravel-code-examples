<?php

namespace Tests\Unit\AdminPanel\Order;

use App\DTO\AdminPanel\Order\StoreOrderRequestDTO;
use App\Models\Agency;
use App\Models\Order;
use App\Repositories\AdminPanel\Agency\Interfaces\AgencyCreatorByNameRepositoryInterface;
use App\Repositories\AdminPanel\Order\Interfaces\OrderCreatorRepositoryInterface;
use App\Services\AdminPanel\Order\StoreOrderService;
use Exception;
use Mockery;
use PHPUnit\Framework\TestCase;

class StoreOrderServiceTest extends TestCase
{
    private AgencyCreatorByNameRepositoryInterface $agencyCreatorByNameRepositoryMock;
    private OrderCreatorRepositoryInterface $orderCreatorRepositoryMock;
    private StoreOrderService $storeOrderService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->agencyCreatorByNameRepositoryMock = Mockery::mock(AgencyCreatorByNameRepositoryInterface::class);
        $this->orderCreatorRepositoryMock = Mockery::mock(OrderCreatorRepositoryInterface::class);

        $this->storeOrderService = new StoreOrderService(
            $this->agencyCreatorByNameRepositoryMock,
            $this->orderCreatorRepositoryMock
        );
    }

    public function getDataProvider(): array
    {
        $agencyName = 'testAgencyName';

        $storeOrderRequestDTO = new StoreOrderRequestDTO([
            'agency_name' => $agencyName,
            'date_tour' => '2021-01-01',
            'guests_count' => 1,
            'scooters_count' => 1,
            'hotel' => 'testHotel',
            'room_number' => 'testRoomNumber',
            'name' => 'testName',
            'email' => 'testEmail',
            'phone' => 'testPhone',
            'is_subscribe' => true,
        ]);

        $order = new Order();
        $order->testColumn = 'testValue';

        return [
            'single' => [
                'storeOrderRequestDTO' => $storeOrderRequestDTO,
                'agencyName' => $agencyName,
                'expectedOrder' => $order,
            ]
        ];
    }

    /**
     * @dataProvider getDataProvider
     */
    public function testSuccessfulStoreOrderServiceMake(
        StoreOrderRequestDTO $storeOrderRequestDTO,
        string $agencyName,
        Order $expectedOrder
    ): void {
        $this->agencyCreatorByNameRepositoryMock
            ->shouldReceive('make')
            ->once()
            ->with($agencyName)
            ->andReturn(new Agency());

        $this->orderCreatorRepositoryMock
            ->shouldReceive('make')
            ->once()
            ->andReturn($expectedOrder);

        $order = $this->storeOrderService->make($storeOrderRequestDTO);

        $this->assertEqualsCanonicalizing($expectedOrder->toArray(), $order->toArray());
    }

    /**
     * @dataProvider getDataProvider
     */
    public function testFailedAgencyCreatorByNameRepositoryCall(StoreOrderRequestDTO $storeOrderRequestDTO): void
    {
        $this->agencyCreatorByNameRepositoryMock
            ->shouldReceive('make')
            ->once()
            ->andThrow(new Exception());

        $this->orderCreatorRepositoryMock
            ->shouldReceive('make')
            ->never();

        $this->expectException(Exception::class);

        $this->storeOrderService->make($storeOrderRequestDTO);
    }

    /**
     * @dataProvider getDataProvider
     */
    public function testFailedOrderCreatorRepositoryCall(StoreOrderRequestDTO $storeOrderRequestDTO): void
    {
        $this->agencyCreatorByNameRepositoryMock
            ->shouldReceive('make')
            ->once()
            ->andReturn(new Agency());

        $this->orderCreatorRepositoryMock
            ->shouldReceive('make')
            ->once()
            ->andThrow(new Exception());

        $this->expectException(Exception::class);

        $this->storeOrderService->make($storeOrderRequestDTO);
    }
}
