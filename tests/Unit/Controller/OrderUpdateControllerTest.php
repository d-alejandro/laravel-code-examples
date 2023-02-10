<?php

namespace Tests\Unit\Controller;

use App\DTO\OrderResponseDTO;
use App\DTO\OrderUpdateRequestDTO;
use App\Http\Controllers\Api\OrderUpdateController;
use App\Http\Requests\Interfaces\OrderUpdateRequestInterface;
use App\Models\Order;
use App\Presenters\Interfaces\OrderPresenterInterface;
use App\UseCases\Interfaces\OrderUpdateUseCaseInterface;
use Exception;
use Illuminate\Http\JsonResponse;
use Mockery;
use PHPUnit\Framework\TestCase;

class OrderUpdateControllerTest extends TestCase
{
    private OrderUpdateUseCaseInterface $useCaseMock;
    private OrderPresenterInterface $presenterMock;
    private OrderUpdateController $orderUpdateController;
    private OrderUpdateRequestInterface $requestMock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->useCaseMock = Mockery::mock(OrderUpdateUseCaseInterface::class);
        $this->presenterMock = Mockery::mock(OrderPresenterInterface::class);

        $this->orderUpdateController = new OrderUpdateController($this->useCaseMock, $this->presenterMock);

        $this->requestMock = Mockery::mock(OrderUpdateRequestInterface::class);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        Mockery::close();
    }

    public function getDataProvider(): array
    {
        $requestDTO = new OrderUpdateRequestDTO(
            guestCount: 1,
            transportCount: 1,
            userName: 'TestUserName',
            email: 'test@test.com',
            phone: '+7 (777) 1111 111'
        );

        $expectedResponse = ['testKey' => 'testValue'];

        return [
            'single' => [
                'requestDTO' => $requestDTO,
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
    public function testSuccessfulOrderUpdateControllerExecution(
        OrderUpdateRequestDTO $requestDTO,
        int                   $orderId,
        OrderResponseDTO      $responseDTO,
        JsonResponse          $presenterResponse,
        array                 $expectedResponse
    ): void {
        $this->requestMock
            ->shouldReceive('getValidated')
            ->once()
            ->andReturn($requestDTO);

        $this->useCaseMock
            ->shouldReceive('execute')
            ->once()
            ->with($requestDTO, $orderId)
            ->andReturn($responseDTO);

        $this->presenterMock
            ->shouldReceive('present')
            ->once()
            ->with($responseDTO)
            ->andReturn($presenterResponse);

        $response = $this->orderUpdateController->__invoke($this->requestMock, $orderId);

        $this->assertEquals($expectedResponse, $response->getData(true));
    }

    /**
     * @dataProvider getDataProvider
     */
    public function testFailedOrderUpdateUseCaseCall(OrderUpdateRequestDTO $requestDTO, int $orderId): void
    {
        $this->requestMock
            ->shouldReceive('getValidated')
            ->once()
            ->andReturn($requestDTO);

        $this->useCaseMock
            ->shouldReceive('execute')
            ->once()
            ->andThrow(new Exception());

        $this->presenterMock
            ->shouldReceive('present')
            ->never();

        $this->expectException(Exception::class);

        $this->orderUpdateController->__invoke($this->requestMock, $orderId);
    }

    /**
     * @dataProvider getDataProvider
     */
    public function testFailedOrderPresenterCall(
        OrderUpdateRequestDTO $requestDTO,
        int                   $orderId,
        OrderResponseDTO      $responseDTO
    ): void {
        $this->requestMock
            ->shouldReceive('getValidated')
            ->once()
            ->andReturn($requestDTO);

        $this->useCaseMock
            ->shouldReceive('execute')
            ->once()
            ->andReturn($responseDTO);

        $this->presenterMock
            ->shouldReceive('present')
            ->once()
            ->andThrow(new Exception());

        $this->expectException(Exception::class);

        $this->orderUpdateController->__invoke($this->requestMock, $orderId);
    }
}
