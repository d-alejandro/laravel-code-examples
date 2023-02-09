<?php

namespace Tests\Unit\UseCase;

use App\DTO\OrderResponseDTO;
use App\Enums\OrderStatusEnum;
use App\Models\Enums\OrderColumn;
use App\Models\Order;
use App\Repositories\Interfaces\OrderDestroyRepositoryInterface;
use App\UseCases\Exceptions\OrderDestroyException;
use App\UseCases\Interfaces\OrderShowUseCaseInterface;
use App\UseCases\OrderDestroyUseCase;
use Exception;
use Mockery;
use PHPUnit\Framework\TestCase;

class OrderDestroyUseCaseTest extends TestCase
{
    private OrderShowUseCaseInterface $showUseCaseMock;
    private OrderDestroyRepositoryInterface $repositoryMock;
    private OrderDestroyUseCase $orderDestroyUseCase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->showUseCaseMock = Mockery::mock(OrderShowUseCaseInterface::class);
        $this->repositoryMock = Mockery::mock(OrderDestroyRepositoryInterface::class);

        $this->orderDestroyUseCase = new OrderDestroyUseCase($this->showUseCaseMock, $this->repositoryMock);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        Mockery::close();
    }

    public function getDataProvider(): array
    {
        return [
            'single' => [
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
     * @throws OrderDestroyException
     */
    public function testSuccessfulOrderDestroyUseCaseExecution(
        int              $orderId,
        OrderResponseDTO $responseDTO,
        array            $expectedResponse
    ): void {
        $this->showUseCaseMock
            ->shouldReceive('execute')
            ->once()
            ->with($orderId)
            ->andReturn($responseDTO);

        $this->repositoryMock
            ->shouldReceive('make')
            ->once()
            ->with($responseDTO);

        $response = $this->orderDestroyUseCase->execute($orderId);

        $this->assertEqualsCanonicalizing($expectedResponse, $response->order->toArray());
    }

    /**
     * @dataProvider getDataProvider
     */
    public function testFailedOrderShowUseCaseCall(int $id): void
    {
        $this->showUseCaseMock
            ->shouldReceive('execute')
            ->once()
            ->andThrow(new Exception());

        $this->repositoryMock
            ->shouldReceive('make')
            ->never();

        $this->expectException(OrderDestroyException::class);

        $this->orderDestroyUseCase->execute($id);
    }

    /**
     * @dataProvider getDataProvider
     */
    public function testFailedOrderDestroyRepositoryCall(int $id, OrderResponseDTO $responseDTO): void
    {
        $this->showUseCaseMock
            ->shouldReceive('execute')
            ->once()
            ->andReturn($responseDTO);

        $this->repositoryMock
            ->shouldReceive('make')
            ->once()
            ->andThrow(new Exception());

        $this->expectException(OrderDestroyException::class);

        $this->orderDestroyUseCase->execute($id);
    }
}
