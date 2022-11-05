<?php

namespace Database\Factories;

use App\Models\Asesor;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Testing\WithFaker;

class EquipoFactory extends Factory
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
            'asesor_id' => (Asesor::inRandomOrder()->first())->id,
            'grupo' => $this->faker->randomElement(['STASFF', 'JORGE']),
            'marca' => $this->faker->text(150),
            'modelo' => $this->faker->text(150),
            'color' => $this->faker->colorName(),
            'serie' => $this->faker->text(150),
            'fecha_compra' => $this->faker->date(),
        ];
    }
}
