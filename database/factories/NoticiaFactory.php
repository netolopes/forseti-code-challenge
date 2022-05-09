<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class NoticiaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nome' => $this->faker->name(),
            'dta' => $this->faker->date($format = 'd/m/Y', $max = 'now'),
            'hra' => $this->faker->time($format = 'H:i', $max = 'now'),
            'link' => $this->faker->url(),
            'validacao' => $this->faker->unique()->sha1()
        ];
    }


}
