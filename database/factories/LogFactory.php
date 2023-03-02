<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Log>
 */
class LogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'service_name' => randomValue(
                [
                    'order-service',
                    'invoice-service'
                ]
            ),
            'start_date' => fake()->dateTime(),
            'end_date' => fake()->dateTime(),
            'method' => randomValue(
                [
                    'POST',
                    'GET',
                ]
            ),
            'endpoint' => randomValue(
                [
                    '/orders',
                    '/invoices',
                ]
            ),
            'protocol' => 'HTTP/1.1',
            'status_code' => randomValue([400, 402, 200, 201, 422]),
        ];
    }
}
