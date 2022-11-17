<?php

namespace Database\Seeders;

use App\Models\Asesor;
use App\Models\Equipo;
use Illuminate\Database\Seeder;

class EquipoSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Equipo::factory()->count(3000)->create();

        $filename = "equiposdata.csv";
        $row = 1;

        $dni = 0;

        $serie = 3;
        $color = 4;
        $modelo = 5;
        $marca = 6;
        $ubicacion = 7;
        $observacion = 8;
        $proveedor = 9;
        $fecha_facturacion = 10;
        $estado_equipo = 16;
        $tipo_disco = 13;
        $procesador = 10;
        $generacion = 11;
        $supervisor_id = 2;
        $index_col2nombreestado = 1;
        $precio = 20;
        $so = 21;
        $asesor_dni = 22;

        //$apellido_materno = 0;
        $estado = 8;

        $asesormap = [];
        if (($handle = fopen($filename, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {

                $num = count($data);
                $row++;

                echo var_dump($row,$data);

                if (!isset($asesormap[$data[$dni]])) {
                    //$asesormap[$data[$dni]] = $data[$apellido_paterno] . $data[$apellido_materno] . $data[$nombres];
                    $asesor = Asesor::whereDni( $data[$asesor_dni] )->first();
                    $estado = null;
                    $col2nombreestado = $data[$index_col2nombreestado];

                    if($col2nombreestado == "MALOGRADOS"){
                        $estado = "MALOGRADO";
                    }else {
                        $estado = "OPERATIVO";
                    }
                    $asesornew = Equipo::create([
                        //"grupo" => $data[$dni],
                        "marca" => $data[$marca],
                        "modelo" => $data[$modelo],
                        "color" => $data[$color],
                        "serie" => $data[$serie],
                        "fecha_compra" => $data[$fecha_facturacion],
                        "observacion" => $data[$observacion],
                        "procesador" => $data[$procesador],
                        "estado" => $estado,
                        "tipo_disco" => $data[$tipo_disco],
                        "precio" => $data[$precio],
                        "asesor_id" => $asesor == null ? null : $asesor->id,
                        //"capacidad_disco_duro" => $data[$capacidad_disco_duro],
                        "supervisor_id" => $asesor == null ? null : $asesor->id,
                    ]);
                }
            }
            fclose($handle);
        }
    }
}
