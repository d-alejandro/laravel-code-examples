<?php

namespace Tests\Unit\AdminPanel\Order;

use App\DTO\AdminPanel\Order\StoreOrderRequestDTO;
use App\Helpers\Interfaces\EventDispatcherInterface;
use App\Models\Order;
use App\Services\AdminPanel\Order\Interfaces\StoreOrderServiceInterface;
use App\UseCases\AdminPanel\Order\Exceptions\OrderCreationException;
use App\UseCases\AdminPanel\Order\StoreOrderUseCase;
use Exception;
use Mockery;
use PHPUnit\Framework\TestCase;

class StoreOrderUseCaseTest extends TestCase
{
    private StoreOrderServiceInterface $storeOrderServiceMock;
    private EventDispatcherInterface $eventDispatcherMock;
    private StoreOrderUseCase $storeOrderUseCase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->storeOrderServiceMock = Mockery::mock(StoreOrderServiceInterface::class);
        $this->eventDispatcherMock = Mockery::mock(EventDispatcherInterface::class);

        $this->storeOrderUseCase = new StoreOrderUseCase($this->storeOrderServiceMock, $this->eventDispatcherMock);
    }

    public function getDataProvider(): array
    {
        $storeOrderRequestDTO = new StoreOrderRequestDTO([
            'agency_name' => 'testName',
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
                'expectedOrder' => $order,
            ],
        ];
    }

    /**
     * @dataProvider getDataProvider
     */
    public function testSuccessfulStoreOrderUseCaseExecution(
        StoreOrderRequestDTO $storeOrderRequestDTO,
        Order $expectedOrder
    ): void {
        $this->storeOrderServiceMock
            ->shouldReceive('make')
            ->once()
            ->with($storeOrderRequestDTO)
            ->andReturn($expectedOrder);

        $this->eventDispatcherMock
            ->shouldReceive('dispatch')
            ->once();

        $order = $this->storeOrderUseCase->execute($storeOrderRequestDTO);

        $this->assertEqualsCanonicalizing($expectedOrder->toArray(), $order->toArray());
    }

    /**
     * @dataProvider getDataProvider
     */
    public function testFailedStoreOrderServiceCall(StoreOrderRequestDTO $storeOrderRequestDTO): void
    {
        $this->storeOrderServiceMock
            ->shouldReceive('make')
            ->once()
            ->andThrow(new Exception());

        $this->eventDispatcherMock
            ->shouldReceive('dispatch')
            ->never();

        $this->expectException(OrderCreationException::class);

        $this->storeOrderUseCase->execute($storeOrderRequestDTO);
    }
}
