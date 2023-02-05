<?php

namespace Tests\Unit\UseCase;

use App\DTO\PaginationDTO;
use App\DTO\OrderIndexRequestDTO;
use App\DTO\OrderIndexResponseDTO;
use App\Enums\SortTypeEnum;
use App\Models\Enums\OrderColumn;
use App\Repositories\Interfaces\OrderSearchRepositoryInterface;
use App\UseCases\Exceptions\OrderSearchUseCasesException;
use App\UseCases\OrderIndexUseCase;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Mockery;
use PHPUnit\Framework\TestCase;

class OrderIndexUseCaseTest extends TestCase
{
    private OrderIndexUseCase $orderIndexUseCase;
    private OrderSearchRepositoryInterface $repositoryMock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repositoryMock = Mockery::mock(OrderSearchRepositoryInterface::class);
        $this->orderIndexUseCase = new OrderIndexUseCase($this->repositoryMock);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        Mockery::close();
    }

    public function getDataProvider(): array
    {
        $paginationDTO = new PaginationDTO(0, 1, OrderColumn::Id, SortTypeEnum::Asc);

        $testData = ['testColumn' => 'testValue'];
        $collection = new Collection($testData);

        $totalRowCount = 1;

        return [
            'single' => [
                'requestDTO' => new OrderIndexRequestDTO($paginationDTO),
                'expectedResponseDTO' => new OrderIndexResponseDTO($collection, $totalRowCount),
            ],
        ];
    }

    /**
     * @dataProvider getDataProvider
     * @throws OrderSearchUseCasesException
     */
    public function testSuccessfulOrderIndexUseCaseExecution(
        OrderIndexRequestDTO  $requestDTO,
        OrderIndexResponseDTO $responseDTO
    ): void {
        $this->repositoryMock
            ->shouldReceive('make')
            ->once()
            ->with($requestDTO)
            ->andReturn($responseDTO);

        $response = $this->orderIndexUseCase->execute($requestDTO);

        $this->assertEquals($responseDTO, $response);
    }

    /**
     * @dataProvider getDataProvider
     */
    public function testFailedOrderSearchRepositoryCall(OrderIndexRequestDTO $requestDTO): void
    {
        $this->repositoryMock
            ->shouldReceive('make')
            ->once()
            ->andThrow(new Exception());

        $this->expectException(OrderSearchUseCasesException::class);
        $this->expectExceptionMessage('An error occurred while loading orders.');

        $this->orderIndexUseCase->execute($requestDTO);
    }
}
