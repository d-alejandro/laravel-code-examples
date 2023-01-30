<?php

namespace Tests\Unit\UseCase;

use App\DTO\IndexOrderPaginationDTO;
use App\DTO\IndexOrderRequestDTO;
use App\DTO\IndexOrderResponseDTO;
use App\Enums\SortTypeEnum;
use App\Models\Enums\OrderColumn;
use App\Repositories\Interfaces\OrderSearchRepositoryInterface;
use App\UseCases\Exceptions\OrderSearchUseCasesException;
use App\UseCases\IndexOrderUseCase;
use Exception;
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
        $firstPaginationItemNumber = 0;
        $lastPaginationItemNumber = 1;

        $indexOrderPaginationDTO = new IndexOrderPaginationDTO(
            $firstPaginationItemNumber,
            $lastPaginationItemNumber,
            OrderColumn::Id,
            SortTypeEnum::Asc
        );
        $indexOrderRequestDTO = new IndexOrderRequestDTO($indexOrderPaginationDTO);

        $testData = ['testColumn' => 'testValue'];
        $collection = new Collection($testData);

        $totalRowCount = 1;

        $indexOrderResponseDTO = new IndexOrderResponseDTO($collection, $totalRowCount);

        return [
            'single' => [
                'indexOrderRequestDTO' => $indexOrderRequestDTO,
                'expectedIndexOrderResponseDTO' => $indexOrderResponseDTO,
            ],
        ];
    }

    /**
     * @dataProvider getDataProvider
     * @throws OrderSearchUseCasesException
     */
    public function testSuccessfulIndexOrderUseCaseExecution(
        IndexOrderRequestDTO  $indexOrderRequestDTO,
        IndexOrderResponseDTO $expectedIndexOrderResponseDTO
    ): void {
        $this->orderSearchRepositoryMock
            ->shouldReceive('make')
            ->once()
            ->with($indexOrderRequestDTO)
            ->andReturn($expectedIndexOrderResponseDTO);

        $response = $this->indexOrderUseCase->execute($indexOrderRequestDTO);

        $this->assertEquals($expectedIndexOrderResponseDTO, $response);
    }

    /**
     * @dataProvider getDataProvider
     */
    public function testFailedOrdersLoaderRepositoryCall(IndexOrderRequestDTO $indexOrderRequestDTO): void
    {
        $this->orderSearchRepositoryMock
            ->shouldReceive('make')
            ->once()
            ->andThrow(new Exception());

        $this->expectException(OrderSearchUseCasesException::class);
        $this->expectExceptionMessage('An error occurred while loading orders.');

        $this->indexOrderUseCase->execute($indexOrderRequestDTO);
    }
}
