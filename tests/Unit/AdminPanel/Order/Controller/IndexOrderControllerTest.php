<?php

namespace Tests\Unit\AdminPanel\Order\Controller;

use App\DTO\AdminPanel\Order\IndexOrderResponseDTO;
use App\Http\Controllers\Api\AdminPanel\Order\IndexOrderController;
use App\Http\Requests\AdminPanel\Order\IndexOrderRequest;
use App\Presenter\AdminPanel\Order\Interfaces\IndexOrderPresenterInterface;
use App\UseCases\AdminPanel\Order\Interfaces\IndexOrderUseCaseInterface;
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
        return [
            'single' => [
                'indexOrderResponseDTO' => new IndexOrderResponseDTO(new Collection(['testColumn' => 'testValue']), 1),
                'expectedData' => [
                    (object)['testColumn' => 'testValue'],
                ],
            ],
        ];
    }

    /**
     * @dataProvider getDataProvider
     */
    public function testSuccessfulIndexOrderControllerExecution(
        IndexOrderResponseDTO $indexOrderResponseDTO,
        array $expectedData
    ): void {
        $this->indexOrderRequestMock
            ->shouldReceive('validated')
            ->once()
            ->andReturn([]);

        $this->indexOrderUseCaseMock
            ->shouldReceive('execute')
            ->once()
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
