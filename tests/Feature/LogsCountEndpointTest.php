<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LogsCountEndpointTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testLogsCountEndpoint(): void
    {
        $response = $this->withHeaders(
            [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ]
        )->get('/api/v1/logs/count');

        $response->assertStatus(200);

        $response->assertJson(
            [
                'count' => 10
            ]
        );
    }
}
