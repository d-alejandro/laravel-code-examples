<?php

namespace Tests\Unit\AdminPanel\Order;

use App\DTO\AdminPanel\Order\UpdateOrderRequestDTO;
use App\Models\Order;
use App\Repositories\AdminPanel\Order\Interfaces\OrderLoaderRepositoryInterface;
use App\Repositories\AdminPanel\Order\Interfaces\OrderUpdaterRepositoryInterface;
use App\Services\AdminPanel\Order\Interfaces\OrderColumnsCreatorServiceInterface;
use App\UseCases\AdminPanel\Order\Exceptions\OrderNotFoundException;
use App\UseCases\AdminPanel\Order\Exceptions\OrderUpdateException;
use App\UseCases\AdminPanel\Order\UpdateOrderUseCase;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Mockery;
use PHPUnit\Framework\TestCase;

class UpdateOrderUseCaseTest extends TestCase
{
    private OrderLoaderRepositoryInterface $orderLoaderRepositoryMock;
    private OrderColumnsCreatorServiceInterface $orderColumnsCreatorServiceMock;
    private OrderUpdaterRepositoryInterface $orderUpdaterRepositoryMock;
    private UpdateOrderUseCase $updateOrderUseCase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->orderLoaderRepositoryMock = Mockery::mock(OrderLoaderRepositoryInterface::class);
        $this->orderColumnsCreatorServiceMock = Mockery::mock(OrderColumnsCreatorServiceInterface::class);
        $this->orderUpdaterRepositoryMock = Mockery::mock(OrderUpdaterRepositoryInterface::class);

        $this->updateOrderUseCase = new UpdateOrderUseCase(
            $this->orderLoaderRepositoryMock,
            $this->orderColumnsCreatorServiceMock,
            $this->orderUpdaterRepositoryMock
        );
    }

    public function getDataProvider(): array
    {
        $updateOrderRequestDTO = new UpdateOrderRequestDTO([
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
        $loadedOrder = clone $order;
        $order->testColumn = 'testValue';

        return [
            'single' => [
                'updateOrderRequestDTO' => $updateOrderRequestDTO,
                'id' => 1,
                'loadedOrder' => $loadedOrder,
                'expectedOrder' => $order,
            ]
        ];
    }

    /**
     * @dataProvider getDataProvider
     */
    public function testSuccessfulUpdateOrderUseCaseExecution(
        UpdateOrderRequestDTO $updateOrderRequestDTO,
        int $id,
        Order $loadedOrder,
        Order $expectedOrder
    ): void {
        $this->orderLoaderRepositoryMock
            ->shouldReceive('make')
            ->once()
            ->with($id)
            ->andReturn($loadedOrder);

        $this->orderColumnsCreatorServiceMock
            ->shouldReceive('make')
            ->once()
            ->with($updateOrderRequestDTO->getProperties())
            ->andReturn([]);

        $this->orderUpdaterRepositoryMock
            ->shouldReceive('make')
            ->once()
            ->andReturn($expectedOrder);

        $order = $this->updateOrderUseCase->execute($updateOrderRequestDTO, $id);

        $this->assertEqualsCanonicalizing($expectedOrder->toArray(), $order->toArray());
    }

    /**
     * @dataProvider getDataProvider
     */
    public function testFailedOrderLoaderRepositoryCall(UpdateOrderRequestDTO $updateOrderRequestDTO, int $id): void
    {
        $this->orderLoaderRepositoryMock
            ->shouldReceive('make')
            ->once()
            ->andThrow(new ModelNotFoundException());

        $this->orderColumnsCreatorServiceMock
            ->shouldReceive('make')
            ->never();

        $this->orderUpdaterRepositoryMock
            ->shouldReceive('make')
            ->never();

        $this->expectException(OrderNotFoundException::class);

        $this->updateOrderUseCase->execute($updateOrderRequestDTO, $id);
    }

    /**
     * @dataProvider getDataProvider
     */
    public function testFailedOrderColumnsCreatorServiceCall(
        UpdateOrderRequestDTO $updateOrderRequestDTO,
        int $id,
        Order $loadedOrder
    ): void {
        $this->orderLoaderRepositoryMock
            ->shouldReceive('make')
            ->once()
            ->andReturn($loadedOrder);

        $this->orderColumnsCreatorServiceMock
            ->shouldReceive('make')
            ->once()
            ->andThrow(new Exception());

        $this->orderUpdaterRepositoryMock
            ->shouldReceive('make')
            ->never();

        $this->expectException(OrderUpdateException::class);

        $this->updateOrderUseCase->execute($updateOrderRequestDTO, $id);
    }

    /**
     * @dataProvider getDataProvider
     */
    public function testFailedOrderUpdaterRepositoryCall(
        UpdateOrderRequestDTO $updateOrderRequestDTO,
        int $id,
        Order $loadedOrder
    ): void {
        $this->orderLoaderRepositoryMock
            ->shouldReceive('make')
            ->once()
            ->andReturn($loadedOrder);

        $this->orderColumnsCreatorServiceMock
            ->shouldReceive('make')
            ->once()
            ->andReturn([]);

        $this->orderUpdaterRepositoryMock
            ->shouldReceive('make')
            ->once()
            ->andThrow(new Exception());

        $this->expectException(OrderUpdateException::class);

        $this->updateOrderUseCase->execute($updateOrderRequestDTO, $id);
    }
}
