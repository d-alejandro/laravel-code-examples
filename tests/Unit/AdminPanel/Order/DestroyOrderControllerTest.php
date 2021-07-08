<?php

namespace Tests\Unit\AdminPanel\Order;

use App\Http\Controllers\Api\AdminPanel\Order\DestroyOrderController;
use App\Models\Order;
use App\Presenter\AdminPanel\Order\Interfaces\OrderPresenterInterface;
use App\UseCases\AdminPanel\Order\Interfaces\DestroyOrderUseCaseInterface;
use Exception;
use Illuminate\Http\JsonResponse;
use Mockery;
use PHPUnit\Framework\TestCase;

class DestroyOrderControllerTest extends TestCase
{
    private DestroyOrderUseCaseInterface $destroyOrderUseCaseMock;
    private OrderPresenterInterface $orderPresenterMock;
    private DestroyOrderController $destroyOrderController;

    protected function setUp(): void
    {
        parent::setUp();

        $this->destroyOrderUseCaseMock = Mockery::mock(DestroyOrderUseCaseInterface::class);
        $this->orderPresenterMock = Mockery::mock(OrderPresenterInterface::class);

        $this->destroyOrderController = new DestroyOrderController(
            $this->destroyOrderUseCaseMock,
            $this->orderPresenterMock
        );
    }

    public function getDataProvider(): array
    {
        return [
            'single' => [
                'id' => 1,
                'order' => new Order(),
                'expectedData' => [
                    (object)['testColumn' => 'testValue'],
                ],
            ],
        ];
    }

    /**
     * @dataProvider getDataProvider
     */
    public function testSuccessfulDestroyOrderControllerExecution(int $id, Order $order, array $expectedData): void
    {
        $this->destroyOrderUseCaseMock
            ->shouldReceive('execute')
            ->once()
            ->with($id)
            ->andReturn($order);

        $this->orderPresenterMock
            ->shouldReceive('present')
            ->once()
            ->with($order)
            ->andReturn(new JsonResponse($expectedData));

        $response = $this->destroyOrderController->__invoke($id);

        $this->assertEqualsCanonicalizing($expectedData, $response->getData());
    }

    /**
     * @dataProvider getDataProvider
     */
    public function testFailedDestroyOrderUseCaseCall(int $id): void
    {
        $this->destroyOrderUseCaseMock
            ->shouldReceive('execute')
            ->once()
            ->andThrow(new Exception());

        $this->orderPresenterMock
            ->shouldReceive('present')
            ->never();

        $this->expectException(Exception::class);

        $this->destroyOrderController->__invoke($id);
    }

    /**
     * @dataProvider getDataProvider
     */
    public function testFailedOrderPresenter(int $id, Order $order): void
    {
        $this->destroyOrderUseCaseMock
            ->shouldReceive('execute')
            ->once()
            ->andReturn($order);

        $this->orderPresenterMock
            ->shouldReceive('present')
            ->once()
            ->andThrow(new Exception());

        $this->expectException(Exception::class);

        $this->destroyOrderController->__invoke($id);
    }
}
