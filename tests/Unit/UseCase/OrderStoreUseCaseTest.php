<?php

namespace Tests\Unit\UseCase;

use App\DTO\OrderStoreRequestDTO;
use App\DTO\OrderResponseDTO;
use App\Helpers\Interfaces\EventDispatcherInterface;
use App\Models\Order;
use App\Repositories\Interfaces\OrderStoreRepositoryInterface;
use App\UseCases\Exceptions\OrderStoreException;
use App\UseCases\OrderStoreUseCase;
use Exception;
use Mockery;
use PHPUnit\Framework\TestCase;

class OrderStoreUseCaseTest extends TestCase
{
    private OrderStoreRepositoryInterface $repositoryMock;
    private EventDispatcherInterface $eventDispatcherMock;
    private OrderStoreUseCase $orderStoreUseCase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repositoryMock = Mockery::mock(OrderStoreRepositoryInterface::class);
        $this->eventDispatcherMock = Mockery::mock(EventDispatcherInterface::class);
        $this->orderStoreUseCase = new OrderStoreUseCase($this->repositoryMock, $this->eventDispatcherMock);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        Mockery::close();
    }

    public function getDataProvider(): array
    {
        $requestDTO = new OrderStoreRequestDTO(
            'testAgencyName',
            now(),
            1,
            1,
            'testUserName',
            'testEmail',
            'testPhone'
        );

        return [
            'single' => [
                'requestDTO' => $requestDTO,
                'responseDTO' => new OrderResponseDTO(new Order()),
            ],
        ];
    }

    /**
     * @dataProvider getDataProvider
     * @throws OrderStoreException
     */
    public function testSuccessfulOrderStoreUseCaseExecution(
        OrderStoreRequestDTO $requestDTO,
        OrderResponseDTO     $responseDTO
    ): void {
        $this->repositoryMock
            ->shouldReceive('make')
            ->once()
            ->with($requestDTO)
            ->andReturn($responseDTO);

        $this->eventDispatcherMock
            ->shouldReceive('dispatch')
            ->once();

        $response = $this->orderStoreUseCase->execute($requestDTO);

        $this->assertEqualsCanonicalizing($responseDTO->order->toArray(), $response->order->toArray());
    }

    /**
     * @dataProvider getDataProvider
     */
    public function testFailedStoreOrderServiceCall(OrderStoreRequestDTO $requestDTO): void
    {
        $this->repositoryMock
            ->shouldReceive('make')
            ->once()
            ->andThrow(new Exception());

        $this->eventDispatcherMock
            ->shouldReceive('dispatch')
            ->never();

        $this->expectException(OrderStoreException::class);

        $this->orderStoreUseCase->execute($requestDTO);
    }
}
