<?php

namespace Tests\Unit\UseCase;

use App\Enums\OrderStatusEnum;
use App\Models\Enums\OrderColumn;
use App\Models\Order;
use Mockery;
use PHPUnit\Framework\TestCase;

class OrderStoreUseCaseTest extends TestCase
{
    private OrderStoreRepositoryInterface $repositoryMock;
    private EventDispatcherInterface $eventDispatcherMock;
    private OrderStoreUseCase $orderStoreUseCase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repositoryMock = Mockery::mock(OrderStoreRepositoryInterface::class);
        $this->eventDispatcherMock = Mockery::mock(EventDispatcherInterface::class);
        $this->orderStoreUseCase = new OrderStoreUseCase($this->repositoryMock, $this->eventDispatcherMock);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        Mockery::close();
    }

    public function getDataProvider(): array
    {
        $rentalDate = now()->toString();

        $storeOrderRequestDTO = new OrderStoreRequestDTO(
            'testAgencyName',
            OrderStatusEnum::Waiting,
            $rentalDate,
            1,
            1,
            'testUserName',
            'testEmail',
            'testPhone'
        );

        $order = new Order();
        $order->setColumn(OrderColumn::RentalDate, $rentalDate);

        return [
            'single' => [
                'requestDTO' => $storeOrderRequestDTO,
                'expectedOrder' => $order,
            ],
        ];
    }

    /**
     * @dataProvider getDataProvider
     */
    public function testSuccessfulOrderStoreUseCaseExecution($requestDTO, Order $expectedOrder): void
    {
        $this->repositoryMock
            ->shouldReceive('make')
            ->once()
            ->with($requestDTO)
            ->andReturn($expectedOrder);

        $this->eventDispatcherMock
            ->shouldReceive('dispatch')
            ->once();

        $order = $this->orderStoreUseCase->execute($requestDTO);

        $this->assertEquals($expectedOrder->toArray(), $order->toArray());
    }
}
