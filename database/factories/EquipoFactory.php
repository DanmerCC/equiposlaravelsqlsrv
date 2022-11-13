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
        $rand = rand(0, 5);
        return [
            'asesor_id' => $rand != 0 ? ((Asesor::inRandomOrder()->first())->id) : null,
            'grupo' => $this->faker->randomElement(['STASFF', 'JORGE']),
            'marca' => $this->faker->text(150),
            'modelo' => $this->faker->text(150),
            'color' => $this->faker->colorName(),
            'serie' => $this->faker->text(150),
            'fecha_compra' => $this->faker->date(),
            'procesador' => $this->faker->text(10),
            'memoria' => $this->faker->randomDigit() . " " . $this->faker->text(5),
            'disco_duro' => $this->faker->randomElement(["MECANICO", "SOLIDO"]),
        ];
    }
}
