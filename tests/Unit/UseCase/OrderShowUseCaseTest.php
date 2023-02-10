<?php

namespace Tests\Unit\UseCase;

use App\DTO\OrderResponseDTO;
use App\Enums\OrderStatusEnum;
use App\Models\Enums\OrderColumn;
use App\Models\Order;
use App\Repositories\Interfaces\OrderShowRepositoryInterface;
use App\UseCases\Exceptions\OrderNotFoundException;
use App\UseCases\OrderShowUseCase;
use Exception;
use Mockery;
use PHPUnit\Framework\TestCase;

class OrderShowUseCaseTest extends TestCase
{
    private OrderShowRepositoryInterface $repositoryMock;
    private OrderShowUseCase $orderShowUseCase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repositoryMock = Mockery::mock(OrderShowRepositoryInterface::class);

        $this->orderShowUseCase = new OrderShowUseCase($this->repositoryMock);
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
            ],
        ];
    }

    /**
     * @dataProvider getDataProvider
     * @throws OrderNotFoundException
     */
    public function testSuccessfulOrderShowUseCaseExecution(
        int              $orderId,
        OrderResponseDTO $responseDTO,
        array            $expectedResponse
    ): void {
        $this->repositoryMock
            ->shouldReceive('make')
            ->once()
            ->with($orderId)
            ->andReturn($responseDTO);

        $response = $this->orderShowUseCase->execute($orderId);

        $this->assertEquals($expectedResponse, $response->order->toArray());
    }

    /**
     * @dataProvider getDataProvider
     */
    public function testFailedOrderShowRepositoryCall(int $id): void
    {
        $this->repositoryMock
            ->shouldReceive('make')
            ->once()
            ->andThrow(new Exception());

        $this->expectException(OrderNotFoundException::class);

        $this->orderShowUseCase->execute($id);
    }
}
