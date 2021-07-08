<?php

namespace Tests\Unit\AdminPanel\Order;

use App\Models\Order;
use App\Repositories\AdminPanel\Order\Interfaces\OrderLoaderRepositoryInterface;
use App\UseCases\AdminPanel\Order\Exceptions\OrderNotFoundException;
use App\UseCases\AdminPanel\Order\ShowOrderUseCase;
use Exception;
use Mockery;
use PHPUnit\Framework\TestCase;

class ShowOrderUseCaseTest extends TestCase
{
    private OrderLoaderRepositoryInterface $orderLoaderRepositoryMock;
    private ShowOrderUseCase $showOrderUseCase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->orderLoaderRepositoryMock = Mockery::mock(OrderLoaderRepositoryInterface::class);

        $this->showOrderUseCase = new ShowOrderUseCase($this->orderLoaderRepositoryMock);
    }

    public function getDataProvider(): array
    {
        $order = new Order();
        $order->testColumn = 'testValue';

        return [
            'single' => [
                'id' => 1,
                'expectedOrder' => $order,
            ],
        ];
    }

    /**
     * @dataProvider getDataProvider
     */
    public function testSuccessfulShowOrderUseCaseExecution(int $id, Order $expectedOrder): void
    {
        $this->orderLoaderRepositoryMock
            ->shouldReceive('make')
            ->once()
            ->with($id)
            ->andReturn($expectedOrder);

        $order = $this->showOrderUseCase->execute($id);

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
            ->andThrow(new Exception());

        $this->expectException(OrderNotFoundException::class);

        $this->showOrderUseCase->execute($id);
    }
}
