<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Status;
use Illuminate\Database\Eloquent\Factories\Factory;


class NumberFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'customer_id' => Customer::factory(),
            'status_id' => Status::factory(),
            'number' => $this->faker->numerify($string = '#########') ,
        ];
    }
}
