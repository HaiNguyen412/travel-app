<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class RequestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'content' => $this->faker->text(100),
            'status' => 'open',
            'due_date' => '2022-04-30',
            'priority_id' => random_int(1, 3),
            'category_id' => random_int(1, 4),
            'created_by' => random_int(1, 10),
            'approve_id' => random_int(1, 10),
            'assignee_id' => random_int(1, 10),
        ];
    }
}
