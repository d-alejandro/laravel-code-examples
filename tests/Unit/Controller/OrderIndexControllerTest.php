<?php

namespace Tests\Unit\Controller;

use App\DTO\PaginationDTO;
use App\DTO\OrderIndexRequestDTO;
use App\DTO\OrderIndexResponseDTO;
use App\Enums\SortTypeEnum;
use App\Http\Controllers\Api\OrderIndexController;
use App\Http\Requests\Interfaces\OrderIndexRequestInterface;
use App\Models\Enums\OrderColumn;
use App\Presenters\Interfaces\OrderListPresenterInterface;
use App\UseCases\Interfaces\OrderIndexUseCaseInterface;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Mockery;
use PHPUnit\Framework\TestCase;

class OrderIndexControllerTest extends TestCase
{
    private OrderIndexUseCaseInterface $useCaseMock;
    private OrderListPresenterInterface $presenterMock;
    private OrderIndexController $orderIndexController;
    private OrderIndexRequestInterface $requestMock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->useCaseMock = Mockery::mock(OrderIndexUseCaseInterface::class);
        $this->presenterMock = Mockery::mock(OrderListPresenterInterface::class);

        $this->orderIndexController = new OrderIndexController($this->useCaseMock, $this->presenterMock);

        $this->requestMock = Mockery::mock(OrderIndexRequestInterface::class);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        Mockery::close();
    }

    public function getDataProvider(): array
    {
        $paginationDTO = new PaginationDTO(0, 1, OrderColumn::Id, SortTypeEnum::Asc);

        $testData = [
            'testColumn' => 'testValue',
        ];
        $collection = new Collection($testData);

        return [
            'single' => [
                'requestDTO' => new OrderIndexRequestDTO($paginationDTO),
                'responseDTO' => new OrderIndexResponseDTO($collection, 1),
                'expectedData' => [
                    (object)$testData,
                ],
            ],
        ];
    }

    /**
     * @dataProvider getDataProvider
     */
    public function testSuccessfulOrderIndexControllerExecution(
        OrderIndexRequestDTO  $requestDTO,
        OrderIndexResponseDTO $responseDTO,
        array                 $expectedData
    ): void {
        $this->requestMock
            ->shouldReceive('getValidated')
            ->once()
            ->andReturn($requestDTO);

        $this->useCaseMock
            ->shouldReceive('execute')
            ->once()
            ->with($requestDTO)
            ->andReturn($responseDTO);

        $this->presenterMock
            ->shouldReceive('present')
            ->once()
            ->with($responseDTO)
            ->andReturn(new JsonResponse($expectedData));

        $response = $this->orderIndexController->__invoke($this->requestMock);

        $this->assertEqualsCanonicalizing($expectedData, $response->getData());
    }

    /**
     * @dataProvider getDataProvider
     */
    public function testFailedOrderIndexUseCaseCall(OrderIndexRequestDTO $requestDTO): void
    {
        $this->requestMock
            ->shouldReceive('getValidated')
            ->once()
            ->andReturn($requestDTO);

        $this->useCaseMock
            ->shouldReceive('execute')
            ->once()
            ->with($requestDTO)
            ->andThrow(new Exception());

        $this->presenterMock
            ->shouldReceive('present')
            ->never();

        $this->expectException(Exception::class);

        $this->orderIndexController->__invoke($this->requestMock);
    }

    /**
     * @dataProvider getDataProvider
     */
    public function testFailedOrderIndexPresenterCall(
        OrderIndexRequestDTO  $requestDTO,
        OrderIndexResponseDTO $responseDTO
    ): void {
        $this->requestMock
            ->shouldReceive('getValidated')
            ->once()
            ->andReturn($requestDTO);

        $this->useCaseMock
            ->shouldReceive('execute')
            ->once()
            ->with($requestDTO)
            ->andReturn($responseDTO);

        $this->presenterMock
            ->shouldReceive('present')
            ->once()
            ->with($responseDTO)
            ->andThrow(new Exception());

        $this->expectException(Exception::class);

        $this->orderIndexController->__invoke($this->requestMock);
    }
}
