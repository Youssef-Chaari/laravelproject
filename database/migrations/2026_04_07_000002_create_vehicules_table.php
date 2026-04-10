<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vehicules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('marque_id')->constrained('marques')->cascadeOnDelete();
            $table->string('modele');
            $table->string('slug')->nullable();
            $table->unsignedSmallInteger('annee');
            $table->decimal('prix', 12, 2);
            $table->enum('carburant', ['essence', 'diesel', 'hybride', 'electrique', 'gpl'])->default('essence');
            $table->unsignedSmallInteger('puissance')->nullable();
            $table->unsignedSmallInteger('couple')->nullable();
            $table->enum('transmission', ['manuelle', 'automatique'])->default('manuelle');
            $table->decimal('consommation', 4, 1)->nullable();
            $table->tinyInteger('nb_portes')->default(5);
            $table->tinyInteger('nb_places')->default(5);
            $table->unsignedSmallInteger('volume_coffre')->nullable();
            $table->string('couleur')->nullable();
            $table->string('couleur_bg')->nullable();
            $table->unsignedInteger('kilometrage')->default(0);
            $table->tinyInteger('garantie')->default(2);
            $table->text('description')->nullable();
            $table->json('equipements')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicules');
    }
};
