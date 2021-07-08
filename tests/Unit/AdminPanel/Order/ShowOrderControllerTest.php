<?php

namespace Tests\Unit\AdminPanel\Order;

use App\Http\Controllers\Api\AdminPanel\Order\ShowOrderController;
use App\Models\Order;
use App\Presenter\AdminPanel\Order\Interfaces\ShowOrderPresenterInterface;
use App\UseCases\AdminPanel\Order\Interfaces\ShowOrderUseCaseInterface;
use Exception;
use Illuminate\Http\JsonResponse;
use Mockery;
use PHPUnit\Framework\TestCase;

class ShowOrderControllerTest extends TestCase
{
    private ShowOrderUseCaseInterface $showOrderUseCaseMock;
    private ShowOrderPresenterInterface $showOrderPresenterMock;
    private ShowOrderController $showOrderController;

    protected function setUp(): void
    {
        parent::setUp();

        $this->showOrderUseCaseMock = Mockery::mock(ShowOrderUseCaseInterface::class);
        $this->showOrderPresenterMock = Mockery::mock(ShowOrderPresenterInterface::class);

        $this->showOrderController = new ShowOrderController(
            $this->showOrderUseCaseMock,
            $this->showOrderPresenterMock
        );
    }

    public function getDataProvider(): array
    {
        return [
            'single' => [
                'id' => 1,
                'order' => new Order(),
                'expectedData' => ['testColumn' => 'testValue'],
            ],
        ];
    }

    /**
     * @dataProvider getDataProvider
     */
    public function testSuccessfulShowOrderControllerExecution(int $id, Order $order, array $expectedData): void
    {
        $this->showOrderUseCaseMock
            ->shouldReceive('execute')
            ->once()
            ->with($id)
            ->andReturn($order);

        $this->showOrderPresenterMock
            ->shouldReceive('present')
            ->once()
            ->with($order)
            ->andReturn(new JsonResponse($expectedData));

        $response = $this->showOrderController->__invoke($id);

        $this->assertEqualsCanonicalizing($expectedData, (array)$response->getData());
    }

    /**
     * @dataProvider getDataProvider
     */
    public function testFailedShowOrderUseCaseCall(int $id): void
    {
        $this->showOrderUseCaseMock
            ->shouldReceive('execute')
            ->once()
            ->andThrow(new Exception());

        $this->showOrderPresenterMock
            ->shouldReceive('present')
            ->never();

        $this->expectException(Exception::class);

        $this->showOrderController->__invoke($id);
    }

    /**
     * @dataProvider getDataProvider
     */
    public function testFailedShowOrderPresenterCall(int $id, Order $order): void
    {
        $this->showOrderUseCaseMock
            ->shouldReceive('execute')
            ->once()
            ->andReturn($order);

        $this->showOrderPresenterMock
            ->shouldReceive('present')
            ->once()
            ->andThrow(new Exception());

        $this->expectException(Exception::class);

        $this->showOrderController->__invoke($id);
    }
}
