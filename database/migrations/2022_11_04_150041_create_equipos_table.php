<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEquiposTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equipos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('asesor_id')->nullable();
            $table->unsignedBigInteger('supervisor_id')->nullable();
            $table->string('marca');
            $table->string('modelo');
            $table->string('color');
            $table->string('serie');
            $table->string('grupo');
            $table->date('fecha_compra');
            $table->string('observacion')->nullable();
            $table->enum('estado', ['OPERATIVO', 'MALOGRADO']);
            $table->string('procesador')->nullable();
            $table->string('memoria')->nullable();
            $table->string('capacidad_disco_duro')->nullable();
            $table->enum('tipo_disco', ['SOLIDO', 'MECANICO'])->nullable();
            $table->timestamps();
            $table->foreign('asesor_id')->references('id')->on('asesors');
            $table->foreign('supervisor_id')->references('id')->on('asesors');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('equipos');
    }
}
