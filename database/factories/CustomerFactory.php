<?php

namespace Database\Factories;

use App\Models\Status;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;


class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'status_id' => Status::factory(),
            'name' => $this->faker->name(),
            'document' => $this->faker->bothify($string = '####### ??')
        ];
    }
}
