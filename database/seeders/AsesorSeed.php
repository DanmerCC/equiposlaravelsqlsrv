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

        /**open csv */
        $filename = "asesores.csv";
        $row = 1;

        $dni = 0;
        $apellido_paterno = 1;
        $apellido_materno = 2;
        $nombres = 3;
        $equipo = 6;
        $estado = 8;
        //$apellido_materno = 0;
        $estado = 8;

        $asesormap = [];
        if (($handle = fopen($filename, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {

                $num = count($data);
                $row++;

                if (!isset($asesormap[$data[$dni]])) {
                    $asesormap[$data[$dni]] = $data[$apellido_paterno] . $data[$apellido_materno] . $data[$nombres];
                    $asesornew = Asesor::create([
                        "dni" => $data[$dni],
                        "nombres" => $data[$nombres],
                        "apellido_paterno" => $data[$apellido_paterno],
                        "apellido_materno" => $data[$apellido_materno],
                        "equipo" => $data[$equipo],
                        "estado" => $data[$estado],
                    ]);
                }
            }
            fclose($handle);
        }
    }
}
