<?php

namespace Tests\Unit\Controller;

use App\DTO\OrderStoreRequestDTO;
use App\DTO\OrderResponseDTO;
use App\Http\Controllers\Api\OrderStoreController;
use App\Http\Requests\Interfaces\OrderStoreRequestInterface;
use App\Models\Order;
use App\Presenters\Interfaces\OrderPresenterInterface;
use App\UseCases\Interfaces\OrderStoreUseCaseInterface;
use Exception;
use Illuminate\Http\JsonResponse;
use Mockery;
use PHPUnit\Framework\TestCase;

class OrderStoreControllerTest extends TestCase
{
    private OrderStoreUseCaseInterface $useCaseMock;
    private OrderPresenterInterface $presenterMock;
    private OrderStoreController $orderStoreController;
    private OrderStoreRequestInterface $requestMock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->useCaseMock = Mockery::mock(OrderStoreUseCaseInterface::class);
        $this->presenterMock = Mockery::mock(OrderPresenterInterface::class);

        $this->orderStoreController = new OrderStoreController($this->useCaseMock, $this->presenterMock);

        $this->requestMock = Mockery::mock(OrderStoreRequestInterface::class);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        Mockery::close();
    }

    public function getDataProvider(): array
    {
        $requestDTO = new OrderStoreRequestDTO(
            agencyName: 'TestAgencyName',
            rentalDate: now(),
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
                'responseDTO' => new OrderResponseDTO(new Order()),
                'presenterResponse' => new JsonResponse($expectedResponse),
                'expectedResponse' => $expectedResponse,
            ],
        ];
    }

    /**
     * @dataProvider getDataProvider
     */
    public function testSuccessfulOrderStoreControllerExecution(
        OrderStoreRequestDTO $requestDTO,
        OrderResponseDTO     $responseDTO,
        JsonResponse         $presenterResponse,
        array                $expectedResponse
    ): void {
        $this->requestMock
            ->shouldReceive('getValidated')
            ->once()
            ->andReturn($requestDTO);

        $this->useCaseMock
            ->shouldReceive('execute')
            ->once()
            ->with($requestDTO)
            ->andReturn($responseDTO);

        $this->presenterMock
            ->shouldReceive('present')
            ->once()
            ->with($responseDTO)
            ->andReturn($presenterResponse);

        $response = $this->orderStoreController->__invoke($this->requestMock);

        $this->assertEquals($expectedResponse, $response->getData(true));
    }

    /**
     * @dataProvider getDataProvider
     */
    public function testFailedOrderStoreUseCaseCall(OrderStoreRequestDTO $requestDTO): void
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

        $this->orderStoreController->__invoke($this->requestMock);
    }

    /**
     * @dataProvider getDataProvider
     */
    public function testFailedOrderPresenterCall(
        OrderStoreRequestDTO $requestDTO,
        OrderResponseDTO     $responseDTO,
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

        $this->orderStoreController->__invoke($this->requestMock);
    }
}
