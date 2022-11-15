<?php

namespace Tests\Unit\AdminPanel\Order\UseCase;

use App\DTO\AdminPanel\IndexPaginationRequestDTO;
use App\DTO\AdminPanel\Order\IndexOrderRequestDTO;
use App\DTO\AdminPanel\Order\IndexOrderResponseDTO;
use App\Enums\SortType;
use App\Repositories\AdminPanel\Order\Interfaces\OrderSearchRepositoryInterface;
use App\UseCases\AdminPanel\Order\Exceptions\OrderSearchException;
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
        $testIntegerValue = 1;

        $indexPaginationRequestDTO = new IndexPaginationRequestDTO(
            $testIntegerValue,
            $testIntegerValue,
            'testField',
            SortType::Asc
        );
        $indexOrderRequestDTO = new IndexOrderRequestDTO($indexPaginationRequestDTO);

        $indexOrderResponseDTO = new IndexOrderResponseDTO(
            new Collection(['testColumn' => 'testValue']),
            $testIntegerValue
        );

        return [
            'single' => [
                'indexOrderRequestDTO' => $indexOrderRequestDTO,
                'expectedResponse' => $indexOrderResponseDTO,
            ],
        ];
    }

    /**
     * @dataProvider getDataProvider
     * @throws OrderSearchException
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
