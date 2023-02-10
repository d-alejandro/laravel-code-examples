<?php

namespace Tests\Unit\UseCase;

use App\DTO\OrderResponseDTO;
use App\DTO\OrderUpdateRequestDTO;
use App\Enums\OrderStatusEnum;
use App\Models\Enums\OrderColumn;
use App\Models\Order;
use App\Repositories\Interfaces\OrderUpdateRepositoryInterface;
use App\UseCases\Exceptions\OrderUpdateException;
use App\UseCases\Interfaces\OrderShowUseCaseInterface;
use App\UseCases\OrderUpdateUseCase;
use Exception;
use Mockery;
use PHPUnit\Framework\TestCase;

class OrderUpdateUseCaseTest extends TestCase
{
    private OrderShowUseCaseInterface $showUseCaseMock;
    private OrderUpdateRepositoryInterface $repositoryMock;
    private OrderUpdateUseCase $orderUpdateUseCase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->showUseCaseMock = Mockery::mock(OrderShowUseCaseInterface::class);
        $this->repositoryMock = Mockery::mock(OrderUpdateRepositoryInterface::class);

        $this->orderUpdateUseCase = new OrderUpdateUseCase($this->showUseCaseMock, $this->repositoryMock);
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

        return [
            'single' => [
                'requestDTO' => $requestDTO,
                'orderId' => 1,
                'responseDTO' => new OrderResponseDTO(new Order()),
                'expectedResponse' => [
                    OrderColumn::Status->value => OrderStatusEnum::Waiting->value,
                    OrderColumn::IsChecked->value => false,
                    OrderColumn::IsConfirmed->value => false,
                ],
            ]
        ];
    }

    /**
     * @dataProvider getDataProvider
     * @throws OrderUpdateException
     */
    public function testSuccessfulOrderUpdateUseCaseExecution(
        OrderUpdateRequestDTO $requestDTO,
        int                   $orderId,
        OrderResponseDTO      $responseDTO,
        array                 $expectedResponse
    ): void {
        $this->showUseCaseMock
            ->shouldReceive('execute')
            ->once()
            ->with($orderId)
            ->andReturn($responseDTO);

        $this->repositoryMock
            ->shouldReceive('make')
            ->once()
            ->with($responseDTO, $requestDTO);

        $response = $this->orderUpdateUseCase->execute($requestDTO, $orderId);

        $this->assertEquals($expectedResponse, $response->order->toArray());
    }

    /**
     * @dataProvider getDataProvider
     */
    public function testFailedOrderShowUseCaseCall(OrderUpdateRequestDTO $requestDTO, int $orderId): void
    {
        $this->showUseCaseMock
            ->shouldReceive('execute')
            ->once()
            ->andThrow(new Exception());

        $this->repositoryMock
            ->shouldReceive('make')
            ->never();

        $this->expectException(OrderUpdateException::class);

        $this->orderUpdateUseCase->execute($requestDTO, $orderId);
    }

    /**
     * @dataProvider getDataProvider
     */
    public function testFailedOrderUpdateRepositoryCall(
        OrderUpdateRequestDTO $requestDTO,
        int                   $orderId,
        OrderResponseDTO      $responseDTO
    ): void {
        $this->showUseCaseMock
            ->shouldReceive('execute')
            ->once()
            ->andReturn($responseDTO);

        $this->repositoryMock
            ->shouldReceive('make')
            ->once()
            ->andThrow(new Exception());

        $this->expectException(OrderUpdateException::class);

        $this->orderUpdateUseCase->execute($requestDTO, $orderId);
    }
}
