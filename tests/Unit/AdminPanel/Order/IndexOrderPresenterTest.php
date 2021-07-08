<?php

namespace Tests\Unit\AdminPanel\Order;

use App\DTO\AdminPanel\Order\IndexOrderResponseDTO;
use App\Helpers\Interfaces\JsonResponseCreatorInterface;
use App\Helpers\Interfaces\JsonResponseManagerInterface;
use App\Http\Resources\AdminPanel\Order\IndexOrderResource;
use App\Presenter\AdminPanel\Order\IndexOrderPresenter;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Mockery;
use PHPUnit\Framework\TestCase;

class IndexOrderPresenterTest extends TestCase
{
    private JsonResponseCreatorInterface $jsonResponseCreatorMock;
    private JsonResponseManagerInterface $jsonResponseManagerMock;
    private IndexOrderPresenter $indexOrderPresenter;

    protected function setUp(): void
    {
        parent::setUp();

        $this->jsonResponseCreatorMock = Mockery::mock(JsonResponseCreatorInterface::class);
        $this->jsonResponseManagerMock = Mockery::mock(JsonResponseManagerInterface::class);

        $this->indexOrderPresenter = new IndexOrderPresenter(
            $this->jsonResponseCreatorMock,
            $this->jsonResponseManagerMock
        );
    }

    public function getDataProvider(): array
    {
        $expectedData = [
            (object)['testColumn' => 'testValue'],
        ];

        $resourceCollection = new Collection($expectedData);

        $totalRowCount = 1;

        $indexOrderResponseDTO = new IndexOrderResponseDTO($resourceCollection, $totalRowCount);

        return [
            'single' => [
                'indexOrderResponseDTO' => $indexOrderResponseDTO,
                'resourceCollection' => $resourceCollection,
                'jsonResponse' => new JsonResponse($expectedData),
                'expectedData' => $expectedData,
                'expectedTotalCount' => $totalRowCount,
            ],
        ];
    }

    /**
     * @dataProvider getDataProvider
     */
    public function testSuccessfulIndexOrderPresenterExecution(
        IndexOrderResponseDTO $indexOrderResponseDTO,
        Collection $resourceCollection,
        JsonResponse $jsonResponse,
        array $expectedData,
        int $expectedTotalCount
    ): void {
        $this->jsonResponseCreatorMock
            ->shouldReceive('createFromResourceCollection')
            ->once()
            ->with(IndexOrderResource::class, $resourceCollection)
            ->andReturn($jsonResponse);

        $this->jsonResponseManagerMock
            ->shouldReceive('setHeader')
            ->once()
            ->with($jsonResponse, 'X-Total-Count', $expectedTotalCount);

        $this->jsonResponseManagerMock
            ->shouldReceive('setStatusCode')
            ->once()
            ->with($jsonResponse, Response::HTTP_OK);

        $response = $this->indexOrderPresenter->present($indexOrderResponseDTO);

        $this->assertEqualsCanonicalizing($expectedData, $response->getData());
    }

    /**
     * @dataProvider getDataProvider
     */
    public function testFailedJsonResponseCreatorCall(IndexOrderResponseDTO $indexOrderResponseDTO): void
    {
        $this->jsonResponseCreatorMock
            ->shouldReceive('createFromResourceCollection')
            ->once()
            ->andThrow(new Exception());

        $this->jsonResponseManagerMock
            ->shouldReceive('setHeader')
            ->never();

        $this->jsonResponseManagerMock
            ->shouldReceive('setStatusCode')
            ->never();

        $this->expectException(Exception::class);

        $this->indexOrderPresenter->present($indexOrderResponseDTO);
    }
}
