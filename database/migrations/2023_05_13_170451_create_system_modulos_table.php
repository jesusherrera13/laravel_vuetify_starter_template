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
        Schema::create('system_modulos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('key');
            $table->string('route');
            $table->string('mdi_icon')->default('mdi-tag-outline');
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_modulos');
    }
};
