<?php

namespace Tests\Unit\AdminPanel\Order;

use App\Http\Controllers\Api\AdminPanel\Order\UpdateOrderController;
use App\Http\Requests\AdminPanel\Order\UpdateOrderRequest;
use App\Models\Order;
use App\Presenter\AdminPanel\Order\Interfaces\OrderPresenterInterface;
use App\UseCases\AdminPanel\Order\Interfaces\UpdateOrderUseCaseInterface;
use Exception;
use Illuminate\Http\JsonResponse;
use Mockery;
use PHPUnit\Framework\TestCase;

class UpdateOrderControllerTest extends TestCase
{
    private UpdateOrderUseCaseInterface $updateOrderUseCaseMock;
    private OrderPresenterInterface $orderPresenterMock;
    private UpdateOrderController $updateOrderController;
    private UpdateOrderRequest $updateOrderRequestMock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->updateOrderUseCaseMock = Mockery::mock(UpdateOrderUseCaseInterface::class);
        $this->orderPresenterMock = Mockery::mock(OrderPresenterInterface::class);

        $this->updateOrderController = new UpdateOrderController(
            $this->updateOrderUseCaseMock,
            $this->orderPresenterMock
        );

        $this->updateOrderRequestMock = Mockery::mock(UpdateOrderRequest::class);
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
    public function testSuccessfulUpdateOrderControllerExecution(int $id, Order $order, array $expectedData): void
    {
        $this->updateOrderRequestMock
            ->shouldReceive('validated')
            ->once()
            ->andReturn([]);

        $this->updateOrderUseCaseMock
            ->shouldReceive('execute')
            ->once()
            ->andReturn($order);

        $this->orderPresenterMock
            ->shouldReceive('present')
            ->once()
            ->with($order)
            ->andReturn(new JsonResponse($expectedData));

        $response = $this->updateOrderController->__invoke($this->updateOrderRequestMock, $id);

        $this->assertEqualsCanonicalizing($expectedData, $response->getData());
    }

    /**
     * @dataProvider getDataProvider
     */
    public function testFailedUpdateOrderUseCaseCall(int $id): void
    {
        $this->updateOrderRequestMock
            ->shouldReceive('validated')
            ->once()
            ->andReturn([]);

        $this->updateOrderUseCaseMock
            ->shouldReceive('execute')
            ->once()
            ->andThrow(new Exception());

        $this->orderPresenterMock
            ->shouldReceive('present')
            ->never();

        $this->expectException(Exception::class);

        $this->updateOrderController->__invoke($this->updateOrderRequestMock, $id);
    }

    /**
     * @dataProvider getDataProvider
     */
    public function testFailedOrderPresenter(int $id, Order $order): void
    {
        $this->updateOrderRequestMock
            ->shouldReceive('validated')
            ->once()
            ->andReturn([]);

        $this->updateOrderUseCaseMock
            ->shouldReceive('execute')
            ->once()
            ->andReturn($order);

        $this->orderPresenterMock
            ->shouldReceive('present')
            ->once()
            ->andThrow(new Exception());

        $this->expectException(Exception::class);

        $this->updateOrderController->__invoke($this->updateOrderRequestMock, $id);
    }
}
