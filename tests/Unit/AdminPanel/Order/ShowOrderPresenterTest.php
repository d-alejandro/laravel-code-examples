<?php

namespace Tests\Unit\AdminPanel\Order;

use App\Helpers\Interfaces\JsonResponseCreatorInterface;
use App\Helpers\Interfaces\JsonResponseManagerInterface;
use App\Http\Resources\AdminPanel\Order\ShowOrderResource;
use App\Models\Order;
use App\Presenter\AdminPanel\Order\ShowOrderPresenter;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Mockery;
use PHPUnit\Framework\TestCase;

class ShowOrderPresenterTest extends TestCase
{
    private JsonResponseCreatorInterface $jsonResponseCreatorMock;
    private JsonResponseManagerInterface $jsonResponseManagerMock;
    private ShowOrderPresenter $showOrderPresenter;

    protected function setUp(): void
    {
        parent::setUp();

        $this->jsonResponseCreatorMock = Mockery::mock(JsonResponseCreatorInterface::class);
        $this->jsonResponseManagerMock = Mockery::mock(JsonResponseManagerInterface::class);

        $this->showOrderPresenter = new ShowOrderPresenter(
            $this->jsonResponseCreatorMock,
            $this->jsonResponseManagerMock
        );
    }

    public function getDataProvider(): array
    {
        $expectedData = ['testColumn' => 'testValue'];

        return [
            'single' => [
                'order' => new Order(),
                'jsonResponse' => new JsonResponse($expectedData),
                'expectedData' => $expectedData,
            ],
        ];
    }

    /**
     * @dataProvider getDataProvider
     */
    public function testSuccessfulShowOrderPresenterExecution(
        Order $order,
        JsonResponse $jsonResponse,
        array $expectedData
    ): void {
        $this->jsonResponseCreatorMock
            ->shouldReceive('createFromResource')
            ->once()
            ->with(ShowOrderResource::class, $order)
            ->andReturn($jsonResponse);

        $this->jsonResponseManagerMock
            ->shouldReceive('setStatusCode')
            ->once()
            ->with($jsonResponse, Response::HTTP_OK);

        $response = $this->showOrderPresenter->present($order);

        $this->assertEqualsCanonicalizing($expectedData, (array)$response->getData());
    }

    /**
     * @dataProvider getDataProvider
     */
    public function testFailedJsonResponseCreatorCall(Order $order): void
    {
        $this->jsonResponseCreatorMock
            ->shouldReceive('createFromResource')
            ->once()
            ->andThrow(new Exception());

        $this->jsonResponseManagerMock
            ->shouldReceive('setStatusCode')
            ->never();

        $this->expectException(Exception::class);

        $this->showOrderPresenter->present($order);
    }
}
