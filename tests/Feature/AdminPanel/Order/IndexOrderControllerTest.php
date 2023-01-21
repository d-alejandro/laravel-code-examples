<?php

namespace Tests\Feature\AdminPanel\Order;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class IndexOrderControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function getDataProviderSuccessful(): array
    {
        return [
            'successful' => [
                'request' => [
                    '_start' => 0,
                    '_end' => 1,
                    '_sort' => 'id',
                    '_order' => 'desc',
                ]
            ],
        ];
    }

    /**
     * @dataProvider getDataProviderSuccessful
     */
    public function testSuccessfulExecution(array $request): void
    {
        $response = $this->json('GET', route('adminPanel.order.index'), $request);

        $response->assertStatus(Response::HTTP_OK);
    }
}
