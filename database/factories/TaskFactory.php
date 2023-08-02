<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'taskname' => fake()->words(3, true),
            'date_sched' => fake()->date(),
            'status' => fake()->randomElement([1, 0, 0, 0, 0, 1]),
            'workspace_id' => fake()->randomElement(range(1,10))
        ];
    }
}
