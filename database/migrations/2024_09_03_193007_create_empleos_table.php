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
        Schema::create('empleos', function (Blueprint $table) {
            $table->id('id');
            $table->string('nombre', 150);
            $table->string('descripcion', 500);
            $table->string('fotos', 1000)->nullable();
            $table->date('fecha_creacion');
            $table->date('fecha_cierre');
            $table->string('ubicacion', 100);
            $table->unsignedBigInteger('usuario_id');
            $table->unsignedBigInteger('categoria_id');
            $table->boolean('estado')->default(1);

            $table->foreign('usuario_id')->references('id')->on('usuarios')->onDelete('cascade');
            $table->foreign('categoria_id')->references('id')->on('categorias')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empleos');
    }
};
