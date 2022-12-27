<?php

use App\Models\Movil;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMovilsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movils', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('asesor_id')->nullable();
            $table->unsignedBigInteger('supervisor_id')->nullable();
            $table->string('nombre_equipo')->nullable();
            $table->string('marca');
            $table->string('modelo');
            $table->string('color');
            $table->string('serie');

            $table->date('fecha_compra');
            $table->string('observacion')->nullable();
            $table->enum('estado', ['OPERATIVO', 'MALOGRADO']);
            $table->string('procesador')->nullable();
            $table->string('memoria')->nullable();
            $table->decimal('precio',12,2)->nullable();
            $table->string('capacidad_disco_duro')->nullable();
            $table->enum('tipo_disco', ['SSD', 'HDD'])->nullable();
            $table->timestamps();
            $table->foreign('asesor_id')->references('id')->on('asesors');
            $table->foreign('supervisor_id')->references('id')->on('asesors');
        });

        Movil::factory()->count(100)->create();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('movils');
    }
}
