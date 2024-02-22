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
        return [
            'title'       => $this->faker->word,
            'description' => $this->faker->realText(50),
            'image'       => $this->faker->imageUrl,
            'on_sale'     => true,
            'price'       => $this->faker->randomNumber(3),
        ];
    }
}
