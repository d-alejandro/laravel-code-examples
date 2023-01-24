<?php

namespace Tests\Unit\Controller;

use App\DTO\IndexOrderPaginationDTO;
use App\DTO\IndexOrderRequestDTO;
use App\DTO\IndexOrderResponseDTO;
use App\Enums\OrderSortColumnEnum;
use App\Enums\SortTypeEnum;
use App\Http\Controllers\Api\IndexOrderController;
use App\Http\Requests\IndexOrderRequest;
use App\Presenter\Interfaces\IndexOrderPresenterInterface;
use App\UseCases\Interfaces\IndexOrderUseCaseInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Mockery;
use PHPUnit\Framework\TestCase;

class IndexOrderControllerTest extends TestCase
{
    private IndexOrderUseCaseInterface $indexOrderUseCaseMock;
    private IndexOrderPresenterInterface $indexOrderPresenterMock;
    private IndexOrderController $indexOrderController;
    private IndexOrderRequest $indexOrderRequestMock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->indexOrderUseCaseMock = Mockery::mock(IndexOrderUseCaseInterface::class);
        $this->indexOrderPresenterMock = Mockery::mock(IndexOrderPresenterInterface::class);

        $this->indexOrderController = new IndexOrderController(
            $this->indexOrderUseCaseMock,
            $this->indexOrderPresenterMock
        );

        $this->indexOrderRequestMock = Mockery::mock(IndexOrderRequest::class);
    }

    public function getDataProvider(): array
    {
        $firstPaginationItemNumber = 0;
        $lastPaginationItemNumber = 1;

        $indexOrderPaginationDTO = new IndexOrderPaginationDTO(
            $firstPaginationItemNumber,
            $lastPaginationItemNumber,
            OrderSortColumnEnum::Id,
            SortTypeEnum::Asc
        );

        $testData = ['testColumn' => 'testValue'];
        $collection = new Collection($testData);

        return [
            'single' => [
                'indexOrderRequestDTO' => new IndexOrderRequestDTO($indexOrderPaginationDTO),
                'indexOrderResponseDTO' => new IndexOrderResponseDTO($collection, 1),
                'expectedData' => [
                    (object)$testData,
                ],
            ],
        ];
    }

    /**
     * @dataProvider getDataProvider
     */
    public function testSuccessfulIndexOrderControllerExecution(
        IndexOrderRequestDTO  $indexOrderRequestDTO,
        IndexOrderResponseDTO $indexOrderResponseDTO,
        array                 $expectedData
    ): void {
        $this->indexOrderRequestMock
            ->shouldReceive('getValidated')
            ->once()
            ->andReturn($indexOrderRequestDTO);

        $this->indexOrderUseCaseMock
            ->shouldReceive('execute')
            ->once()
            ->with($indexOrderRequestDTO)
            ->andReturn($indexOrderResponseDTO);

        $this->indexOrderPresenterMock
            ->shouldReceive('present')
            ->once()
            ->with($indexOrderResponseDTO)
            ->andReturn(new JsonResponse($expectedData));

        $response = $this->indexOrderController->__invoke($this->indexOrderRequestMock);

        $this->assertEqualsCanonicalizing($expectedData, $response->getData());
    }
}
