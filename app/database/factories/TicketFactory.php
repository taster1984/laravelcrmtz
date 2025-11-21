<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ticket>
 */
class TicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $customer = Customer::inRandomOrder()->first() ?? Customer::factory()->create();

        return [
            'customer_id' => $customer->id,
            'subject' => $this->faker->sentence(6, true), // короткая тема заявки
            'body' => $this->faker->paragraph(3, true),   // текст заявки
            'status' => $this->faker->randomElement(['new', 'in_progress', 'processed']),
            'response_date' => $this->faker->optional()->dateTimeBetween('-1 week', 'now'),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
