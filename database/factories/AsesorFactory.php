<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Testing\WithFaker;

class AsesorFactory extends Factory
{
    use WithFaker;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nombres' => $this->faker->name(),
            'dni' => $this->faker->randomNumber(8),
            'apellido_paterno' => $this->faker->lastName(),
            'apellido_materno' => $this->faker->lastName(),
            'estado' => $this->faker->randomElement(["LABORANDO", "VACACIONES"])
        ];
    }
}
