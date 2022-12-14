<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAsesorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asesors', function (Blueprint $table) {
            $table->id();
            $table->string("dni")->unique();
            $table->string("nombres");
            $table->string("apellido_paterno");
            $table->string("apellido_materno");
            $table->unsignedBigInteger('equipo_id')->nullable();
            $table->enum("estado", ["LABORANDO", "VACACIONES"]);
            $table->timestamps();
        });
        Schema::table('asesors', function (Blueprint $table) {
            $table->foreign("equipo_id")->references('id')->on("asesors");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('asesors');
    }
}
