<?php

namespace Database\Factories;

use App\Models\Number;
use Illuminate\Database\Eloquent\Factories\Factory;


class NumberPreferenceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'number_id' => Number::factory(),
            'name' => $this->faker->name(),
            'value' => $this->faker->word(),
        ];
    }
}
