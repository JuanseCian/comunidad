<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('entregas_abrigo', function (Blueprint $table) {
            $table->id();
            // Estas tablas forman parte del esquema existente importado desde comunidad.sql.
            $table->unsignedBigInteger('persona_id')->nullable();
            $table->unsignedBigInteger('familia_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('dni', 50)->nullable();
            $table->string('apellido');
            $table->string('nombre');
            $table->string('direccion')->nullable();
            $table->unsignedInteger('colchones')->default(0);
            $table->unsignedInteger('frazadas')->default(0);
            $table->date('fecha_entrega');
            $table->text('observaciones')->nullable();
            $table->timestamps();

            $table->index('fecha_entrega');
            $table->index(['familia_id', 'fecha_entrega']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('entregas_abrigo');
    }
};
