<?php

namespace Database\Factories;

use App\Models\Asesor;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Testing\WithFaker;

class MovilFactory extends Factory
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
            'estado' => $this->faker->randomElement(['MALOGRADO', 'OPERATIVO']),
            'marca' => $this->faker->text(150),
            'modelo' => $this->faker->text(150),
            'color' => $this->faker->colorName(),
            'serie' => $this->faker->text(150),
            'fecha_compra' => $this->faker->date(),
            'procesador' => $this->faker->text(10),
            'memoria' => $this->faker->randomDigit() . " " . $this->faker->text(5),
            'tipo_disco' => $this->faker->randomElement(["MECANICO", "SOLIDO"]),
            'capacidad_disco_duro' => $this->faker->numberBetween(6, 24),
        ];
    }
}
