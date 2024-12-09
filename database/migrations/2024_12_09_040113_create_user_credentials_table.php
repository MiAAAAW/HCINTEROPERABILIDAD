<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('user_credentials', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Relación con la tabla users
            $table->string('dni'); // DNI del usuario para RENIEC
            $table->string('ruc'); // RUC de la entidad asociada
            $table->string('password'); // Contraseña de RENIEC (encriptada)
            $table->timestamp('last_updated_at')->nullable(); // Última actualización de la contraseña
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_credentials');
    }
};
