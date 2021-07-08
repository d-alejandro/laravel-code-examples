<?php

namespace Tests\Unit\AdminPanel\Order;

use App\Http\Controllers\Api\AdminPanel\Order\StoreOrderController;
use App\Http\Requests\AdminPanel\Order\StoreOrderRequest;
use App\Models\Order;
use App\Presenter\AdminPanel\Order\Interfaces\OrderPresenterInterface;
use App\UseCases\AdminPanel\Order\Interfaces\StoreOrderUseCaseInterface;
use Exception;
use Illuminate\Http\JsonResponse;
use Mockery;
use PHPUnit\Framework\TestCase;

class StoreOrderControllerTest extends TestCase
{
    private StoreOrderUseCaseInterface $storeOrderUseCaseMock;
    private OrderPresenterInterface $orderPresenterMock;
    private StoreOrderController $storeOrderController;
    private StoreOrderRequest $storeOrderRequestMock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->storeOrderUseCaseMock = Mockery::mock(StoreOrderUseCaseInterface::class);
        $this->orderPresenterMock = Mockery::mock(OrderPresenterInterface::class);

        $this->storeOrderController = new StoreOrderController(
            $this->storeOrderUseCaseMock,
            $this->orderPresenterMock
        );

        $this->storeOrderRequestMock = Mockery::mock(StoreOrderRequest::class);
    }

    public function getDataProvider(): array
    {
        return [
            'single' => [
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
    public function testSuccessfulStoreOrderControllerExecution(Order $order, array $expectedData): void
    {
        $this->storeOrderRequestMock
            ->shouldReceive('validated')
            ->once()
            ->andReturn([]);

        $this->storeOrderUseCaseMock
            ->shouldReceive('execute')
            ->once()
            ->andReturn($order);

        $this->orderPresenterMock
            ->shouldReceive('present')
            ->once()
            ->with($order)
            ->andReturn(new JsonResponse($expectedData));

        $response = $this->storeOrderController->__invoke($this->storeOrderRequestMock);

        $this->assertEqualsCanonicalizing($expectedData, $response->getData());
    }

    public function testFailedStoreOrderUseCaseCall(): void
    {
        $this->storeOrderRequestMock
            ->shouldReceive('validated')
            ->once()
            ->andReturn([]);

        $this->storeOrderUseCaseMock
            ->shouldReceive('execute')
            ->once()
            ->andThrow(new Exception());

        $this->orderPresenterMock
            ->shouldReceive('present')
            ->never();

        $this->expectException(Exception::class);

        $this->storeOrderController->__invoke($this->storeOrderRequestMock);
    }

    /**
     * @dataProvider getDataProvider
     */
    public function testFailedOrderPresenterCall(Order $order): void
    {
        $this->storeOrderRequestMock
            ->shouldReceive('validated')
            ->once()
            ->andReturn([]);

        $this->storeOrderUseCaseMock
            ->shouldReceive('execute')
            ->once()
            ->andReturn($order);

        $this->orderPresenterMock
            ->shouldReceive('present')
            ->once()
            ->andThrow(new Exception());

        $this->expectException(Exception::class);

        $this->storeOrderController->__invoke($this->storeOrderRequestMock);
    }
}
