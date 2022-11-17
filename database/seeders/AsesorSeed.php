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
                if($row<=2){
                    continue;
                }

                if (!isset($asesormap[$data[$dni]])) {
                    $asesormap[$data[$dni]] = $data[$apellido_paterno] . $data[$apellido_materno] . $data[$nombres];
                    //$asesorRandom = Asesor::whereDni($dni)->first();
                    $asesornew = Asesor::create([
                        "dni" => $data[$dni],
                        "nombres" => $data[$nombres],
                        "apellido_paterno" => $data[$apellido_paterno],
                        "apellido_materno" => $data[$apellido_materno],
                        //"equipo_id" => $asesorRandom != null ? $asesorRandom->id : null,
                        "estado" => $data[$estado],
                    ]);
                }
            }
            fclose($handle);
        }
    }
}
