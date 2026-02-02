<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('postulaciones', function (Blueprint $table) {
            $table->id('id');
            $table->date('fecha_inicio');
            $table->date('fecha_cierre');
            $table->string('estado_postulacion', 40);
            $table->integer('puntuacion_empleado');
            $table->string('comentario_empleado', 2000);
            $table->integer('puntuacion_empleador');
            $table->string('comentario_empleador', 2000);
            $table->unsignedBigInteger('usuario_id');
            $table->unsignedBigInteger('empleo_id');
            $table->boolean('estado')->default(1);

            $table->foreign('usuario_id')->references('id')->on('usuarios')->onDelete('cascade');
            $table->foreign('empleo_id')->references('id')->on('empleos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('postulaciones');
    }
};
