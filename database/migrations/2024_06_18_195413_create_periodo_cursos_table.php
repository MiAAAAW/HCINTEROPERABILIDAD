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
        Schema::create('periodo_cursos', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('periodo_id')->nullable();
            $table->integer('cursos_id')->nullable();
            $table->integer('created_by')->nullable();
            $table->tinyInteger('is_delete')->default(0);
            $table->tinyInteger('status')->default(0);
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('periodo_cursos');
    }
};
