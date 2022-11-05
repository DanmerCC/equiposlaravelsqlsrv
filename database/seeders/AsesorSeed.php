<?php

namespace Database\Seeders;

use App\Models\Asesor;
use Illuminate\Database\Seeder;

class AsesorSeed extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Asesor::factory()->count(100)->create();
    }
}
