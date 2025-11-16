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
        $table->id();
        $table->string('nombre', 100);
        $table->string('correo', 100)->unique();
        $table->string('password', 255);
        $table->date('fecha_nacimiento')->nullable();
        $table->enum('sexo', ['Masculino', 'Femenino', 'Otro'])->nullable();
        $table->string('numero_seguro', 100)->nullable();
        $table->text('historial_medico')->nullable();
        $table->string('contacto_emergencia', 30)->nullable();
        $table->enum('rol', ['ADMIN', 'USER'])->default('USER');
        $table->timestamps(); // crea created_at y updated_at automáticamente
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
