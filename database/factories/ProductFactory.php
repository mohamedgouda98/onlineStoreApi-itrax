<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
   
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = ucwords($this->faker->word);

        return [
            'name' => $name,
            'price' => $this->faker->randomFloat(2,1,1000),
            'stock' => $this->faker->numberBetween(10,50)
        ];
    }
}
