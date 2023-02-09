<?php

namespace Tests\Unit\UseCase;

use App\DTO\OrderResponseDTO;
use App\Enums\OrderStatusEnum;
use App\Models\Enums\OrderColumn;
use App\Models\Order;
use App\UseCases\Interfaces\OrderShowUseCaseInterface;
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

        $this->orderDestroyUseCase = new OrderDestroyUseCase(
            $this->showUseCaseMock,
            $this->repositoryMock
        );
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
     */
    public function testSuccessfulDestroyOrderUseCaseExecution(
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

        $response = $this->orderDestroyUseCase->execute($responseDTO);

        $this->assertEqualsCanonicalizing($expectedResponse, $response->order->toArray());
    }
}
