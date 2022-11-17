<?php

namespace Database\Seeders;

use App\Models\Asesor;
use App\Models\Equipo;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

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
        $tipo_disco = 19;
        $procesador = 14;
        $generacion = 11;
        $supervisor_id = 2;
        $index_col2nombreestado = 1;
        $precio = 20;
        $so = 21;
        $asesor_dni = 22;
        $index_disco_duro = 18;

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

                echo var_dump($row,$data);

                if (!isset($asesormap[$data[$dni]])) {
                    //$asesormap[$data[$dni]] = $data[$apellido_paterno] . $data[$apellido_materno] . $data[$nombres];
                    $asesor = Asesor::whereDni( $data[$asesor_dni] )->first();
                    $supervisor = Asesor::whereDni( $data[$supervisor_id] )->first();
                    $estado = null;
                    $col2nombreestado = $data[$index_col2nombreestado];
                    $disco_duro = $data[$index_disco_duro];

                    if($col2nombreestado == "MALOGRADOS"){
                        $estado = "MALOGRADO";
                    }else {
                        $estado = "OPERATIVO";
                    }

                    $regex_disco = [];
                    preg_match("/([0-9]*)/",$disco_duro,$regex_disco);
                    if(count($regex_disco)>0){
                        $disco_duro_medida = $regex_disco[0];
                        echo $disco_duro_medida;
                    }

                    $asesornew = Equipo::create([
                        //"grupo" => $data[$dni],
                        "marca" => $data[$marca],
                        "modelo" => $data[$modelo],
                        "color" => $data[$color],
                        "serie" => $data[$serie],
                        "fecha_compra" => $this->secureTransformDates($data[$fecha_facturacion]),
                        "observacion" => $data[$observacion],
                        "procesador" => $data[$procesador],
                        "estado" => $estado,
                        "tipo_disco" => $data[$tipo_disco],
                        "precio" => str_replace(",","",str_replace("S/ ","",$data[$precio])),
                        "asesor_id" => $asesor == null ? null : $asesor->id,
                        "capacidad_disco_duro" => $disco_duro_medida,
                        "supervisor_id" => $supervisor == null ? null : $supervisor->id,
                    ]);
                }
            }
            fclose($handle);
        }
    }

    function secureTransformDates($string){
        try {
            return Carbon::createFromFormat("d/m/Y",$string)->format("Y-m-d");
        } catch (\Throwable $th) {
            Log::info($th->getMessage());
            return null;
        }
    }
}
