<?php

namespace Tests\Unit\Controller;

use App\DTO\OrderResponseDTO;
use App\Http\Controllers\Api\OrderShowController;
use App\Models\Order;
use App\Presenters\Interfaces\OrderPresenterInterface;
use App\UseCases\Interfaces\OrderShowUseCaseInterface;
use Exception;
use Illuminate\Http\JsonResponse;
use Mockery;
use PHPUnit\Framework\TestCase;

class OrderShowControllerTest extends TestCase
{
    private OrderShowUseCaseInterface $useCaseMock;
    private OrderPresenterInterface $presenterMock;
    private OrderShowController $orderShowController;

    protected function setUp(): void
    {
        parent::setUp();

        $this->useCaseMock = Mockery::mock(OrderShowUseCaseInterface::class);
        $this->presenterMock = Mockery::mock(OrderPresenterInterface::class);

        $this->orderShowController = new OrderShowController($this->useCaseMock, $this->presenterMock);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        Mockery::close();
    }

    public function getDataProvider(): array
    {
        $expectedResponse = ['testKey' => 'testValue'];
        return [
            'single' => [
                'orderId' => 1,
                'responseDTO' => new OrderResponseDTO(new Order()),
                'presenterResponse' => new JsonResponse($expectedResponse),
                'expectedResponse' => $expectedResponse,
            ],
        ];
    }

    /**
     * @dataProvider getDataProvider
     */
    public function testSuccessfulOrderShowControllerExecution(
        int              $orderId,
        OrderResponseDTO $responseDTO,
        JsonResponse     $presenterResponse,
        array            $expectedResponse
    ): void {
        $this->useCaseMock
            ->shouldReceive('execute')
            ->once()
            ->with($orderId)
            ->andReturn($responseDTO);

        $this->presenterMock
            ->shouldReceive('present')
            ->once()
            ->with($responseDTO)
            ->andReturn($presenterResponse);

        $response = $this->orderShowController->__invoke($orderId);

        $this->assertEquals($expectedResponse, $response->getData(true));
    }

    /**
     * @dataProvider getDataProvider
     */
    public function testFailedOrderShowUseCaseCall(int $orderId): void
    {
        $this->useCaseMock
            ->shouldReceive('execute')
            ->once()
            ->andThrow(new Exception());

        $this->presenterMock
            ->shouldReceive('present')
            ->never();

        $this->expectException(Exception::class);

        $this->orderShowController->__invoke($orderId);
    }

    /**
     * @dataProvider getDataProvider
     */
    public function testFailedOrderShowPresenterCall(int $orderId, OrderResponseDTO $responseDTO): void
    {
        $this->useCaseMock
            ->shouldReceive('execute')
            ->once()
            ->andReturn($responseDTO);

        $this->presenterMock
            ->shouldReceive('present')
            ->once()
            ->andThrow(new Exception());

        $this->expectException(Exception::class);

        $this->orderShowController->__invoke($orderId);
    }
}
