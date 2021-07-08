<?php

namespace Tests\Unit\AdminPanel\Order;

use App\DTO\AdminPanel\Order\IndexOrderRequestDTO;
use App\DTO\AdminPanel\Order\IndexOrderResponseDTO;
use App\Repositories\AdminPanel\Order\Interfaces\OrdersLoaderRepositoryInterface;
use App\UseCases\AdminPanel\Order\Exceptions\OrdersLoadingException;
use App\UseCases\AdminPanel\Order\IndexOrderUseCase;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Mockery;
use PHPUnit\Framework\TestCase;

class IndexOrderUseCaseTest extends TestCase
{
    private OrdersLoaderRepositoryInterface $ordersLoaderRepositoryMock;
    private IndexOrderUseCase $indexOrderUseCase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->ordersLoaderRepositoryMock = Mockery::mock(OrdersLoaderRepositoryInterface::class);

        $this->indexOrderUseCase = new IndexOrderUseCase($this->ordersLoaderRepositoryMock);
    }

    public function getDataProvider(): array
    {
        return [
            'single' => [
                'indexOrderRequestDTO' => new IndexOrderRequestDTO([]),
                'expectedResponse' => new IndexOrderResponseDTO(new Collection(['testColumn' => 'testValue']), 1),
            ],
        ];
    }

    /**
     * @dataProvider getDataProvider
     */
    public function testSuccessfulIndexOrderUseCaseExecution(
        IndexOrderRequestDTO $indexOrderRequestDTO,
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

    /**
     * @dataProvider getDataProvider
     */
    public function testFailedOrdersLoaderRepositoryCall(IndexOrderRequestDTO $indexOrderRequestDTO): void
    {
        $this->ordersLoaderRepositoryMock
            ->shouldReceive('make')
            ->once()
            ->andThrow(new Exception());

        $this->expectException(OrdersLoadingException::class);
        $this->expectExceptionMessage('An error occurred while loading orders.');

        $this->indexOrderUseCase->execute($indexOrderRequestDTO);
    }
}
