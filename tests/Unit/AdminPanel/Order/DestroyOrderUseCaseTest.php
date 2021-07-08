<?php

namespace Tests\Unit\AdminPanel\Order;

use App\Models\Order;
use App\Repositories\AdminPanel\Order\Interfaces\OrderDestroyerRepositoryInterface;
use App\Repositories\AdminPanel\Order\Interfaces\OrderLoaderRepositoryInterface;
use App\UseCases\AdminPanel\Order\DestroyOrderUseCase;
use App\UseCases\AdminPanel\Order\Exceptions\OrderDeleteException;
use App\UseCases\AdminPanel\Order\Exceptions\OrderNotFoundException;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Mockery;
use PHPUnit\Framework\TestCase;

class DestroyOrderUseCaseTest extends TestCase
{
    private OrderLoaderRepositoryInterface $orderLoaderRepositoryMock;
    private OrderDestroyerRepositoryInterface $orderDestroyerRepositoryMock;
    private DestroyOrderUseCase $destroyOrderUseCase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->orderLoaderRepositoryMock = Mockery::mock(OrderLoaderRepositoryInterface::class);
        $this->orderDestroyerRepositoryMock = Mockery::mock(OrderDestroyerRepositoryInterface::class);

        $this->destroyOrderUseCase = new DestroyOrderUseCase(
            $this->orderLoaderRepositoryMock,
            $this->orderDestroyerRepositoryMock
        );
    }

    public function getDataProvider(): array
    {
        $order = new Order();
        $order->testColumn = 'testValue';

        return [
            'single' => [
                'id' => 1,
                'expectedOrder' => $order,
            ]
        ];
    }

    /**
     * @dataProvider getDataProvider
     */
    public function testSuccessfulDestroyOrderUseCaseExecution(int $id, Order $expectedOrder): void
    {
        $this->orderLoaderRepositoryMock
            ->shouldReceive('make')
            ->once()
            ->with($id)
            ->andReturn($expectedOrder);

        $this->orderDestroyerRepositoryMock
            ->shouldReceive('make')
            ->once()
            ->with($expectedOrder)
            ->andReturn($expectedOrder);

        $order = $this->destroyOrderUseCase->execute($id);

        $this->assertEqualsCanonicalizing($expectedOrder->toArray(), $order->toArray());
    }

    /**
     * @dataProvider getDataProvider
     */
    public function testFailedOrderLoaderRepositoryCall(int $id): void
    {
        $this->orderLoaderRepositoryMock
            ->shouldReceive('make')
            ->once()
            ->andThrow(new ModelNotFoundException());

        $this->orderDestroyerRepositoryMock
            ->shouldReceive('make')
            ->never();

        $this->expectException(OrderNotFoundException::class);

        $this->destroyOrderUseCase->execute($id);
    }

    /**
     * @dataProvider getDataProvider
     */
    public function testFailedOrderDestroyerRepositoryCall(int $id, Order $expectedOrder): void
    {
        $this->orderLoaderRepositoryMock
            ->shouldReceive('make')
            ->once()
            ->andReturn($expectedOrder);

        $this->orderDestroyerRepositoryMock
            ->shouldReceive('make')
            ->once()
            ->andThrow(new Exception());

        $this->expectException(OrderDeleteException::class);

        $this->destroyOrderUseCase->execute($id);
    }
}
