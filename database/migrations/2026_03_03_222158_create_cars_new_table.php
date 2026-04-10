<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cars_new', function (Blueprint $table) {
            $table->id();
            $table->string('brand')->index();
            $table->string('model');
            $table->year('year')->index();
            $table->decimal('price', 12, 2)->index();
            $table->text('description')->nullable();
            $table->integer('horsepower')->nullable();
            $table->enum('fuel_type', ['essence', 'diesel', 'electrique', 'hybride', 'gpl'])->default('essence');
            $table->enum('transmission', ['manuelle', 'automatique'])->default('manuelle');
            $table->string('thumbnail')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cars_new');
    }
};
