<?php

namespace Tests\Unit\UseCase;

use App\DTO\PaginationDTO;
use App\DTO\OrderIndexRequestDTO;
use App\DTO\OrderIndexResponseDTO;
use App\Enums\OrderStatusEnum;
use App\Enums\SortTypeEnum;
use App\Models\Enums\OrderColumn;
use App\Models\Order;
use App\Repositories\Interfaces\OrderIndexRepositoryInterface;
use App\UseCases\Exceptions\OrderIndexUseCasesException;
use App\UseCases\OrderIndexUseCase;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Mockery;
use PHPUnit\Framework\TestCase;

class OrderIndexUseCaseTest extends TestCase
{
    private OrderIndexUseCase $orderIndexUseCase;
    private OrderIndexRepositoryInterface $repositoryMock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repositoryMock = Mockery::mock(OrderIndexRepositoryInterface::class);
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

        $collection = new Collection(new Order());
        $totalRowCount = 1;

        return [
            'single' => [
                'requestDTO' => new OrderIndexRequestDTO($paginationDTO),
                'responseDTO' => new OrderIndexResponseDTO($collection, $totalRowCount),
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
     * @throws OrderIndexUseCasesException
     */
    public function testSuccessfulOrderIndexUseCaseExecution(
        OrderIndexRequestDTO  $requestDTO,
        OrderIndexResponseDTO $responseDTO,
        array                 $expectedResponse
    ): void {
        $this->repositoryMock
            ->shouldReceive('make')
            ->once()
            ->with($requestDTO)
            ->andReturn($responseDTO);

        $response = $this->orderIndexUseCase->execute($requestDTO);

        $this->assertEquals($expectedResponse, $response->collection->toArray());
    }

    /**
     * @dataProvider getDataProvider
     */
    public function testFailedOrderIndexRepositoryCall(OrderIndexRequestDTO $requestDTO): void
    {
        $this->repositoryMock
            ->shouldReceive('make')
            ->once()
            ->andThrow(new Exception());

        $this->expectException(OrderIndexUseCasesException::class);
        $this->expectExceptionMessage('An error occurred while loading orders.');

        $this->orderIndexUseCase->execute($requestDTO);
    }
}
