<?php

namespace Tests\Unit\AdminPanel\Order;

use App\Helpers\Interfaces\JsonResponseCreatorInterface;
use App\Helpers\Interfaces\JsonResponseManagerInterface;
use App\Http\Resources\AdminPanel\Order\OrderResource;
use App\Models\Order;
use App\Presenter\AdminPanel\Order\OrderPresenter;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Mockery;
use PHPUnit\Framework\TestCase;

class OrderPresenterTest extends TestCase
{
    private JsonResponseCreatorInterface $jsonResponseCreatorMock;
    private JsonResponseManagerInterface $jsonResponseManagerMock;
    private OrderPresenter $orderPresenter;

    protected function setUp(): void
    {
        parent::setUp();

        $this->jsonResponseCreatorMock = Mockery::mock(JsonResponseCreatorInterface::class);
        $this->jsonResponseManagerMock = Mockery::mock(JsonResponseManagerInterface::class);

        $this->orderPresenter = new OrderPresenter(
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
    public function testSuccessfulStoreOrderPresenterExecution(
        Order $order,
        JsonResponse $jsonResponse,
        array $expectedData
    ) {
        $this->jsonResponseCreatorMock
            ->shouldReceive('createFromResource')
            ->once()
            ->with(OrderResource::class, $order)
            ->andReturn($jsonResponse);

        $this->jsonResponseManagerMock
            ->shouldReceive('setStatusCode')
            ->once()
            ->with($jsonResponse, Response::HTTP_OK);

        $response = $this->orderPresenter->present($order);

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

        $this->orderPresenter->present($order);
    }
}
