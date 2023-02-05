<?php

namespace Tests\Unit\Controller;

use App\DTO\OrderStoreRequestDTO;
use App\DTO\OrderStoreResponseDTO;
use App\Http\Controllers\Api\OrderStoreController;
use App\Http\Requests\Interfaces\OrderStoreRequestInterface;
use App\Models\Order;
use App\Presenters\Interfaces\OrderStorePresenterInterface;
use App\UseCases\Interfaces\OrderStoreUseCaseInterface;
use Exception;
use Illuminate\Http\JsonResponse;
use Mockery;
use PHPUnit\Framework\TestCase;

class OrderStoreControllerTest extends TestCase
{
    private OrderStoreUseCaseInterface $useCaseMock;
    private OrderStorePresenterInterface $presenterMock;
    private OrderStoreController $orderStoreController;
    private OrderStoreRequestInterface $requestMock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->useCaseMock = Mockery::mock(OrderStoreUseCaseInterface::class);
        $this->presenterMock = Mockery::mock(OrderStorePresenterInterface::class);

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
        $rentalDate = now()->toString();
        return [
            'single' => [
                'requestDTO' => new OrderStoreRequestDTO(
                    'TestAgencyName',
                    $rentalDate,
                    1,
                    1,
                    'TestUserName',
                    'test@test.com',
                    '+7 (777) 1111 111'
                ),
                'responseDTO' => new OrderStoreResponseDTO(new Order()),
                'expectedData' => [
                    (object)['testColumn' => 'testValue'],
                ],
            ],
        ];
    }

    /**
     * @dataProvider getDataProvider
     */
    public function testSuccessfulOrderStoreControllerExecution(
        OrderStoreRequestDTO  $requestDTO,
        OrderStoreResponseDTO $responseDTO,
        array                 $expectedData
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
            ->andReturn(new JsonResponse($expectedData));

        $response = $this->orderStoreController->__invoke($this->requestMock);

        $this->assertEqualsCanonicalizing($expectedData, $response->getData());
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
        OrderStoreRequestDTO  $requestDTO,
        OrderStoreResponseDTO $responseDTO,
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
