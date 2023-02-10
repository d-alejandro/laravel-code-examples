<?php

namespace Tests\Unit\UseCase;

use App\DTO\OrderStoreRequestDTO;
use App\DTO\OrderResponseDTO;
use App\Enums\OrderStatusEnum;
use App\Helpers\Interfaces\EventDispatcherInterface;
use App\Models\Enums\OrderColumn;
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
            agencyName: 'TestAgencyName',
            rentalDate: now(),
            guestCount: 1,
            transportCount: 1,
            userName: 'TestUserName',
            email: 'test@test.com',
            phone: '+7 (777) 1111 111'
        );

        return [
            'single' => [
                'requestDTO' => $requestDTO,
                'responseDTO' => new OrderResponseDTO(new Order()),
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
     * @throws OrderStoreException
     */
    public function testSuccessfulOrderStoreUseCaseExecution(
        OrderStoreRequestDTO $requestDTO,
        OrderResponseDTO     $responseDTO,
        array                $expectedResponse
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

        $this->assertEquals($expectedResponse, $response->order->toArray());
    }

    /**
     * @dataProvider getDataProvider
     */
    public function testFailedOrderStoreRepositoryCall(OrderStoreRequestDTO $requestDTO): void
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
