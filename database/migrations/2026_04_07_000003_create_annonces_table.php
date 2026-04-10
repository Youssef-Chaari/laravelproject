<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('annonces', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('marque_id')->nullable()->constrained('marques')->nullOnDelete();
            $table->string('titre');
            $table->string('modele');
            $table->unsignedSmallInteger('annee');
            $table->unsignedInteger('kilometrage')->default(0);
            $table->decimal('prix', 12, 2);
            $table->enum('carburant', ['essence', 'diesel', 'hybride', 'electrique', 'gpl'])->default('essence');
            $table->text('description')->nullable();
            $table->string('ville')->nullable();
            $table->string('telephone')->nullable();
            $table->enum('statut', ['publie', 'attente', 'rejete'])->default('attente');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('annonces');
    }
};
