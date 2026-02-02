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
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id('id');
            $table->string('nombre', 30);
            $table->string('s_nombre', 30)->nullable();
            $table->string('apellido', 30);
            $table->string('s_apellido', 30);
            $table->string('t_documento', 50);
            $table->unsignedBigInteger('n_documento')->unique();
            $table->date('fecha_nacimiento');
            $table->string('telefono', 15);
            $table->string('direccion', 75);
            $table->string('correo', 150)->unique();
            $table->string('contrasena', 1000);
            $table->string('foto', 1000)->nullable();
            $table->double('prom_puntuaciones')->default(1);
            $table->string('api_key', 500)->unique();
            $table->boolean('estado_perfil')->default(1);
            $table->unsignedBigInteger('rol_id');
            $table->unsignedBigInteger('categoria_id');
            $table->boolean('estado')->default(1);

            $table->foreign('rol_id')->references('id')->on('roles')->onDelete('cascade');
            $table->foreign('categoria_id')->references('id')->on('categorias')->onDelete('cascade');
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
