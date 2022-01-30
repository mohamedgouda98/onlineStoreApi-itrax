<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CartFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $dataTime = $this->faker->dateTimeBetween('-1 month','now');
        return [
            'created_at' => $dataTime,
            'updated_at' => $dataTime,
        ];
    }
}
