<?php

namespace Tests\Unit\AdminPanel\Order\UseCase;

use App\DTO\AdminPanel\Order\IndexOrderRequestDTO;
use App\DTO\AdminPanel\Order\IndexOrderResponseDTO;
use App\Repositories\AdminPanel\Order\Interfaces\OrdersLoaderRepositoryInterface;
use App\UseCases\AdminPanel\Order\IndexOrderUseCase;
use Mockery;
use PHPUnit\Framework\TestCase;

class IndexOrderUseCaseTest extends TestCase
{
    private IndexOrderUseCase $indexOrderUseCase;
    private OrdersLoaderRepositoryInterface $ordersLoaderRepositoryMock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->ordersLoaderRepositoryMock = Mockery::mock(OrdersLoaderRepositoryInterface::class);

        $this->indexOrderUseCase = new IndexOrderUseCase($this->ordersLoaderRepositoryMock);
    }

    public function testSuccessfulIndexOrderUseCaseExecution(
        IndexOrderRequestDTO  $indexOrderRequestDTO,
        IndexOrderResponseDTO $expectedResponse
    ): void {
        $this->ordersLoaderRepositoryMock
            ->shouldReceive('make')
            ->once()
            ->with($indexOrderRequestDTO)
            ->andReturn($expectedResponse);

        $response = $this->indexOrderUseCase->execute($indexOrderRequestDTO);

        $this->assertEquals($expectedResponse, $response);
    }
}
