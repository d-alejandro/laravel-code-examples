<?php

namespace Tests\Unit\AdminPanel\Order\UseCase;

use App\DTO\AdminPanel\Order\IndexOrderRequestDTO;
use App\DTO\AdminPanel\Order\IndexOrderResponseDTO;
use App\Repositories\AdminPanel\Order\Interfaces\OrderSearchRepositoryInterface;
use App\UseCases\AdminPanel\Order\IndexOrderUseCase;
use Illuminate\Database\Eloquent\Collection;
use Mockery;
use PHPUnit\Framework\TestCase;

class IndexOrderUseCaseTest extends TestCase
{
    private IndexOrderUseCase $indexOrderUseCase;
    private OrderSearchRepositoryInterface $orderSearchRepositoryMock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->orderSearchRepositoryMock = Mockery::mock(OrderSearchRepositoryInterface::class);

        $this->indexOrderUseCase = new IndexOrderUseCase($this->orderSearchRepositoryMock);
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
        IndexOrderRequestDTO  $indexOrderRequestDTO,
        IndexOrderResponseDTO $expectedResponse
    ): void {
        $this->orderSearchRepositoryMock
            ->shouldReceive('make')
            ->once()
            ->with($indexOrderRequestDTO)
            ->andReturn($expectedResponse);

        $response = $this->indexOrderUseCase->execute($indexOrderRequestDTO);

        $this->assertEquals($expectedResponse, $response);
    }
}
