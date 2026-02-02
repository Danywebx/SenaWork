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
        Schema::create('reportes', function (Blueprint $table) {
            $table->id('id');
            $table->string('tipo_reporte', 100);
            $table->string('motivo', 100);
            $table->string('comentario', 2000);
            $table->date('fecha_reporte');
            $table->unsignedBigInteger('notificador_id');
            $table->unsignedBigInteger('notificado_id')->nullable();
            $table->unsignedBigInteger('empleo_id')->nullable();
            $table->boolean('estado')->default(1);

            $table->foreign('notificador_id')->references('id')->on('usuarios')->onDelete('cascade');
            $table->foreign('notificado_id')->references('id')->on('usuarios')->onDelete('cascade');
            $table->foreign('empleo_id')->references('id')->on('empleos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reportes');
    }
};
