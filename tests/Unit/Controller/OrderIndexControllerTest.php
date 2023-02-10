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
        $paginationDTO = new PaginationDTO(
            start: 0,
            end: 1,
            sortColumn: OrderColumn::Id,
            sortType: SortTypeEnum::Asc
        );

        $totalRowCount = 1;

        $expectedResponse = ['testKey' => 'testValue'];

        return [
            'single' => [
                'requestDTO' => new OrderIndexRequestDTO($paginationDTO),
                'responseDTO' => new OrderIndexResponseDTO(collect(), $totalRowCount),
                'presenterResponse' => new JsonResponse($expectedResponse),
                'expectedResponse' => $expectedResponse,
            ],
        ];
    }

    /**
     * @dataProvider getDataProvider
     */
    public function testSuccessfulOrderIndexControllerExecution(
        OrderIndexRequestDTO  $requestDTO,
        OrderIndexResponseDTO $responseDTO,
        JsonResponse          $presenterResponse,
        array                 $expectedResponse
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
            ->andReturn($presenterResponse);

        $response = $this->orderIndexController->__invoke($this->requestMock);

        $this->assertEquals($expectedResponse, $response->getData(true));
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
            ->andReturn($responseDTO);

        $this->presenterMock
            ->shouldReceive('present')
            ->once()
            ->andThrow(new Exception());

        $this->expectException(Exception::class);

        $this->orderIndexController->__invoke($this->requestMock);
    }
}
