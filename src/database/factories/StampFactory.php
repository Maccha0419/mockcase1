<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class StampFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id'=>User::factory(),
            'start_work'=>$this->faker->time(),
            'end_work'=>$this->faker->time(),
            'total_rest'=>$this->faker->time(),
            'total_work'=>$this->faker->time(),
            'stamp_date'=>$this->faker->dateTimeBetween($startDate = 'now', $endDate = 'now'),
        ];
    }
}
